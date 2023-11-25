<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\JornadaLaboralController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('profile/username',[HomeController::class,'show'])->middleware('auth')->name('profile.show');
Route::get('change/password',[HomeController::class,'show'])->middleware('auth')->name('changepassword.show');

//jornadaLaboral
Route::get('jornada_laborals',[JornadaLaboralController::class,'index'])->middleware('auth')->name('jornada_laborals.horastrabajadas');
Route::get('jornada_laborals/suma',[JornadaLaboralController::class,'suma'])->middleware('auth')->name('jornada_laborals.suma');
Route::post('jornada_laborals',[JornadaLaboralController::class,'store'])->middleware('auth')->name('jornada_laborals.store');
Route::put('jornada_laborals/{jornada_laboral}',[JornadaLaboralController::class,'update'])->middleware('auth')->name('jornada_laborals.update');


Route::resource('roles', RoleController::class)->names('roles');
Route::resource('users', RegisteredUserController::class)->names('usuarios');

//Route::put('users/estatus/{usuario}', [RegisteredUserController::class,'estatus'])->name('usuarios.estatus');
//Route::get('users/{id}/sofDelete',[UserController::class,'sofDelete'])->middleware('auth')->name('usuarios.sofDelete');
//Route::get('users/{id}/restore',[UserController::class,'restore'])->middleware('auth')->name('usuarios.restore');

Route::get('/clientes', function () {
    return view('admin.clientes.index');
})->middleware(['auth'])->name('clientes');


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
