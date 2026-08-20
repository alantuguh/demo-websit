/*
 * Server sinkronisasi multiplayer VR Ergonomy Lab.
 *
 * Implementasi protokol adapter "socketio" milik Networked-A-Frame
 * (diadaptasi dari networked-aframe/server/socketio-server.js v0.14.3):
 * klien mengirim "joinRoom", server membalas "connectSuccess", lalu
 * meneruskan pesan "send" (unicast) dan "broadcast" (satu ruang) begitu
 * saja tanpa membaca isinya. Seluruh state dunia hidup di klien; server
 * ini hanya penyampai pesan, sehingga tidak butuh database apa pun.
 *
 * Jalankan:  npm install && npm start   (dari folder vr-server/)
 * Port:      env PORT, bawaan 8080 — samakan dengan VR_MULTIPLAYER_URL
 *            di .env Laravel (bawaan ws://localhost:8080).
 */
const express = require("express");
const http = require("node:http");

process.title = "lpske-vr-server";

const port = process.env.PORT || 8080;

// Lebih dari ini, pemain baru dialihkan ke instance ruang berikutnya
// (nama ruang diberi akhiran "--2", "--3", dst.) agar satu scene tidak
// kebanjiran avatar.
const maxOccupantsInRoom = 30;

const app = express();

// Halaman Laravel (mis. http://localhost:8000) dan server ini berjalan di
// origin berbeda, jadi socket.io harus mengizinkan lintas origin. Tidak ada
// kredensial/cookie yang dipakai, jadi origin bebas itu aman di sini.
const webServer = http.createServer(app);
const io = require("socket.io")(webServer, {
    cors: { origin: true, methods: ["GET", "POST"] },
});

const rooms = new Map();

// Endpoint pemeriksaan: buka http://localhost:8080/ untuk melihat server
// hidup dan siapa sedang di ruang mana.
app.get("/", (req, res) => {
    res.json({
        ok: true,
        server: "lpske-vr-server",
        rooms: [...rooms.values()].map((room) => ({
            name: room.name,
            occupants: room.occupantsCount,
        })),
    });
});

io.on("connection", (socket) => {
    console.log("terhubung:", socket.id);

    let curRoom = null;

    socket.on("joinRoom", (data) => {
        const { room } = data;

        curRoom = room;
        let roomInfo = rooms.get(room);
        if (!roomInfo) {
            roomInfo = { name: room, occupants: {}, occupantsCount: 0 };
            rooms.set(room, roomInfo);
        }

        if (roomInfo.occupantsCount >= maxOccupantsInRoom) {
            // Ruang penuh — cari instance lain yang masih longgar
            let availableRoomFound = false;
            const roomPrefix = `${room}--`;
            let numberOfInstances = 1;
            for (const [roomName, roomData] of rooms.entries()) {
                if (roomName.startsWith(roomPrefix)) {
                    numberOfInstances++;
                    if (roomData.occupantsCount < maxOccupantsInRoom) {
                        availableRoomFound = true;
                        curRoom = roomName;
                        roomInfo = roomData;
                        break;
                    }
                }
            }

            if (!availableRoomFound) {
                curRoom = `${roomPrefix}${numberOfInstances + 1}`;
                roomInfo = { name: curRoom, occupants: {}, occupantsCount: 0 };
                rooms.set(curRoom, roomInfo);
            }
        }

        const joinedTime = Date.now();
        roomInfo.occupants[socket.id] = joinedTime;
        roomInfo.occupantsCount++;

        console.log(`${socket.id} masuk ruang ${curRoom}`);
        socket.join(curRoom);

        socket.emit("connectSuccess", { joinedTime });
        io.in(curRoom).emit("occupantsChanged", { occupants: roomInfo.occupants });
    });

    socket.on("send", (data) => {
        io.to(data.to).emit("send", data);
    });

    socket.on("broadcast", (data) => {
        socket.to(curRoom).emit("broadcast", data);
    });

    socket.on("disconnect", () => {
        const roomInfo = rooms.get(curRoom);
        if (!roomInfo) return;

        console.log(`${socket.id} keluar dari ruang ${curRoom}`);
        delete roomInfo.occupants[socket.id];
        roomInfo.occupantsCount--;
        socket.to(curRoom).emit("occupantsChanged", { occupants: roomInfo.occupants });

        if (roomInfo.occupantsCount === 0) {
            rooms.delete(curRoom);
        }
    });
});

webServer.listen(port, () => {
    console.log("lpske-vr-server siap di http://localhost:" + port);
});
