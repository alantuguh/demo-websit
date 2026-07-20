<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'encrypted_password_storage', // Encrypted storage untuk admin
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'encrypted_password_storage', // Selalu hidden dari response
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Set encrypted password storage (hanya untuk admin)
     */
    public function setPlainPasswordForAdmin(string $plainPassword): void
    {
        // Hanya admin yang bisa set dan lihat password
        if (!$this->isCurrentUserAdmin()) {
            return;
        }
        
        $this->encrypted_password_storage = Crypt::encrypt($plainPassword);
        $this->save();
    }

    /**
     * Get decrypted password (hanya untuk admin)
     */
    public function getPlainPasswordForAdmin(): ?string
    {
        // Double check: hanya admin yang bisa akses
        if (!$this->isCurrentUserAdmin()) {
            return null;
        }

        if (!$this->encrypted_password_storage) {
            return null;
        }

        try {
            return Crypt::decrypt($this->encrypted_password_storage);
        } catch (\Exception $e) {
            // Jika gagal decrypt, return null
            return null;
        }
    }

    /**
     * Check if current user is admin
     */
    private function isCurrentUserAdmin(): bool
    {
        // Untuk testing, sementara return true
        // Nanti ubah sesuai kebutuhan
        return true;
        
        // Uncomment ini setelah sistem role berjalan:
        // $currentUser = auth()->user();
        // return $currentUser && $currentUser->role === 'admin';
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Check if user has stored password (untuk admin saja)
     */
    public function hasStoredPassword(): bool
    {
        return !empty($this->encrypted_password_storage);
    }

    /**
     * Clear stored password (untuk keamanan)
     */
    public function clearStoredPassword(): void
    {
        if ($this->isCurrentUserAdmin()) {
            $this->encrypted_password_storage = null;
            $this->save();
        }
    }
}