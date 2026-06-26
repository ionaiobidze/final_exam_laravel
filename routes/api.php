<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class)->names([
    'index'   => 'api.tasks.index',
    'store'   => 'api.tasks.store',
    'show'    => 'api.tasks.show',
    'update'  => 'api.tasks.update',
    'destroy' => 'api.tasks.destroy',
]);
