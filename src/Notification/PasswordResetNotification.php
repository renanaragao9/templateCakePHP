<?php

namespace App\Notification;

use Cake\Mailer\Mailer;
use Cake\Routing\Router;

class PasswordResetNotification
{
    public static function send($user, $token)
    {
        $url = Router::url(['controller' => 'Auth', 'action' => 'changePassword', $token], true);
        $content = [
            'Você solicitou a troca de sua senha.',
            'Clique no botão abaixo para redefinir sua senha.',
            'Este link é válido por 1 dia. Após esse período, será necessário solicitar um novo link.'
        ];

        $userName = $user->name ?? 'Usuário';

        $mailer = new Mailer('default');
        $mailer->setTo($user->email)
            ->setSubject('Redefinição de senha')
            ->setEmailFormat('html')
            ->setViewVars(['content' => $content, 'url' => $url, 'userName' => $userName])
            ->viewBuilder()
            ->setTemplate('default');
        $mailer->deliver();
    }
}
