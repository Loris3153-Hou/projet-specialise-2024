@extends('layout')

@section('title', 'Menu')

@section('content')
<div id="menu">
    <div id="menu-pres">
        <h1 class="titre-border">Presentation</h1><br><br>
        <div class="menu-creer-back">
            <h2 id="menu-pres-texte">
            Découvrez ce site  conçu pour simplifier l’organisation et l’aménagement de votre chambre en un clin d’œil ! Grâce à lui, vous pouvez maintenant planifier et agencer votre espace en quelques étapes simples. Il vous suffit de fournir les dimensions de votre chambre, ainsi que des fenêtres et des meubles, et notre application se charge du reste. Fini le casse-tête pour trouver la disposition idéale de vos meubles ! Avec une interface conviviale et des fonctionnalités intuitives, ce site vous offre une solution pratique et efficace pour maximiser l’utilisation de votre espace de vie. Transformez votre chambre en un sanctuaire organisé et harmonieux dès aujourd’hui !
            </h2>
        </div>
    </div>
    <div id="menu-creer">
        <h1 class="titre-border">Creer un projet</h1><br><br>
        <button id="creer-chambre-btn"><div class="menu-creer-back" id="menu-creer-plus liencreerChambre">
            <h1 id="menu-creer-plus-texte">+</h1>
        </div></button>
    </div>

    <div id="menu-chambre">
        <h1 id="menu-chambre-titre" class="titre-border">Vos projets</h1><br><br>
        <!--<section id="menu-chambre-loris" class="menu-chambres">
            <h2>Chambre Loris</h2>
            <div class="menu-chambre-image"></div>
        </section>
        <section id="menu-chambre-nolan" class="menu-chambres">
            <h2>Chambre Nolan</h2>
            <div class="menu-chambre-image"></div>
        </section>
        <section id="menu-chambre-mathilde" class="menu-chambres">
            <h2>Chambre Mathilde</h2>
            <div class="menu-chambre-image"></div>
        </section>
        <section id="menu-chambre-ben" class="menu-chambres">
            <h2>Chambre Ben</h2>
            <div class="menu-chambre-image"></div>
        </section>-->
    </div>
</div>
<script>
    document.getElementById('creer-chambre-btn').addEventListener('click', function() {
        event.preventDefault(); 
        fetch('/creer-chambre', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            window.location.href = "{{ route('creerChambre') }}?chambre_id=" + data.chambre;
        })
        .catch(error => {
            console.error('Une erreur s\'est produite:', error);
        });
    });

    var nouvellesChambres = [];
    var menuChambre = document.getElementById("menu-chambre");

    fetch('/chercher-chambre')
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Erreur lors de la récupération des murs');
      }
    })
    .then(data => {
      data.forEach(chambres => {
        nouvellesChambres.push(chambres.id_chambre);
      });
        nouvellesChambres.forEach(function(nomChambre) {
            var nouvelleSection = document.createElement("section");
            nouvelleSection.className = "menu-chambres";
            nouvelleSection.id = nomChambre;

            var titreChambre = document.createElement("h2");
            titreChambre.textContent = 'Chambre ' + nomChambre;

            nouvelleSection.appendChild(titreChambre);

            var divImage = document.createElement("div");
            divImage.className = "menu-chambre-image";

            nouvelleSection.appendChild(divImage);

            menuChambre.appendChild(nouvelleSection);
        });
        var sections = document.querySelectorAll("#menu-chambre .menu-chambres");

        sections.forEach(function(section) {
            section.addEventListener('click', function() {
                window.location.href = "{{ route('resultatChambre') }}?chambre_id=" + section.id; // Vous pouvez remplacer cette action par ce que vous voulez faire
            });
        });
    })
    .catch(error => {
      console.error('Erreur :', error);
    });
</script>
@endsection
