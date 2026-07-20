<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Support\Arrayable;

class RoleUserProvider extends EloquentUserProvider
{
    protected $roleCondition;

    public function __construct($hasher, $model, $roleCondition = null)
    {
        parent::__construct($hasher, $model);
        $this->roleCondition = $roleCondition;  
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || (count($credentials) === 1 && str_contains(array_key_first($credentials), 'password'))) {
            return;
        }

        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (str_contains($key, 'password')) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        // Add role condition
        if ($this->roleCondition) {
            $query->where('role', $this->roleCondition);
        }

        return $query->first();
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        // Additional validation for role
        if ($this->roleCondition && $user->role !== $this->roleCondition) {
            return false;
        }

        return parent::validateCredentials($user, $credentials);
    }
}