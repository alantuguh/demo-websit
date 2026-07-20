<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckOverduePeminjaman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'peminjaman:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue peminjaman and update their status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $count = Peminjaman::where('status', 'disetujui')
            ->where('tanggal_kembali', '<', $now)
            ->update(['status' => 'terlambat']);
            
        if ($count > 0) {
            $this->info("Updated $count peminjaman to 'terlambat' status.");
        } else {
            $this->info('No overdue peminjaman found.');
        }
        
        return 0;
    }
}
