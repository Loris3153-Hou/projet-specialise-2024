@extends('layout')

@section('title', 'Page 3')

@section('content')
<div id="page3">
    <div id="page3-dess">
        <h1 class="titre-border">Dessiner votre chambre</h1><br><br>
        <div id="page3-dess-zone">

        </div>
      </div>
      <div id="page3-nav">
        <button id="retour">Retour <--</button>
        <button id="suivant">Suivant --></button>
      </div>
      
      <div id="page3-info">
        <h1 class="titre-border">Ajouter porte</h1><br><br>
        <div class="page3-info-form">
          <form action="" method="get">
            <label for="num-porte">Numero du mur :</label>
            <input type="text" name="num-porte" id="num-porte"><br>
            <label for="larg-porte">Largeur de la porte :</label>
            <input type="text" name="larg-porte" id="larg-porte"><br>
            <label for="dist-porte">Distance debut mur :</label>
            <input type="text" name="dist-porte" id="dist-porte"><br>
            <input type="button" id="form-porte" value="Ajouter +" class="page3-info-form-button">
          </form>
        </div>
        <br><br>
        <h1 class="titre-border">Ajouter fenetre</h1><br><br>
        <div class="page3-info-form">
          <form action="" method="get">
            <label for="num-fenet">Numero du mur :</label>
            <input type="text" name="num-fenet" id="num-fenet"><br>
            <label for="larg-fenet">Largeur de la fenetre :</label>
            <input type="text" name="larg-fenet" id="larg-fenet"><br>
            <label for="dist-fenet">Distance debut mur :</label>
            <input type="text" name="dist-fenet" id="dist-fenet"><br>
            <input type="button" id="form-fenet" value="Ajouter +" class="page3-info-form-button">
          </form>
        </div>
      </div>
</div>
<script>
  let infosMurs = [];
  const urlParams = new URLSearchParams(window.location.search);
  const chambreId = urlParams.get('chambre_id');

  fetch(`/chercher-murs/${chambreId}`)
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Erreur lors de la récupération des murs');
      }
    })
    .then(data => {
      data.forEach(mur => {
        creerDroite(mur.debut_x_mur, mur.debut_y_mur, mur.fin_x_mur, mur.fin_y_mur, mur.longeur_mur, mur.num_mur);
        console.log('Valeur de id :', mur);
        infosMurs.push({
          id_mur: mur.id_mur,
          num_mur: mur.num_mur,
          debut_x_mur: mur.debut_x_mur,
          debut_y_mur: mur.debut_y_mur,
          fin_x_mur: mur.fin_x_mur,
          fin_y_mur: mur.fin_y_mur,
          longeur_mur: mur.longeur_mur
        });
      });
    })
    .catch(error => {
      console.error('Erreur :', error);
    });

  function creerDroite(derPointX, derPointY, actPointX, actPointY, longueur, numMur) {
    var droite = document.createElement('div');
    var angle = Math.atan2(actPointY - derPointY, actPointX - derPointX) * 180 / Math.PI;

    droite.style.width = longueur + 'px';
    droite.style.height = '2px';
    droite.style.position = 'absolute';
    droite.style.background = 'blue';
    droite.style.left = derPointX + 'px';
    droite.style.top = derPointY + 'px';
    droite.style.transformOrigin = 'left top';
    droite.style.transform = 'rotate(' + angle + 'deg)';

    var span = document.createElement('span');
    span.textContent = numMur;
    span.style.position = 'absolute';
    span.style.top = '50%';
    span.style.left = '50%';
    span.style.transform = 'translate(-50%, -50%)';
    span.style.color = 'black'; // couleur noire
    span.style.fontSize = '16px';

    droite.appendChild(span);

    document.body.appendChild(droite);
  }

  const formPorte = document.getElementById('form-porte');
  const formFenet= document.getElementById('form-fenet');

  formPorte.addEventListener('click', async function() {
      event.preventDefault();

      const numPorte = document.getElementById('num-porte').value;
      const largPorte = document.getElementById('larg-porte').value;
      const distPorte = document.getElementById('dist-porte').value;
      
      document.getElementById('num-porte').value = "";
      document.getElementById('larg-porte').value = "";
      document.getElementById('dist-porte').value = "";

      console.log('Valeur de input1 :', numPorte);
      console.log('Valeur de input2 :', largPorte);
      console.log('Valeur de input2 :', distPorte);

      const murCorrespondant = infosMurs.find(mur => mur.num_mur === parseInt(numPorte));
      if (murCorrespondant) {
        creerPorte(murCorrespondant.debut_x_mur, murCorrespondant.debut_y_mur, murCorrespondant.fin_x_mur, murCorrespondant.fin_y_mur, largPorte, distPorte);
        const donnees = {
            id_mur: murCorrespondant.id_mur,
            longueur_porte: largPorte,
            distance_porte: distPorte
        };

        await fetch('/creer-porte', {
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
      } else {
        console.log('Aucun mur correspondant trouvé pour le numéro de porte saisi.');
      }
  });

  formFenet.addEventListener('click', async function() {
      
      const numFenet = document.getElementById('num-fenet').value;
      const largFenet = document.getElementById('larg-fenet').value;
      const distFenet = document.getElementById('dist-fenet').value;
      
      document.getElementById('num-fenet').value = "";
      document.getElementById('larg-fenet').value = "";
      document.getElementById('dist-fenet').value = "";
      
      console.log('Valeur de input1 :', numFenet);
      console.log('Valeur de input2 :', largFenet);
      console.log('Valeur de input2 :', distFenet);

      const murCorrespondant = infosMurs.find(mur => mur.num_mur === parseInt(numFenet));
      if (murCorrespondant) {
        creerFenet(murCorrespondant.debut_x_mur, murCorrespondant.debut_y_mur, murCorrespondant.fin_x_mur, murCorrespondant.fin_y_mur, largFenet, distFenet);

        const donnees = {
            id_mur: murCorrespondant.id_mur,
            longueur_fenetre: largFenet,
            distance_fenetre: distFenet
        };

        await fetch('/creer-fenetre', {
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
      } else {
        console.log('Aucun mur correspondant trouvé pour le numéro de porte saisi.');
      }

  });

  function creerPorte(debutX, debutY, finX, finY, largeurPorte, distanceDebutMur) {
      const longueurMur = Math.sqrt(Math.pow(finX - debutX, 2) + Math.pow(finY - debutY, 2));

      const angleMur = Math.atan2(finY - debutY, finX - debutX) * 180 / Math.PI;

      const porteX = debutX + (distanceDebutMur / longueurMur) * (finX - debutX);
      const porteY = debutY + (distanceDebutMur / longueurMur) * (finY - debutY);

      const porte = document.createElement('div');
      porte.style.width = largeurPorte + 'px';
      porte.style.height = '4px';
      porte.style.position = 'absolute';
      porte.style.background = 'brown';
      porte.style.left = porteX + 'px';
      porte.style.top = porteY + 'px';
      porte.style.transformOrigin = 'left top';
      porte.style.transform = `rotate(${angleMur}deg)`;
      document.body.appendChild(porte);
  }
  
  function creerFenet(debutX, debutY, finX, finY, largeurFenet, distanceDebutMur) {
      const longueurMur = Math.sqrt(Math.pow(finX - debutX, 2) + Math.pow(finY - debutY, 2));

      const angleMur = Math.atan2(finY - debutY, finX - debutX) * 180 / Math.PI;

      const fenetX = debutX + (distanceDebutMur / longueurMur) * (finX - debutX);
      const fenetY = debutY + (distanceDebutMur / longueurMur) * (finY - debutY);

      const fenet = document.createElement('div');
      fenet.style.width = largeurFenet + 'px';
      fenet.style.height = '4px';
      fenet.style.position = 'absolute';
      fenet.style.background = 'yellow';
      fenet.style.left = fenetX + 'px';
      fenet.style.top = fenetY + 'px';
      fenet.style.transformOrigin = 'left top';
      fenet.style.transform = `rotate(${angleMur}deg)`;
      document.body.appendChild(fenet);
  }

  document.getElementById('suivant').addEventListener('click', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const chambreId = urlParams.get('chambre_id');

    window.location.href = "{{ route('page4') }}?chambre_id=" + chambreId;
  
  });
</script>
@endsection