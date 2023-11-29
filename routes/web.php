<?php

use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TareaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\JornadaLaboralController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('profile/username',[HomeController::class,'show'])->middleware('auth')->name('profile.show');
Route::get('change/password',[HomeController::class,'show'])->middleware('auth')->name('changepassword.show');

//jornadaLaboral
Route::get('jornada_laborals',[JornadaLaboralController::class,'index'])->middleware('auth')->name('jornada_laborals.horastrabajadas');
Route::get('jornada_laborals/suma',[JornadaLaboralController::class,'suma'])->middleware('auth')->middleware('can:administrador')->name('jornada_laborals.suma');
Route::post('jornada_laborals',[JornadaLaboralController::class,'store'])->middleware('auth')->middleware('can:administrador')->name('jornada_laborals.store');
Route::put('jornada_laborals/{jornada_laboral}',[JornadaLaboralController::class,'update'])->middleware('auth')->middleware('can:administrador')->name('jornada_laborals.update');


Route::resource('roles', RoleController::class)->middleware('can:administrador')->names('roles');
Route::resource('users', RegisteredUserController::class)->middleware('can:administrador')->names('usuarios');

//Route::put('users/estatus/{usuario}', [RegisteredUserController::class,'estatus'])->name('usuarios.estatus');
//Route::get('users/{id}/sofDelete',[UserController::class,'sofDelete'])->middleware('auth')->name('usuarios.sofDelete');
//Route::get('users/{id}/restore',[UserController::class,'restore'])->middleware('auth')->name('usuarios.restore');

Route::get('/clientes', function () {
    return view('admin.clientes.index');
})->middleware(['auth','can:administrador'])->name('clientes');

Route::get('clientes/create',[ClienteController::class,'create'])->middleware('auth')->middleware('can:administrador')->name('clientes.create');
Route::post('clientes',[ClienteController::class,'store'])->middleware('auth')->middleware('can:administrador')->name('clientes.store');
Route::get('clientes/{id}/edit',[ClienteController::class,'edit'])->middleware('auth')->middleware('can:administrador')->name('clientes.edit');
Route::put('clientes/{cliente}',[ClienteController::class,'update'])->middleware('auth')->middleware('can:administrador')->name('clientes.update'); 

//tareas
/*
Route::get('/tareas', function () {
    return view('admin.tareas.index');
})->middleware(['auth','can:administrador'])->name('tareas');

Route::get('tareas/create',[TareaController::class,'create'])->middleware('auth')->middleware('can:administrador')->name('tareas.create');
Route::post('tareas',[TareaController::class,'store'])->middleware('auth')->middleware('can:administrador')->name('tareas.store');
Route::get('tareas/{id}/edit',[TareaController::class,'edit'])->middleware('auth')->middleware('can:administrador')->name('tareas.edit');
Route::put('tareas/{tarea}',[TareaController::class,'update'])->middleware('auth')->middleware('can:administrador')->name('tareas.update'); 
*/
Route::resource('tareas', TareaController::class)->middleware('can:administrador')->names('tareas');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
