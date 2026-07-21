<?php 
    return
    [
        'confessions' => [ConfessionsController::class, 'index'],
        'confessions/filter' => [ConfessionsController::class, 'filter'],
        'confessions/submit' => [ConfessionsController::class, 'submit'],
        'confessions/report' => [ConfessionsController::class, 'report'],
        
        'heart' => [ConfessionsController::class, 'heart'],

        'auth/login' => [AuthController::class, 'index'],
        'auth/loginUser' => [AuthController::class, 'loginUser'],

        'auth/register' => [AuthController::class, 'register'],
        'auth/registerUser' => [AuthController::class, 'registerUser'],
        
        'auth/logout' => [AuthController::class, 'logout'],
    ];
?>