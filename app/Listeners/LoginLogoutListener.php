<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginLogoutListener
{
    public function handle($event)
    {
        $user = $event->user;
        $action = $event instanceof Login ? 'login' : 'logout';

        // Insert into the user activity log
        DB::connection('oracle')->table('user_activity_logs')->insert([
            'user_id'    => $user->id,
            'username'   => $user->name,
            'action'     => $action,
            'email'      => $user->email,           
            'role_id'    => $user->role_id,    
            'created_at' => now()->setTimezone('Asia/Phnom_Penh'), 
            // 'created_at' => now(),
        ]);
    }
  
}
