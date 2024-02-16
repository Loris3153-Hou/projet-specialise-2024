<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>POC Laravel</title>
    <style>
        * {
            margin:0;
            padding:0;
            font-family: Arial, sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        #css{
            background-color: white;
            color: white;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>POC Laravel</h1>
    <p>Ceci est une page de POC Laravel.</p>
    <button id="bouton-js" data-ajax-url="{{ route('ajax') }}">bouton js</button>
    <button id="bouton-css">bouton css</button>

    <div id="res">

    </div>
    <div id="js">

    </div>
    <div id="css">
        <h1>La couleur a ete changer en CSS !</h1>
    </div>
</div>

<script>
    document.getElementById('bouton-js').addEventListener('click', function() {
        document.getElementById('js').innerHTML = "<h1>Texte afficher avec JS</h1>";
    });

    document.getElementById('bouton-css').addEventListener('click', function() {
        document.getElementById('css').style.backgroundColor = "red";
    });

    document.addEventListener('DOMContentLoaded', function() {

        document.querySelector('#res').innerHTML = 'En attente de la réponse...';
        fetch("{{ route('ajax') }}")
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                document.querySelector('#res').innerHTML = data.message;
            })
            .catch(error => console.error(error));
    });
</script>
</body>
</html>
