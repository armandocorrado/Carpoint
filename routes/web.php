<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\TrovataController;
use App\Http\Controllers\VeicoliController;
use App\Http\Controllers\PiazzaliController;
use App\Http\Controllers\SyncSybaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\RicercaVeicoliController;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\PlateRecognizerController;






Auth::routes();


Route::group(['middleware' => 'auth'], function () {


Route::post('/ocr', [OCRController::class, 'extractText'])->name('ocr');
Route::post('/recognize-plate', [PlateRecognizerController::class, 'recognize']);


// Route::get('/sybase-usati', [SyncSybaseController::class, 'sync_usati']);
// Route::post('/sybase-usati', [SyncSybaseController::class, 'sync_usati']);

Route::get('/sybase-nuovi', [SyncSybaseController::class, 'sync_nuovi']);
Route::post('/sybase-nuovi', [SyncSybaseController::class, 'sync_nuovi']);



// LogoutController   
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//HomeController
 Route::get('/', [HomeController::class, 'home'])->name('home');



//PiazzaliController
Route::get('/ricerca-piazzali', [PiazzaliController::class, 'piazzali'])->name('piazzali');
Route::get('/ricerca-piazzali/ajax', [PiazzaliController::class, 'store'])->name('piazzali.store');



//VeicoliController
Route::get('/aggiungi-veicolo', [VeicoliController::class, 'addveicolo'])->name('new-veicolo');
Route::post('/aggiungi-veicolo', [VeicoliController::class, 'store'])->name('add-veicolo');


// TrovataController
Route::post('/trovata', [TrovataController::class, 'store'])->name('store-trovata'); 
Route::post('/trovata/elimina', [TrovataController::class, 'destroy'])->name('destroy-trovata'); 
Route::post('/trovata/elimina/all', [TrovataController::class, 'destroyAll'])->name('destroy-trovata.all'); 

//Ricerca Veicoli
Route::get('/ricerca-veicoli', [RicercaVeicoliController ::class, 'search'])->name('search.veicoli');  
Route::get('/get-data', [RicercaVeicoliController::class, 'getData'])->name('get-ajax');


// NoteController
Route::post('/note', [NotaController::class, 'store'])->name('note-store');


//ReportController
Route::get('/report-documenti', [ReportController::class, 'index'])->name('report.index');
Route::get('/report-usato', [ReportController::class, 'report_usati'])->name('report.usato');
Route::get('/report-nuovo', [ReportController::class, 'report_nuovi'])->name('report.nuovo');
Route::get('/report-manuali-nuovo', [ReportController::class, 'report_manuali_nuovo'])->name('report.m.nuovo');
Route::get('/report-manuali-usato', [ReportController::class, 'report_manuali_usato'])->name('report.m.usato');
Route::get('/report-tutti', [ReportController::class, 'genera_tutti'])->name('report.all');



// UserController
Route::get('/utenti', [UserController::class, 'utenti'])->name('user');
Route::post('/utenti', [UserController::class, 'store'])->name('user.store');
Route::post('/utenti/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::post('/utenti/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');




//RoleController
// Route::get('/ruoli', [RoleController::class, 'create'])->name('ruoli');
Route::post('/ruoli', [RoleController::class, 'store'])->name('ruoli.store');


//EmailController 
// Route::post('/mail-user-notification', [EmailController::class, 'sendMailUser'])->name('send.mail.user');




// Route::get('/home', [HomeController::class, 'home']);
// Route::get('/ricercaTutti', [HomeController::class, 'ricercaTutti']);


});


 

