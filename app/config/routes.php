<?php 
    return
    [
        'confessions' => [ConfessionsController::class, 'index'],
        'confessions/submit' => [ConfessionsController::class, 'submit'],

        'heart' => [ConfessionsController::class, 'heart'],

        'auth/login' => [AuthController::class, 'index'],
        'auth/loginUser' => [AuthController::class, 'loginUser'],

        'auth/register' => [AuthController::class, 'register'],
        'auth/registerUser' => [AuthController::class, 'registerUser'],
        
        'auth/logout' => [AuthController::class, 'logout'],
    ];
?>