<?php
    
    use lib\Route;
    use Controllers\UserController;

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/singup', [UserController::class, 'register']);

    Route::dispatch();