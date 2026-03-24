<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NoteController::class, 'index'])->name('note.index');

Route::get('/create', [NoteController::class, 'create'])->name('note.create');

Route::post('/store', [NoteController::class, 'store'])->name(('note.store'));

Route::get('/edit/{note}', [NoteController::class, 'edit'])->name('note.edit');

Route::put('/update/{note}', [NoteController::class, 'update'])->name('note.update');

Route::delete('/delete/{note}', [NoteController::class, 'destroy'])->name('note.delete');