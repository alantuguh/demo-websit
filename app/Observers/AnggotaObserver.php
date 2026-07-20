<?php

namespace App\Observers;

use App\Models\User;

class AnggotaObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        // Cek apakah request dari AnggotaAkunResource dan role adalah anggota
        if ($this->isFromAnggotaResource() && $user->role === 'anggota') {
            $user->role = 'anggota';
            $user->email_verified_at = now();
            
            // Simpan password plain sementara untuk session
            if (request()->has('data.password')) {
                $plainPassword = request()->input('data.password');
                // Kita akan simpan ini setelah user dibuat
                request()->session()->put('pending_password', $plainPassword);
            }
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($this->isFromAnggotaResource() && $user->role === 'anggota') {
            // Ambil password plain dari session sementara
            $plainPassword = request()->session()->pull('pending_password');
            
            if ($plainPassword) {
                $tempPasswords = session('temp_passwords', []);
                $tempPasswords[$user->id] = $plainPassword;
                session(['temp_passwords' => $tempPasswords]);
            }
        }
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        if ($this->isFromAnggotaResource() && $user->role === 'anggota') {
            $user->role = 'anggota';
            
            // Jika email_verified_at kosong, isi dengan waktu sekarang
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = now();
            }
        }
    }

    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        // Hapus password dari session
        $tempPasswords = session('temp_passwords', []);
        unset($tempPasswords[$user->id]);
        session(['temp_passwords' => $tempPasswords]);
    }

    /**
     * Cek apakah request berasal dari AnggotaAkunResource
     */
    private function isFromAnggotaResource(): bool
    {
        return request()->routeIs('filament.admin.resources.anggota-akuns.*') ||
               str_contains(request()->url(), 'anggota-akuns') ||
               request()->header('referer') && str_contains(request()->header('referer'), 'anggota-akuns');
    }
}