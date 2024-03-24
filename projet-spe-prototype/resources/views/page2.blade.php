@extends('layout')

@section('title', 'Page 2')

@section('content')
<div id="page2">
    <div id="page2-dess">
        <h1 class="titre-border">Dessiner votre chambre</h1><br><br>
        <div id="page2-dess-zone">

        </div>
      </div>
      <div id="page2-nav">
        <button id="retour">Retour <--</button>
        <button id="suivant">Suivant --></button>
      </div>
      
      <div id="page2-info">
        <form id="modif-info" method="post">
          <table id="tableau-info">
            <tr>
              <th>Num</th>
              <th>Taille</th>
              <th>Hauteur Min</th>
            </tr>
          </table>
      </div>
</div>
<script>
  const urlParams = new URLSearchParams(window.location.search);
  const chambreId = urlParams.get('chambre_id');

  const divDessin = document.getElementById("page2-dess-zone");
  var derPointX = 0;
  var derPointY = 0;
  var actPointX = 0;
  var actPointY =  0;
  let remove = false;
  var nbLigne = 1;

  let longueurTab = [];
  let hauteurTab = [];
  let debutXTab = [];
  let debutYTab = [];
  let finXTab = [];
  let finYTab = [];  
  
  divDessin.addEventListener("click", dessin);
  
  function dessin(oEvent){
    
    actPointX = oEvent.clientX; 
    actPointY = oEvent.clientY;     

    if(!remove){
      if( derPointX == 0){
        creerPoint(actPointX, actPointY);
        derPointX = actPointX;
        derPointY = actPointY;
        prePointX = actPointX;
        prePointY = actPointY;
      }
      else {
        if(Math.sqrt(Math.pow(actPointX - prePointX, 2) + Math.pow(actPointY - prePointY, 2)) < 15){
          actPointX = prePointX;
          actPointY = prePointY;
          remove = true;
          debutXTab.push(derPointX);
          debutYTab.push(derPointY);
          finXTab.push(actPointX);
          finYTab.push(actPointY);
          creerDroiteFin(derPointX, derPointY, actPointX, actPointY);
        }else {
          creerDroite(derPointX, derPointY, actPointX, actPointY).then((nouvellesCoordonnees) => {
            actPointX = nouvellesCoordonnees.x;
            actPointY = nouvellesCoordonnees.y;
            debutXTab.push(derPointX);
            debutYTab.push(derPointY);
            finXTab.push(actPointX);
            finYTab.push(actPointY);
            creerPoint(actPointX, actPointY);
            derPointX = actPointX;
            derPointY = actPointY;
          });
        }        
      }
    }
  }

  function creerPoint(pointX, pointY){

    var point = document.createElement("point");

    point.style.width = '5px';
    point.style.height = '5px';
    point.style.background = 'black';
    point.style.position = 'absolute';
    point.style.left = pointX + 'px';
    point.style.top = pointY + 'px';

    document.body.appendChild(point);
  }

  function creerDroite(derPointX, derPointY, actPointX, actPointY){

    var droite = document.createElement('div');
    var angle = Math.atan2(actPointY - derPointY, actPointX - derPointX) * 180 / Math.PI;

    return new Promise((resolve, reject) => {
      popupMur().then((valeurs) => {
        
        var longueur = valeurs.longueur;
        var hauteur = valeurs.hauteur;

        console.log('hauteur ' + hauteur);
        droite.style.width = longueur + 'px';
        droite.style.height = '2px';
        droite.style.position = 'absolute';
        droite.style.background = 'blue';
        droite.style.left = derPointX + 'px';
        droite.style.top = derPointY + 'px';    
        droite.style.transformOrigin = 'left top';
        droite.style.transform = 'rotate(' + angle + 'deg)';
        
        var nouvellesCoordonnees = calculerCoordonneesDepart(derPointX, derPointY, longueur, angle);
        
        document.body.appendChild(droite);

        resolve(nouvellesCoordonnees);

        ajouterLigneTableau(longueur, hauteur);
      });
    });
  }

  function creerDroiteFin(derPointX, derPointY, actPointX, actPointY){

    var droite = document.createElement('div');
    var angle = Math.atan2(actPointY - derPointY, actPointX - derPointX) * 180 / Math.PI;
    const longueur = Math.sqrt(Math.pow(actPointX - derPointX, 2) + Math.pow(actPointY - derPointY, 2));

    return new Promise((resolve, reject) => {
      popupMur().then((valeurs) => {

        var hauteur = valeurs.hauteur;
        console.log('hauteur ' + hauteur);
        droite.style.width = longueur + 'px';
        droite.style.height = '2px';
        droite.style.position = 'absolute';
        droite.style.background = 'blue';
        droite.style.left = derPointX + 'px';
        droite.style.top = derPointY + 'px';    
        droite.style.transformOrigin = 'left top';
        droite.style.transform = 'rotate(' + angle + 'deg)';
        
        var nouvellesCoordonnees = calculerCoordonneesDepart(derPointX, derPointY, longueur, angle);
        
        document.body.appendChild(droite);

        resolve(nouvellesCoordonnees);

        ajouterLigneTableau(longueur, hauteur);
      });
    });
  }

  function calculerCoordonneesDepart(xDepart, yDepart, longueur, angleDegres) {

    var angleRadians = angleDegres * Math.PI / 180;

    var xArrivee = xDepart + longueur * Math.cos(angleRadians);
    var yArrivee = yDepart + longueur * Math.sin(angleRadians);

    return { x: xArrivee, y: yArrivee };
  }

  function popupMur(){
    return new Promise((resolve, reject) => {
      const formContainer = document.createElement('div');
      formContainer.style.position = 'fixed';
      formContainer.style.top = '0';
      formContainer.style.left = '0';
      formContainer.style.width = '100%';
      formContainer.style.height = '100%';
      formContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
      formContainer.style.display = 'flex';
      formContainer.style.justifyContent = 'center';
      formContainer.style.alignItems = 'center';

      const form = document.createElement('form');
      form.style.backgroundColor = '#fff';
      form.style.padding = '20px';
      form.style.borderRadius = '8px';

      const input1 = document.createElement('input');
      input1.type = 'text';
      input1.placeholder = 'Entrez la largeur du mur';
      input1.style.display = 'block';
      input1.style.marginBottom = '10px';
      input1.style.width = '80%';

      const input2 = document.createElement('input');
      input2.type = 'text';
      input2.placeholder = 'Entrez la hauteur du mur';
      input2.style.display = 'block';
      input2.style.marginBottom = '10px';
      input2.style.width = '80%';

      const submitButton = document.createElement('button');
      submitButton.type = 'submit';
      submitButton.textContent = 'Soumettre';
      submitButton.style.display = 'block';
      submitButton.style.width = '60%';

      form.appendChild(input1);
      form.appendChild(input2);
      form.appendChild(submitButton);

      formContainer.appendChild(form);

      document.body.appendChild(formContainer);

      form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const longueur = input1.value;
        const hauteur = input2.value;

        document.body.removeChild(formContainer);

        resolve({ longueur, hauteur });
        });
    });
  }

  function utiliserValeurs(valeurs) {
    console.log('Première information dans utiliserValeurs :', valeurs.longueur);
    console.log('Deuxième information dans utiliserValeurs :', valeurs.hauteur);
    // Vous pouvez utiliser les valeurs comme vous le souhaitez ici

    return Promise.resolve({ longueur: valeurs.longueur, hauteur: valeurs.hauteur });
  }

  function ajouterLigneTableau(longueur, hauteur) {
    var table = document.getElementById("tableau-info");
    var ligne = table.insertRow(-1);

    var cell1 = ligne.insertCell(0);
    var cell2 = ligne.insertCell(1);
    var cell3 = ligne.insertCell(2);

    cell1.innerHTML = nbLigne;
    cell2.innerHTML = longueur;
    cell3.innerHTML = hauteur;

    longueurTab.push(longueur);
    hauteurTab.push(hauteur);

    nbLigne++;
  }

  async function envoyerDonneesBDD() {
    const urlParams = new URLSearchParams(window.location.search);
    const chambreId = urlParams.get('chambre_id');
    const confirmation = confirm("Êtes-vous sûr de vouloir continuer ?");

    if (confirmation) {
      for (let i = 1; i <= nbLigne; i++) {
        const donnees = {
          id_chambre: chambreId,
          num_mur: i,
          hauteur_mur: hauteurTab[i - 1],
          longeur_mur: longueurTab[i - 1],
          debut_x_mur: debutXTab[i - 1], 
          debut_y_mur: debutYTab[i - 1],
          fin_x_mur: finXTab[i - 1],
          fin_y_mur: finYTab[i - 1]   
      };

       await fetch('/enregistrer-mur', {
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
      }
      console.log("id de la ch " + chambreId);
      window.location.href = "{{ route('page3') }}?chambre_id=" + chambreId;
    }
  }
  document.getElementById('suivant').addEventListener('click', function() {
      envoyerDonneesBDD();
  
  });
</script>
@endsection