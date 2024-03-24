@extends('layout')

@section('title', 'Page 5')

@section('content')
<div id="page5">
    <div id="page5-dess">
        <h1 class="titre-border">Voici votre chambre</h1><br><br>
        <div id="page5-dess-zone">

        </div>
      </div>
      <div class="page5-creer-back" id="page5-creer">
        <h1 id="page5-creer-texte">+</h1>
      </div>
      
      <div class="page5-creer-back" id="page5-partage">
        <h1 id="page5-partage-texte">-></h1>
      </div>

        <div class="page5-creer-back" id="page5-menu">
            <h1 id="page5-menu-texte">H</h1>
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
        infosMurs.push({
          id_mur: mur.id_mur,
          hauteur_mur: mur.hauteur_mur,
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
      chercherMeuble();
    })
    .catch(error => {
      console.error('Erreur :', error);
    });

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
                          
                          creerFenetre(murId.debut_x_mur, murId.debut_y_mur, murId.fin_x_mur, murId.fin_y_mur, fenetre.longueur_fenetre, fenetre.distance_fenetre);
                          infosFenetres.push({
                            id_mur: mur.id_mur,
                            hauteur_mur: mur.hauteur_mur,
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
                          
                          creerPorte(murId.debut_x_mur, murId.debut_y_mur, murId.fin_x_mur, murId.fin_y_mur, porte.longueur_porte, porte.distance_porte);
                      });
                  })
                  .catch(error => {
                      console.error('Erreur :', error);
                  });
          }
      }
    }

    async function chercherMeuble() {
      fetch(`/chercher-meubles/${chambreId}`)
      .then(response => {
          if (response.ok) {
              return response.json();
          } else {
              throw new Error('Erreur lors de la récupération des meubles');
          }
      })
      .then(data => {
          data.forEach(meuble => {

            let coordsMurs = [];
            const page5DessZone = document.getElementById('page5-dess-zone');
            const meubleDiv = document.createElement('div');

            meubleDiv.style.width = meuble.largeur_meuble + 'px';
            meubleDiv.style.height = meuble.longueur_meuble + 'px';

            const meublesPlaces = Array.from(page5DessZone.children).map(div => ({
                left: div.offsetLeft,
                top: div.offsetTop,
                width: div.offsetWidth,
                height: div.offsetHeight
            }));

            infosMurs.forEach(mur => {
                coordsMurs.push([mur.debut_x_mur, mur.debut_y_mur]);
                coordsMurs.push([mur.fin_x_mur, mur.fin_y_mur]);
            });
            
            const zoneRect = page5DessZone.getBoundingClientRect();
            let randomLeft = zoneRect.left + Math.random() * (zoneRect.width - meuble.largeur_meuble);
            let randomTop = zoneRect.top + Math.random() * (zoneRect.height - meuble.longueur_meuble);

            while (!rectangleDansPolygon(
                randomLeft, randomTop, meuble.largeur_meuble, meuble.longueur_meuble, coordsMurs) ||
                meublesPlaces.some(place => rectanglesSuperpose(
                    randomLeft, randomTop, meuble.largeur_meuble, meuble.longueur_meuble,
                    place.left, place.top, place.width, place.height
                ))
            ) {
                randomLeft = zoneRect.left + Math.random() * (zoneRect.width - meuble.largeur_meuble);
                randomTop = zoneRect.top + Math.random() * (zoneRect.height - meuble.longueur_meuble);
            }

            switch (meuble.type_meuble) {
                case 'Lit':
                    meubleDiv.style.background = 'blue';
                    break;
                case 'Autres':
                    meubleDiv.style.background = 'green';
                    break;
                case 'Table':
                    meubleDiv.style.background = 'purple';
                    break;
                case 'Bureau':
                    meubleDiv.style.background = 'red';
                    break;
                default:
                    meubleDiv.style.background = 'gray';
                    break;
            }
            meubleDiv.textContent = meuble.type_meuble;

            meubleDiv.style.position = 'absolute';
            meubleDiv.style.left = randomLeft + 'px';
            meubleDiv.style.top = randomTop + 'px';
            page5DessZone.appendChild(meubleDiv);
          });
      })
      .catch(error => {
          console.error('Erreur :', error);
      });
    }

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

  function creerFenetre(debutX, debutY, finX, finY, largeurFenet, distanceDebutMur) {
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

    function rectangleDansPolygon(x, y, width, height, polygon) {

      return pointDansPolygon(x, y, polygon) &&
          pointDansPolygon(x + width, y, polygon) &&
          pointDansPolygon(x, y + height, polygon) &&
          pointDansPolygon(x + width, y + height, polygon);
  }

  function pointDansPolygon(pointx, pointy, polygon) {
    let x = pointx, y = pointy;
    let inside = false;
    for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
        let xi = polygon[i][0], yi = polygon[i][1];
        let xj = polygon[j][0], yj = polygon[j][1];
        let intersect = ((yi > y) !== (yj > y)) &&
            (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
        if (intersect) inside = !inside;
    }
    return inside;
  }
  function rectanglesSuperpose(x1, y1, w1, h1, x2, y2, w2, h2) {
    return x1 < x2 + w2 && x1 + w1 > x2 && y1 < y2 + h2 && y1 + h1 > y2;
  }
  
</script>
@endsection