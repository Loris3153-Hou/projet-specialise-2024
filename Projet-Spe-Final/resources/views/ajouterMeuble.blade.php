@extends('layout')

@section('title', 'Page 4')

@section('content')
<div id="ajouterMeuble">
    <div id="ajouterMeuble-det">
        <h1 class="titre-border">Etape 3/3 - Ajouter les meubles de votre chambre</h1><br><br>
        <table>
          <tr>
            <td>
              <form action="" method="get" class="ajouterMeuble-det-col">
                <h3>Lit</h3>
                <label for="larg-lit">Largeur  (en cm):</label>
                <input type="text" name="larg-lit" id="larg-lit">
                <label for="long-lit">Longueur  (en cm):</label>
                <input type="text" name="long-lit" id="long-lit">
                <label for="haut-lit">Hauteur  (en cm):</label>
                <input type="text" name="haut-lit" id="haut-lit">
                <input type="button" id="form-lit" value="Ajouter +" class="ajouterFenetrePorte-info-form-button">
              </form>
            </td>
          </tr>
          <tr>
            <td>
              <form action="" method="get" class="ajouterMeuble-det-col">
                <h3>Table de nuit</h3>
                <label for="larg-table">Largeur  (en cm):</label>
                <input type="text" name="larg-table" id="larg-table">
                <label for="long-table">Longueur  (en cm):</label>
                <input type="text" name="long-table" id="long-table">
                <label for="haut-table">Hauteur  (en cm):</label>
                <input type="text" name="haut-table" id="haut-table">
                <input type="button" id="form-table" value="Ajouter +" class="ajouterFenetrePorte-info-form-button">
              </form>
            </td>
          </tr>
          <tr>
            <td>
              <form action="" method="get" class="ajouterMeuble-det-col">
                <h3>Bureau</h3>
                <label for="larg-bureau">Largeur  (en cm):</label>
                <input type="text" name="larg-bureau" id="larg-bureau">
                <label for="long-bureau">Longueur  (en cm):</label>
                <input type="text" name="long-bureau" id="long-bureau">   
                <label for="haut-bureau">Hauteur  (en cm):</label>
                <input type="text" name="haut-bureau" id="haut-bureau">
                <input type="button" id="form-bureau" value="Ajouter +" class="ajouterFenetrePorte-info-form-button">
              </form>           
            </td>
          </tr>
          <tr>
            <td>
              <form action="" method="get" class="ajouterMeuble-det-col">
                <h3>Autres</h3>
                <label for="larg-autres">Largeur  (en cm):</label>
                <input type="text" name="larg-autres" id="larg-autres">
                <label for="long-autres">Longueur  (en cm):</label>
                <input type="text" name="long-autres" id="long-autres">      
                <label for="haut-autres">Hauteur  (en cm):</label>
                <input type="text" name="haut-autres" id="haut-autres">
                <input type="button" id="form-autres" value="Ajouter +" class="ajouterFenetrePorte-info-form-button">
              </form>        
            </td>
          </tr>
        </table>
      </div>
      <div id="ajouterMeuble-nav">
        <button id="retour">Retour <--</button>
        <button id="suivant">Suivant --></button>
      </div>
      
      <div id="ajouterMeuble-info">
        <table id="table-info">
          <tr>
            <th>Num</th>
            <th>Type</th>
            <th>Taille (L*l*h) (en cm)</th>
          </tr>
          <!-- Ajoutez autant de lignes que nécessaire -->
        </table>
      </div>
</div>
<script>
  const urlParams = new URLSearchParams(window.location.search);
  const chambreId = urlParams.get('chambre_id');

  let nbLigne = 1;

  const formLit = document.getElementById('form-lit');
  const formTable= document.getElementById('form-table');
  const formBureau = document.getElementById('form-bureau');
  const formAutres= document.getElementById('form-autres');

  formLit.addEventListener('click', async function() {
      event.preventDefault();

      const largLit = document.getElementById('larg-lit').value;
      const longLit = document.getElementById('long-lit').value;
      const hautLit = document.getElementById('haut-lit').value;
      
      document.getElementById('larg-lit').value = "";
      document.getElementById('long-lit').value = "";
      document.getElementById('haut-lit').value = "";

      const donnees = {
          id_chambre: chambreId,
          largeur_meuble: largLit,
          longueur_meuble: longLit,
          hauteur_meuble: hautLit,
          type_meuble: "Lit"
      };

      ajouterLigneTableau(longLit, largLit, hautLit, "Lit");

      await fetch('/creer-meuble', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(donnees)
        })
        .then(response => {
            if (response.ok) {
                console.log('Données envoyées avec succès à la base de données');
            } else {
                console.error('Erreur lors de l\'envoi des données à la base de données');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données à la base de données:', error);
        });
  });

  formTable.addEventListener('click', async function() {
      event.preventDefault();

      const largTable = document.getElementById('larg-table').value;
      const longTable = document.getElementById('long-table').value;
      const hautTable = document.getElementById('haut-table').value;
      
      document.getElementById('larg-table').value = "";
      document.getElementById('long-table').value = "";
      document.getElementById('haut-table').value = "";

      const donnees = {
          id_chambre: chambreId,
          largeur_meuble: largTable,
          longueur_meuble: longTable,
          hauteur_meuble: hautTable,
          type_meuble: "Table"
      };

      ajouterLigneTableau(longTable, largTable, hautTable, "Table");

      await fetch('/creer-meuble', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(donnees)
        })
        .then(response => {
            if (response.ok) {
                console.log('Données envoyées avec succès à la base de données');
            } else {
                console.error('Erreur lors de l\'envoi des données à la base de données');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données à la base de données:', error);
        });
  });

  formBureau.addEventListener('click', async function() {
      event.preventDefault();

      const largBureau = document.getElementById('larg-bureau').value;
      const longBureau = document.getElementById('long-bureau').value;
      const hautBureau = document.getElementById('haut-bureau').value;
      
      document.getElementById('larg-bureau').value = "";
      document.getElementById('long-bureau').value = "";
      document.getElementById('haut-bureau').value = "";

      const donnees = {
          id_chambre: chambreId,
          largeur_meuble: largBureau,
          longueur_meuble: longBureau,
          hauteur_meuble: hautBureau,
          type_meuble: "Bureau"
      };

      ajouterLigneTableau(longBureau, largBureau, hautBureau, "Bureau");

      await fetch('/creer-meuble', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(donnees)
        })
        .then(response => {
            if (response.ok) {
                console.log('Données envoyées avec succès à la base de données');
            } else {
                console.error('Erreur lors de l\'envoi des données à la base de données');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données à la base de données:', error);
        });
  });

  formAutres.addEventListener('click', async function() {
      event.preventDefault();

      const largAutres = document.getElementById('larg-autres').value;
      const longAutres = document.getElementById('long-autres').value;
      const hautAutres = document.getElementById('haut-autres').value;
      
      document.getElementById('larg-autres').value = "";
      document.getElementById('long-autres').value = "";
      document.getElementById('haut-autres').value = "";

      const donnees = {
          id_chambre: chambreId,
          largeur_meuble: largAutres,
          longueur_meuble: longAutres,
          hauteur_meuble: hautAutres,
          type_meuble: "Autres"
      };

      ajouterLigneTableau(longAutres, largAutres, hautAutres, "Autres");

      await fetch('/creer-meuble', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(donnees)
        })
        .then(response => {
            if (response.ok) {
                console.log('Données envoyées avec succès à la base de données');
            } else {
                console.error('Erreur lors de l\'envoi des données à la base de données');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données à la base de données:', error);
        });
  });

  function ajouterLigneTableau(longueur, largeur, hauteur, type) {
    var table = document.getElementById("table-info");
    var ligne = table.insertRow(-1);

    var cell1 = ligne.insertCell(0);
    var cell2 = ligne.insertCell(1);
    var cell3 = ligne.insertCell(2);

    cell1.innerHTML = nbLigne;
    cell2.innerHTML = type;
    cell3.innerHTML = longueur + "*" + largeur + "*" + hauteur;

    nbLigne++;
  }

  document.getElementById('suivant').addEventListener('click', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const chambreId = urlParams.get('chambre_id');

    window.location.href = "{{ route('resultatChambre') }}?chambre_id=" + chambreId;
  
  });

  document.getElementById('retour').addEventListener('click', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const chambreId = urlParams.get('chambre_id');

    window.location.href = "{{ route('ajouterFenetrePorte') }}?chambre_id=" + chambreId;
  
  });

</script>
@endsection