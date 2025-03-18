<?php

namespace App\Event;

use Cake\Event\EventListenerInterface;
use App\Notification\PasswordResetNotification;

class PasswordResetObserver implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'Model.Users.afterPasswordReset' => 'onPasswordReset',
        ];
    }

    public function onPasswordReset($event, $user, $token)
    {
        PasswordResetNotification::send($user, $token);
    }
}
