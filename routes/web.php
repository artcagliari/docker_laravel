<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

Route::resource('/tarefas', TarefaController::class);