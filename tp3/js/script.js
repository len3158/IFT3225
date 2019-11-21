/*<!--Auteur Lenny SIEMENI 1055234-->*/
//Toggle l'affichage entre le portail d'inscription et le portail d'authentification
$(document).ready(function(){
  $('.close').click(function () {
    if ($('#divSeConnecter').is(":visible")) {
          $('#divSeConnecter').hide();
        }
    else if ($('#divEnregistrerMembre').is(":visible")) {
          $('#divEnregistrerMembre').hide();
        }
  })
  $('.creerCompte').click(function () {
    if ($('#divSeConnecter').is(":visible")) {
          $('#divSeConnecter').hide();
          $('#divEnregistrerMembre').show();
        }
    else {
          $('#divEnregistrerMembre').show();
    }
  })
  $('.connect').click(function () {
    if ($('#divEnregistrerMembre').is(":visible")) {
          $('#divEnregistrerMembre').hide();
          $('#divSeConnecter').show();
        }
    else {
         $('#divSeConnecter').show();
        }
  })

});
