<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\MurController;
use App\Http\Controllers\PorteController;
use App\Http\Controllers\FenetreController;
use App\Http\Controllers\MeubleController;

Route::get('/', function () {
    return view('menu');
})->name('menu');

Route::get('/creerChambre', function () {
    return view('creerChambre');
})->name('creerChambre');

Route::get('/ajouterFenetrePorte', function () {
    return view('ajouterFenetrePorte');
})->name('ajouterFenetrePorte');

Route::get('/ajouterMeuble', function () {
    return view('ajouterMeuble');
})->name('ajouterMeuble');

Route::get('/resultatChambre', function () {
    return view('resultatChambre');
})->name('resultatChambre');

Route::post('/creer-chambre', [ChambreController::class, 'creerChambre'])->name('creer-chambre');

Route::post('/enregistrer-mur', [MurController::class, 'creerMur'])->name('enregistrer-mur');

Route::get('/chercher-murs/{idChambre}', [MurController::class, 'chercherMurs']);

Route::get('/chercher-chambre', [ChambreController::class, 'chercherChambres']);

Route::post('/creer-porte', [PorteController::class, 'creerPorte'])->name('creer-porte');

Route::post('/creer-fenetre', [FenetreController::class, 'creerFenetre'])->name('creer-fenetre');

Route::post('/creer-meuble', [MeubleController::class, 'creerMeuble'])->name('creer-meuble');

Route::get('/chercher-portes/{idMur}', [PorteController::class, 'chercherPortes']);

Route::get('/chercher-fenetres/{idMur}', [FenetreController::class, 'chercherFenetres']);

Route::get('/chercher-meubles/{chambreId}', [MeubleController::class, 'chercherMeubles']);

Route::put('/meubles/{id}', [MeubleController::class, 'updateMeuble']);
