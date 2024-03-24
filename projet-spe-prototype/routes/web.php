<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\MurController;
use App\Http\Controllers\PorteController;
use App\Http\Controllers\FenetreController;
use App\Http\Controllers\MeubleController;

Route::get('/page1', function () {
    return view('page1');
})->name('page1');

Route::get('/page2', function () {
    return view('page2');
})->name('page2');

Route::get('/page3', function () {
    return view('page3');
})->name('page3');

Route::get('/page4', function () {
    return view('page4');
})->name('page4');

Route::get('/page5', function () {
    return view('page5');
})->name('page5');

Route::post('/creer-chambre', [ChambreController::class, 'creerChambre'])->name('creer-chambre');

Route::post('/enregistrer-mur', [MurController::class, 'creerMur'])->name('enregistrer-mur');

Route::get('/chercher-murs/{idChambre}', [MurController::class, 'chercherMurs']);

Route::post('/creer-porte', [PorteController::class, 'creerPorte'])->name('creer-porte');

Route::post('/creer-fenetre', [FenetreController::class, 'creerFenetre'])->name('creer-fenetre');

Route::post('/creer-meuble', [MeubleController::class, 'creerMeuble'])->name('creer-meuble');

Route::get('/chercher-portes/{idMur}', [PorteController::class, 'chercherPortes']);

Route::get('/chercher-fenetres/{idMur}', [FenetreController::class, 'chercherFenetres']);

Route::get('/chercher-meubles/{chambreId}', [MeubleController::class, 'chercherMeubles']);
