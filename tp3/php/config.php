<!-- Connexion a une BDD Mysql par PDO.. acompleter selon vos besoin  -->
<!-- Auteurs : Lenny SIEMENI 1055234
inscription.php : Permet de se connecter a la base de donnees
-->
<?php
//Utile pour afficher les messages d'erreur au complet (pas juste les codes)

 error_reporting(E_ALL); ini_set('display_errors', 'On'); 
try{
$serveur = "localhost:8889";
$login = "root";
$motDePasse = "root";
$bdd = "taquin";
#ne pas oublier de remplacer mysql par mysqli
$conn = new PDO("mysql:host=$serveur;dbname=$bdd", $login, $motDePasse);

} catch(PDOException $e){
	echo "Probleme de connection: " . $e->getMessage();
}

?>
