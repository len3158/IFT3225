/*
Auteurs :
Lenny SIEMENI (1055234)
Mourad BENCHIKH(20034241)

Gestion des event listeners en vue de sauvegarder les donnees dans la DB
*/

$("#compteur").on('DOMSubtreeModified',function () {
	$('#move_count_hidden').val($('#compteur').text());
});

$(".nbColonnes").on('change', function () {
	$('#col_count_hidden').val($('.nbColonnes').val());
});

$(".nbLignes").on('change', function () {
	$('#line_count_hidden').val($('.nbLigne').val());
});

$(".brasser").on('click', function () {
	$('#succes_hidden').val("false");
	$('#play_hidden').val("true");
});

$(".afficher").on('click', function () {
	$('#succes_hidden').val("false");
	$('#play_hidden').val("false");
});