<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\Admin\RegisteredUserController;
use App\Http\Controllers\Auth\Client\RegisteredClientController;
use App\Http\Controllers\Client\ClientDashboardController;

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClientFormationController;
use App\Http\Controllers\Formateur\FormateurController;
use App\Http\Controllers\Formation\FormationController;
use App\Http\Controllers\Inscription\InscriptionController;
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


require __DIR__ . '/auth.php';
Route::get('formation', [ClientFormationController::class, "index"])
    ->name('formation');


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::group(['middleware' => ['verified:client.verification.notice']], function () {
        Route::get('/showClientUser', [ClientController::class, "show"])
            ->name('showClientUser.index');
    });

});
Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth:admin', 'verified:admin.verification.notice']], function () {
        Route::get("/", [AdminDashboardController::class, "index"])->name("home");
        Route::get("/users", [UserController::class, "index"])
            ->name("users.index");
        Route::get('/showUser', [UserController::class, "show"])
            ->name('user.index');
        Route::get('/editPictures', [UserController::class, "editPictures"])
            ->name('pictures.edit');
        Route::put('/updateLogo', [UserController::class, "updateLogo"])
            ->name('logo.update');
        Route::put('/updateBackground', [UserController::class, "updateBackground"])
            ->name('background.update');
        Route::post('/register', [RegisteredUserController::class, "store"])
            ->name('register');
        Route::put('/users/{user?}', [UserController::class, "update"])
            ->name('users.update');
        Route::put('/usersChangePassword', [UserController::class, "changePasswordAccount"])
            ->name('users.changePasswordAccount');
        Route::get('/users/{user?}', [UserController::class, "desactivateAccount"])
            ->name('users.desactivateAccount');
        //{{--client router--}}
        Route::get('/showUser', [ClientController::class, "show"])
            ->name('user.index');
        Route::get('/editPictures', [ClientController::class, "editPictures"])
            ->name('pictures.edit');
        Route::put('/updateLogo', [ClientController::class, "updateLogo"])
            ->name('logo.update');
        Route::put('/updateBackground', [ClientController::class, "updateBackground"])
            ->name('background.update');

        Route::post('/register', [ClientController::class, "store"])
            ->name('register');
        Route::get("/clients", [ClientController::class, "index"])
            ->name("clients.index");
        Route::put('/clients/{client?}', [ClientController::class, "update"])
            ->name('clients.update');
        Route::put('/clientsChangePassword', [ClientController::class, "changePasswordAccount"])
            ->name('clients.changePasswordAccount');
        Route::get('/clients/{client?}', [ClientController::class, "desactivateAccount"])
            ->name('clients.desactivateAccount');
        //{{--formateur router--}}
        Route::post('/formateur', [FormateurController::class, "store"])
            ->name('formateur.store');
        Route::get("/formateurs", [FormateurController::class, "index"])
            ->name("formateurs.index");
        Route::put('/formateurs/{formateur?}', [FormateurController::class, "update"])
            ->name('formateurs.update');
        Route::get('/formateur/{formateur?}', [FormateurController::class, "desactivateAccount"])
            ->name('formateurs.desactivateAccount');
        //{{--formation router--}}
        Route::get("/formations", [FormationController::class, "index"])
            ->name("formations.index");
        Route::post('/formation', [FormationController::class, "store"])
            ->name('formation.store');
        Route::put('/formations/{formation?}', [FormationController::class, "update"])
            ->name('formations.update');
        Route::delete('/formations/{formation?}', [FormationController::class, "destroy"])
            ->name('formations.destroy');
        //{{--inscription router--}}
        Route::get("/inscriptions", [InscriptionController::class, "index"])
            ->name("inscriptions.index");
        Route::post('/inscription', [InscriptionController::class, "store"])
            ->name('inscription.store');
        Route::put('/inscriptions/{inscription?}', [InscriptionController::class, "update"])
            ->name('inscriptions.update');
        Route::delete('/inscriptions/{inscription?}', [InscriptionController::class, "destroy"])
            ->name('inscriptions.destroy');
    });
    require __DIR__ . '/authAdmin.php';
});

