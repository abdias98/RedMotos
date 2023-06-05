<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'auth'], function (){
    Route::get('/', \App\Http\Livewire\Inicio::class)->name('inicio');
    Route::get('/usuarios', \App\Http\Livewire\Usuarios::class)->name('usuarios');
    Route::get('/personas', \App\Http\Livewire\Personas::class)->name('personas');
    Route::get('/equipos', \App\Http\Livewire\Equipos::class)->name('equipos');
    Route::get('/proyectos', \App\Http\Livewire\Proyectos::class)->name('proyectos');
    Route::get('/tareas', \App\Http\Livewire\Tareas::class)->name('tareas');
    Route::get('/reportes', \App\Http\Livewire\Reportes::class)->name('reportes');
});

Auth::routes();

