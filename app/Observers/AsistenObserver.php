<?php

namespace App\Observers;

use App\Models\User;

class AsistenObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        // Cek apakah request dari AsistenAkunResource dan role adalah asisten
        if ($this->isFromAsistenResource() && $user->role === 'asisten') {
            $user->role = 'asisten';
            $user->email_verified_at = now();
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($this->isFromAsistenResource() && $user->role === 'asisten') {
            // Asisten tidak memerlukan foto atau data tambahan
            // Data asisten untuk tampilan di beranda dibuat terpisah di tabel teams
        }
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        if ($this->isFromAsistenResource() && $user->role === 'asisten') {
            $user->role = 'asisten';
            
            // Jika email_verified_at kosong, isi dengan waktu sekarang
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = now();
            }
        }
    }

    /**
     * Cek apakah request berasal dari AsistenAkunResource
     */
    private function isFromAsistenResource(): bool
    {
        return request()->routeIs('filament.admin.resources.asisten-akuns.*') ||
               str_contains(request()->url(), 'asisten-akuns') ||
               request()->header('referer') && str_contains(request()->header('referer'), 'asisten-akuns');
    }
} 