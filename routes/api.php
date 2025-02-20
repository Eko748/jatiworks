<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->get('/getdatauser', [UserController::class, 'getdatauser'])->name('getdatauser');


?>
