<?php

namespace App\Observers;

use App\Models\LoginLog;

class LoginObserver
{
    public function login($user)
    {
        LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'login_at' => now()
        ]);
    }
}
