<?php 
    return
    [
        'confessions' => [ConfessionsController::class, 'index'],
        'confessions/filter' => [ConfessionsController::class, 'filter'],
        'confessions/submit' => [ConfessionsController::class, 'submit'],
        'confessions/report' => [ConfessionsController::class, 'report'],
        'heart' => [ConfessionsController::class, 'heart'],

        'moderator/panel' => [ModeratorController::class, 'index'],
        'moderator/approve' => [ModeratorController::class, 'approve'],
        'moderator/reject' => [ModeratorController::class, 'reject'],
        'moderator/returnToQueue' => [ModeratorController::class, 'returnToQueue'],

        '' => [AuthController::class, 'index'],
        'auth/login' => [AuthController::class, 'index'],
        'auth/loginUser' => [AuthController::class, 'loginUser'],
        'auth/register' => [AuthController::class, 'register'],
        'auth/registerUser' => [AuthController::class, 'registerUser'],
        'auth/forgotPassword' => [AuthController::class, 'forgotPassword'],
        'auth/sendPasswordReset' => [AuthController::class, 'sendPasswordReset'], 
        'auth/reset' => [AuthController::class, 'resetPasswordForm'],
        'auth/resetPassword' => [AuthController::class, 'resetPassword'],
        'auth/logout' => [AuthController::class, 'logout'],
    ];
?>