<?php

namespace Src\Controllers;

use Src\Entities\User;
use Src\utils\JwtHelper;
use Src\utils\PasswordHelper;
use Src\utils\PostRequestValidator;
use Src\utils\ResponseSender;

require 'bootstrap.php';

class AuthController
{
    public function login() {
        $validator = new PostRequestValidator([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $data = $validator->validate();
            $entityManager = GetEntityManager();

            $userRepository = $entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy([
                'email' => $data['email']
            ]);
            if (!$user || !PasswordHelper::compare($data['password'], $user->getPassword())) {
                ResponseSender::json([
                    'message' => 'invalid_credentials'
                ] );
                return;
            }
            $token = JwtHelper::encode((array) $user);
            ResponseSender::json([
                'message' => 'login_success',
                'data' => compact('token')
            ]);
        } catch (\Exception $exception) {
            ResponseSender::json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}