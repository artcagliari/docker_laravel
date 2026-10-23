<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::apiResource('tarefas', TarefaController::class);
