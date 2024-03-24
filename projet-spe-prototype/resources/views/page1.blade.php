@extends('layout')

@section('title', 'Page 1')

@section('content')
<div id="page1">
    <div id="page1-pres">
        <h1 class="titre-border">Presentation</h1><br><br>
        <div class="page1-creer-back">
            <p id="page1-pres-texte">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident qui laboriosam rerum et recusandae architecto alias ea praesentium, tempore voluptas ipsum cupiditate iure optio doloremque asperiores iste animi facilis. Esse?
            </p>
        </div>
    </div>
    <div id="page1-creer">
        <h1 class="titre-border">Creer un projet</h1><br><br>
        <button id="creer-chambre-btn"><div class="page1-creer-back" id="page1-creer-plus lienPage2">
            <h1 id="page1-creer-plus-texte">+</h1>
        </div></button>
    </div>

    <div id="page1-chambre">
        <h1 id="page1-chambre-titre" class="titre-border">Vos projets</h1><br><br>
        <section id="page1-chambre-loris" class="page1-chambres">
            <h2>Chambre Loris</h2>
            <div class="page1-chambre-image"></div>
        </section>
        <section id="page1-chambre-nolan" class="page1-chambres">
            <h2>Chambre Nolan</h2>
            <div class="page1-chambre-image"></div>
        </section>
        <section id="page1-chambre-mathilde" class="page1-chambres">
            <h2>Chambre Mathilde</h2>
            <div class="page1-chambre-image"></div>
        </section>
        <section id="page1-chambre-ben" class="page1-chambres">
            <h2>Chambre Ben</h2>
            <div class="page1-chambre-image"></div>
        </section>
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
            window.location.href = "{{ route('page2') }}?chambre_id=" + data.chambre;
        })
        .catch(error => {
            console.error('Une erreur s\'est produite:', error);
        });
    });
</script>
@endsection
