<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

// Machine-to-machine consumer of the master-data API (e.g. management-nilai).
// Not a login-capable user — carries Sanctum tokens only. Implements the
// Authenticatable contract (rather than extending Laravel's concrete
// Authenticatable/User base) so Auth-adjacent middleware (e.g. throttle,
// which calls $request->user()->getAuthIdentifier()) works correctly,
// without pulling in password/remember-token/notification machinery
// meant for human logins.
#[Fillable(['name', 'is_active'])]
class ApiClient extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword(): ?string
    {
        return null;
    }

    public function getRememberToken(): ?string
    {
        return null;
    }

    public function setRememberToken($value): void
    {
        // No-op: ApiClient does not support "remember me" sessions.
    }

    public function getRememberTokenName(): string
    {
        return '';
    }
}
