<?php
/*
Auteurs :
Lenny SIEMENI (1055234)
Mourad BENCHIKH(20034241)
*/
//Gere la connection a la DB
//Utile pour afficher les messages d'erreur au complet (pas juste les codes)
error_reporting(E_ALL); ini_set('display_errors', 'On'); 
session_start();
require 'config.php';
if(isset($_POST['action_type'])){
    switch ($_POST['action_type']) {
        case 'inscription':
            inscription();
            break;
        case 'login':
            login();
            break;
        case 'getGameSettings':
            updateGameLeaderboards();
            getGameScore();
            break;
        case 'updateGameLeaderboards':
            updateGameLeaderboards();
            break;
        default:
            break;
    }
}

function inscription() {
     $ID = NULL;
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $identifiant = $_POST['identifiant'];
        $mot_de_passe =$_POST['password'];
        $total_nb_parties = 0;
        $total_nb_parties_terminees = 0;
        $sql_search_existing = "SELECT identifiant FROM joueurs WHERE identifiant='$identifiant'";
                try {
                    //Recherche dans la base de donnees si le joueur n'existe pas deja
                    $stmt = $conn->prepare($sql_search_existing);
                    $stmt->execute(array($identifiant));
                    if($stmt->fetch(PDO::FETCH_OBJ)){
                     echo '<!DOCTYPE html><meta charset="utf-8"/><body>
                        <!--redirection vers le portail après 8 secondes-->
                        <meta http-equiv="refresh" content="8; ../connexion.html" />
                        <p>Un joueur avec cette adresse courriel existe deja dans la base de donnees ! Redirection vers la page <a href="../connexion.html"> connexion.html</a> après 8 secondes.
                        <p>Cliquez sur le lien si cela n a pas fonctionné.</p></body>';
                    } else {//Sinon on peut l'ajouter dans la base de donnees
                        $sql = "INSERT INTO joueurs(ID,nom,prenom,identifiant,password,total_nb_parties, total_nb_parties_terminees) VALUES (NULL,'$nom','$prenom','$identifiant','$mot_de_passe','$total_nb_parties','$total_nb_parties_terminees')";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array($ID, $nom, $prenom, $identifiant, $mot_de_passe, $total_nb_parties, $total_nb_parties_terminees));
                        
                        //Faire le liens entre les entrees ID des tables joueur et scores
                        $sql= "INSERT INTO scores(ID_joueur,NbLignes, NbColonnes, Deplacements,Date) VALUES ((SELECT ID FROM joueurs where identifiant='$identifiant'),NULL,NULL,NULL,CURRENT_DATE());";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        
                        //Insertion successful. Redirection vers le portail pour maintenant se connecter
                        echo '<!DOCTYPE html><meta charset="utf-8"/><body>
                            <!--redirection vers le portail après 8 secondes-->
                            <meta http-equiv="refresh" content="8; ../connexion.html" />
                            <p>Joueur bien enregistre ! Redirection automatique vers <a href="../connexion.html"> connexion.html</a> après 8 secondes. <p>Utilisez vos identifiant recemment crees pour vous connecter.</p>
                            <p>Cliquez sur le lien si cela n a pas fonctionné.</p></body>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur lors de l'inscription a la base de donnee. Veuillez reessayer plus tard.". $e->getMessage();
                }
                //pour fermer la connection
                unset($conn);
}


function login(){
require 'config.php';
        $identifiant = $_POST['identifiant'];
        $mot_de_passe = $_POST['password'];

    if($identifiant && $mot_de_passe){   //Verifie si POST['identifiant'] et POST['password'] ne sont pas vides
        try{
            //Preparation de la req SQL
            $sql = "SELECT identifiant,password FROM joueurs WHERE identifiant='$identifiant' AND password='$mot_de_passe'";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($identifiant,$mot_de_passe));
            
            // Checks if user is valid
            if(!$stmt->fetch(PDO::FETCH_OBJ)){
                        echo '<!DOCTYPE html><meta charset="utf-8"/><body>
                            <!--redirection vers le portail après 8 secondes-->
                            <meta http-equiv="refresh" content="8; ../connexion.html" />
                            <p>Nom d utilisateur ou mot de passe incorrect ! Redirection automatique vers <a href="../connexion.html"> connexion.html</a> après 8 secondes.
                            <p>Cliquez sur le lien si cela n a pas fonctionné.</p></body>';
            }else{ //login est valide, on cree les coockies de session
                $_SESSION['identifiant'] = $identifiant;
                header('Location: ../Taquin.html');
                exit;
            }
        } catch (Exception $e){
            echo "Erreur d'authentification: " . $e->getMessage();
        }
    }else{ //Si on entre dans cette partie, ca veut dire que POST['login'] ou POST['password'] sont vides
    echo '<!DOCTYPE html><meta charset="utf-8"/><body>
        <!--redirection vers le portail après 8 secondes-->
        <meta http-equiv="refresh" content="8; ../connexion.html" />
        <p>Les champs ne peuvent pas etre vide ! Redirection automatique vers <a href="../connexion.html"> connexion.html</a> après 8 secondes. <p>Utilisez vos identifiants pour vous connecter.</p>
        <p>Cliquez sur le lien si cela n a pas fonctionné.</p></body>';
    }
}

function getGameScore(){
require 'config.php';
$identifiant = $_SESSION['identifiant'];
    	try{
    			try {
    				//Si utilisateur correctement connecte
    				if($identifiant){
    					$sql = "SELECT ID_joueur, NbLignes, NbColonnes, Deplacements, Date FROM scores WHERE ID_joueur = (SELECT ID FROM joueurs WHERE identifiant = '$identifiant')";
    					$stmt = $conn->query($sql);
    					$stmt->execute();
    				} else {
    					echo '<!DOCTYPE html><meta charset="utf-8"/><body>
                                <!--redirection vers le portail après 8 secondes-->
                                <meta http-equiv="refresh" content="8; ../connexion.html" />
                                <p>Nom d utilisateur ou mot de passe incorrect ! Redirection automatique vers <a href="../connexion.html"> connexion.html</a> après 8 secondes.
                                <p>Cliquez sur le lien si cela n a pas fonctionné.</p></body>';
    				}
    			} catch (PDOException $e) {
    				echo "Erreur lors de la mise a jour du tableau des scores. Veuillez reessayer plus tard". $e->getMessage();
    			}
    
                $tables = $stmt->fetchAll(PDO::FETCH_NUM);

                //Display the results if there is any
                if ($tables > 0) {
                    echo "<table><thead><th>ID_JOUEUR</th><th>NbLignes</th><th>NbColonnes</th><th>Deplacements</th><th>Date</th>";
                    foreach($tables as $table){
                    // output data of each row
                        echo "<tr><td>".$table[0]."</td><td>".$table[1]."</td><td>".$table[2]."</td><td>".$table[3]."</td><td>".$table[4]."</td></tr>";
                    }
                } else {
                	echo '<!DOCTYPE html><meta charset="utf-8"/><body>
                            <p>Vous n avez aucune partie enregistree. </p>
                            <p><a href="../Taquin.html"> Page precedente</a></p>';
                }
                $sql3 = "SELECT total_nb_parties, total_nb_parties_terminees FROM joueurs WHERE identifiant = '$identifiant'";
                $stmt = $conn->query($sql3);
                $stmt->execute();
                $tables2 = $stmt->fetchAll(PDO::FETCH_NUM);
                echo "<br><br><table><thead><th>Nb_parties_jouees</th><th>Nb_parties_terminees</th>";
                foreach($tables2 as $t){
                      echo "<tr><td>".$t[0]."</td><td>".$t[1]."</td><td>";
                }
                  
                    echo '</table><a href="../Taquin.html"> Page precedente</a>';
    			//pour fermer la connection
    			unset($conn);
    	} catch(PDOException $e){
    		echo "Probleme de connection a la base de donnee : " . $e->getMessage();
    	}
}

//Mise a jour du tableau des scores
function updateGameLeaderboards() {
    require 'config.php';
    $identifiant = $_SESSION['identifiant'];
    try{
            try {
                //Cannot access DB is coockies are expired
                	if($identifiant){
                        //cannot update leaderboard if we're not playing the game, we can update leaderboards mid-game
                        $play_state = $_POST['play_hidden'];
                        $NbLignes = $_POST["line_count_hidden"];
                        $NbColonnes = $_POST["col_count_hidden"];
                        $deplacements = $_POST["move_count_hidden"]; 
                        $succes = $_POST["succes_hidden"];
                       if($play_state === "true"){
                            $sql = "INSERT INTO scores(ID_joueur, NbLignes, NbColonnes, Deplacements, Date) VALUES((Select ID FROM joueurs WHERE Identifiant='$identifiant'),$NbLignes, $NbColonnes, $deplacements, CURRENT_DATE());";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            //Si la partie est gagnee, on incremente le compteur de partie gagnees dans la table
                            if($succes === "true"){
                                $sql2 = "UPDATE joueurs SET total_nb_parties = total_nb_parties + 1, total_nb_parties_terminees = total_nb_parties_terminees + 1  WHERE identifiant = '$identifiant'";
                            } else {
                                $sql2 = "UPDATE joueurs SET total_nb_parties = total_nb_parties + 1 WHERE identifiant = '$identifiant'";
                            }
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute();
                        } else {
                            //do nothing
                        }
                    } else {
					echo '<!DOCTYPE html><meta charset="utf-8"/><body>
                    <!--redirection vers le portail après 8 secondes-->
                    <meta http-equiv="refresh" content="8; ../connexion.html" />
                    <p>Nom d utilisateur ou mot de passe incorrect ! Redirection automatique vers <a href="../connexion.html"> connexion.html</a> après 8 secondes.
                    <p>Cliquez sur le lien si cela n a pas fonctionné.</p></body>';           
                    }
            } catch (PDOException $e) {
                echo "Erreur lors de la mise a jour du tableau des scores. Veuillez reessayer plus tard". $e->getMessage();
            }
            //pour fermer la connection
            unset($conn);
    } catch(PDOException $e){
        echo "Probleme de connection a la base de donnee : " . $e->getMessage();
    }
}
?>