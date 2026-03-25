<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [NoteController::class, 'index'])->name('note.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [NoteController::class, 'create'])->name('note.create');
        Route::post('/store', [NoteController::class, 'store'])->name('note.store');
        Route::delete('/delete/{note}', [NoteController::class, 'destroy'])->name('note.delete');
    });

    Route::get('/edit/{note}', [NoteController::class, 'edit'])->name('note.edit');
    Route::put('/update/{note}', [NoteController::class, 'update'])->name('note.update');
});

Route::redirect('/home', '/');
