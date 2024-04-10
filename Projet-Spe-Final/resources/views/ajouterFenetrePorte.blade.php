@extends('layout')

@section('title', 'Page 3')

@section('content')
<div id="ajouterFenetrePorte">
    <div id="ajouterFenetrePorte-dess">
        <h1 class="titre-border">Etape 2/3 - Ajouter vos fenetres et portes de votre chambre</h1><br><br>
        <div id="ajouterFenetrePorte-dess-zone">

        </div>
      </div>
      <div id="ajouterFenetrePorte-nav">
        <button id="retour">Retour <--</button>
        <button id="suivant">Suivant --></button>
      </div>
      
      <div id="ajouterFenetrePorte-info">
        <h1 class="titre-border">Ajouter porte</h1><br><br>
        <div class="ajouterFenetrePorte-info-form">
          <form action="" method="get">
            <label for="num-porte">Numero du mur :</label>
            <input type="text" name="num-porte" id="num-porte"><br>
            <label for="larg-porte">Largeur de la porte  (en cm) :</label>
            <input type="text" name="larg-porte" id="larg-porte"><br>
            <label for="dist-porte">Distance debut mur  (en cm) :</label>
            <input type="text" name="dist-porte" id="dist-porte"><br>
            <input type="button" id="form-porte" value="Ajouter +" class="ajouterFenetrePorte-info-form-button">
          </form>
        </div>
        <br><br>
        <h1 class="titre-border">Ajouter fenetre</h1><br><br>
        <div class="ajouterFenetrePorte-info-form">
          <form action="" method="get">
            <label for="num-fenet">Numero du mur :</label>
            <input type="text" name="num-fenet" id="num-fenet"><br>
            <label for="larg-fenet">Largeur de la fenetre  (en cm) :</label>
            <input type="text" name="larg-fenet" id="larg-fenet"><br>
            <label for="dist-fenet">Distance debut mur  (en cm) :</label>
            <input type="text" name="dist-fenet" id="dist-fenet"><br>
            <input type="button" id="form-fenet" value="Ajouter +" class="ajouterFenetrePorte-info-form-button">
          </form>
        </div>
      </div>
</div>
<script>
  let infosMurs = [];
  let maxNumMur = -Infinity;
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
      chercherPorte();
      chercherFenetre();
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

      const murCorrespondant = infosMurs.find(mur => mur.num_mur === parseInt(numFenet));
      if (murCorrespondant) {
        creerFenetre(murCorrespondant.debut_x_mur, murCorrespondant.debut_y_mur, murCorrespondant.fin_x_mur, murCorrespondant.fin_y_mur, largFenet, distFenet);

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

    function creerFenetre(debutX, debutY, finX, finY, largeurPorte, distanceDebutMur) {
      const longueurMur = Math.sqrt(Math.pow(finX - debutX, 2) + Math.pow(finY - debutY, 2));

      const angleMur = Math.atan2(finY - debutY, finX - debutX) * 180 / Math.PI;

      const porteX = debutX + (distanceDebutMur / longueurMur) * (finX - debutX);
      const porteY = debutY + (distanceDebutMur / longueurMur) * (finY - debutY);

      const porte = document.createElement('div');
      porte.style.width = largeurPorte + 'px';
      porte.style.height = '4px';
      porte.style.position = 'absolute';
      porte.style.background = 'yellow';
      porte.style.left = porteX + 'px';
      porte.style.top = porteY + 'px';
      porte.style.transformOrigin = 'left top';
      porte.style.transform = `rotate(${angleMur}deg)`;
      document.body.appendChild(porte);

    }

    async function chercherFenetre() {
      await infosMurs.forEach(mur => {  
        if (mur.num_mur > maxNumMur) {
            maxNumMur = mur.num_mur;
        }
      });
      for (let i = 1; i <= maxNumMur; i++) {
          const murId = infosMurs.find(mur => mur.num_mur === i);
          
          if (murId) {
              fetch(`/chercher-fenetres/${murId.id_mur}`)
                  .then(response => {
                      if (response.ok) {
                          return response.json();
                      } else {
                          throw new Error('Erreur lors de la récupération des fenetres');
                      }
                  })
                  .then(data => {
                      data.forEach(fenetre => {
                          
                        recupFenetre(murId.debut_x_mur, murId.debut_y_mur, murId.fin_x_mur, murId.fin_y_mur, fenetre.longueur_fenetre, fenetre.distance_fenetre);
                        });
                  })
                  .catch(error => {
                      console.error('Erreur :', error);
                  });
          }
      }
    }

    async function chercherPorte() {
      await infosMurs.forEach(mur => {  
        if (mur.num_mur > maxNumMur) {
            maxNumMur = mur.num_mur;
        }
      });
      for (let i = 1; i <= maxNumMur; i++) {
          const murId = infosMurs.find(mur => mur.num_mur === i);
          
          if (murId) {
              fetch(`/chercher-portes/${murId.id_mur}`)
                  .then(response => {
                      if (response.ok) {
                          return response.json();
                      } else {
                          throw new Error('Erreur lors de la récupération des portes');
                      }
                  })
                  .then(data => {
                      data.forEach(porte => {
                          
                        recupPorte(murId.debut_x_mur, murId.debut_y_mur, murId.fin_x_mur, murId.fin_y_mur, porte.longueur_porte, porte.distance_porte);
                      });
                  })
                  .catch(error => {
                      console.error('Erreur :', error);
                  });
          }
      }
    }

  function recupPorte(debutX, debutY, finX, finY, largeurPorte, distanceDebutMur) {
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

  function recupFenetre(debutX, debutY, finX, finY, largeurFenet, distanceDebutMur) {
      const longueurMur = Math.sqrt(Math.pow(finX - debutX, 2) + Math.pow(finY - debutY, 2));

      const angleMur = Math.atan2(finY - debutY, finX - debutX) * 180 / Math.PI;

      const porteX = debutX + (distanceDebutMur / longueurMur) * (finX - debutX);
      const porteY = debutY + (distanceDebutMur / longueurMur) * (finY - debutY);

      const fenetre = document.createElement('div');
      fenetre.style.width = largeurFenet + 'px';
      fenetre.style.height = '4px';
      fenetre.style.position = 'absolute';
      fenetre.style.background = 'yellow';
      fenetre.style.left = porteX + 'px';
      fenetre.style.top = porteY + 'px';
      fenetre.style.transformOrigin = 'left top';
      fenetre.style.transform = `rotate(${angleMur}deg)`;
      document.body.appendChild(fenetre);
  }

  document.getElementById('suivant').addEventListener('click', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const chambreId = urlParams.get('chambre_id');

    window.location.href = "{{ route('ajouterMeuble') }}?chambre_id=" + chambreId;
  
  });
  
  document.getElementById('retour').addEventListener('click', function() {
    const confirmation = confirm("Êtes-vous sûr de vouloir retourner en arriere ? En effectuant cette action vous recommencerez la creation de la chambre.");

    if (confirmation) {
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
    }
  });
</script>
@endsection