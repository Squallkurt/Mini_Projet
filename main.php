<?php
/**
 * Created by PhpStorm.
 * User: Fx
 * Date: 30/10/2014
 * Time: 18:27
 */

session_start(); 	//Démarrage d'une session

if ( !isset($_SESSION["command"])) {	//Test pour savoir si la variable command existe ou non, si elle existe pas :
	$_SESSION["command"] = "debut";		//on lui donne la valeur 'debut'
} else {
	$_SESSION["command"] = "jeu";		//sinon on lui donne la valeur 'jeu'
}

if (isset($_GET["command"])) {			//Test lorsque la variable command existe, suivant sa valeur on va effectuer ou non une action :
	if ($_GET["command"] == "debut") {	// Si elle vaut 'debut :
		$_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;	//Alors la bille sur lequel l'utilisateur aura cliqué disparaitra et le jeu commencera.
	}

	if ($_GET["command"] == "jeu") {	// Si elle a déjà la valeur 'jeu' :
		aucunMouvementPossible();		// On appelle la fonction pour voir si un mouvement est encore possible ou non
		if ($_SESSION["pasDeMouvementPossible"]){	// On regarde le résultat de la fonction :
			resultat();					// Si aucun mouvement possible on retourne le résultat c'est à dire gagné ou perdu
		}	
		else{							// Sinon l'utilisateur peut jouer un coup supplémentaire
			jouerUnCoup();				
		}
	}
	else {								// Si jamais elle a une tout autre valeur 
										//(cas ou l'utilisateur aurait changé la valeur de command dans l'URL) :
		resetPlateau();					// On redemarre le jeu
	}
}

if (!isset($_SESSION["plateau"])) {		// Si le plateau n'existe pas :
    resetPlateau();						// On le créer
}

/* Fonction qui créer le plateau de jeu ou a défaut qui permet de le re-créer en cas d'erreur de l'utilisateur dans l'URL
 ou s'il décide de reinitialiser le jeu*/
function resetPlateau() {

	$_SESSION["plateau"] = array(array());	//Création d'un tableau a deux dimensions qui représentera le plateau
    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            $_SESSION["plateau"][$i][$j] = true;	//On donne la valeur True à toutes les cases du plateau
        }
    }
// Les seize ligne qui suivent sont le retrait des quatre cases dans chaque coin du plateau de jeu qui n'existe pas
	$_SESSION["plateau"][0][0] = false;	
    $_SESSION["plateau"][0][1] = false;
    $_SESSION["plateau"][1][0] = false;
    $_SESSION["plateau"][1][1] = false;

    $_SESSION["plateau"][5][0] = false;
    $_SESSION["plateau"][5][1] = false;
    $_SESSION["plateau"][6][0] = false;
    $_SESSION["plateau"][6][1] = false;

    $_SESSION["plateau"][5][5] = false;
    $_SESSION["plateau"][5][6] = false;
    $_SESSION["plateau"][6][5] = false;
    $_SESSION["plateau"][6][6] = false;

    $_SESSION["plateau"][0][5] = false;
    $_SESSION["plateau"][0][6] = false;
    $_SESSION["plateau"][1][5] = false;
    $_SESSION["plateau"][1][6] = false;
}

 /*Fonction qui permet à l'utilisateur de jouer un coup après le retrait de la bille au démarrage.
On test d'abord si la bille selectionnée par l'utilisateur existe, ensuite on test si la case cible est bien vide
Si c'est le cas, on va faire un test pour savoir si la case cible est bien égale 
à la case ce trouvant deux cases a coté de la bille selectionnée (un cas pour gauche, un pour droit, un pour haut et un pour bas)
et si la case entre la bille selectionnée et la case cible, contient bien une bille.
Si c'est le cas, on fait le mouvement, sinon l'utilisateur recevra un message disant que le mouvement n'est pas possible*/

function jouerUnCoup(){
	if (($_SESSION["plateau"][$_GET["x"]][$_GET["y"]] == true)&&($_SESSION["plateau"][$_GET["u"]][$_GET["v"]] == false)){
		if(($_SESSION["plateau"][$_GET["x"+1]][$_GET["y"]] == true)&&
		($_SESSION["plateau"][$_GET["u"]][$_GET["v"]] == $_SESSION["plateau"][$_GET["x"+2]][$_GET["y"]])){
			$_SESSION["plateau"][$_GET["u"]][$_GET["v"]] = true;
			$_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;
			$_SESSION["plateau"][$_GET["x"+1]][$_GET["y"]] = false;
		}
		else if(($_SESSION["plateau"][$_GET["x"-1]][$_GET["y"]] == true)&&
		($_SESSION["plateau"][$_GET["u"]][$_GET["v"]] == $_SESSION["plateau"][$_GET["x"-2]][$_GET["y"]])){
			$_SESSION["plateau"][$_GET["u"]][$_GET["v"]] = true;
			$_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;
			$_SESSION["plateau"][$_GET["x"-1]][$_GET["y"]] = false;
		}
		else if(($_SESSION["plateau"][$_GET["x"]][$_GET["y"+1]] == true)&&
		($_SESSION["plateau"][$_GET["u"]][$_GET["v"]] == $_SESSION["plateau"][$_GET["x"]][$_GET["y"+2]])){
			$_SESSION["plateau"][$_GET["u"]][$_GET["v"]] = true;
			$_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;
			$_SESSION["plateau"][$_GET["x"]][$_GET["y"+1]] = false;
		}
		else if(($_SESSION["plateau"][$_GET["x"]][$_GET["y"-1]] == true)&&
		($_SESSION["plateau"][$_GET["u"]][$_GET["v"]] == $_SESSION["plateau"][$_GET["x"]][$_GET["y"-2]])){
			$_SESSION["plateau"][$_GET["u"]][$_GET["v"]] = true;
			$_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;
			$_SESSION["plateau"][$_GET["x"]][$_GET["y"-1]] = false;
		}
		}
		else{
			echo "Mouvement impossible";
	}
	else{
		echo "Mouvement impossible";
	}
}
// Fonction qui test si un mouvement est encore possible
function aucunMouvementPossible(){
	$_SESSION["pasDeMouvementPossible"]=true;
	for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
           if (($_SESSION["plateau"][$i][$j] == true){
				if (($_SESSION["plateau"][$i+1][$j] == true)&&($_SESSION["plateau"][$i+2][$j] == false){
					$_SESSION["pasDeMouvementPossible"]=false;
				}
				else if (($_SESSION["plateau"][$i-1][$j] == true)&&($_SESSION["plateau"][$i-2][$j] == false){
					$_SESSION["pasDeMouvementPossible"]=false;
				}
				else if (($_SESSION["plateau"][$i][$j+1] == true)&&($_SESSION["plateau"][$i][$j+2] == false){
					$_SESSION["pasDeMouvementPossible"]=false;
				}
				else if (($_SESSION["plateau"][$i][$j-1] == true)&&($_SESSION["plateau"][$i][$j-2] == false){
					$_SESSION["pasDeMouvementPossible"]=false;
				}

		   }
        }
    }
}

// Fonction qui donne le résultat final suivant le déroulement du jeu
function resultat(){

	$cpt=0;
	for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
           if ($_SESSION["plateau"][$i][$j] == true){
				$cpt++;
		   }
        }
    }
	if ($cpt==1){
		echo "vous avez gagnez !!!";
	}
	if ($cpt>1){
		echo "vous avez perdu !!!";
	}
	
}	

include("head.html");	//Entete de la page

// Affichage du plateau de jeu
echo "<table>\n";

for ($i = 0; $i < 7; $i++) {
    echo "\t<tr>";
    for ($j = 0; $j < 7; $j++) {
		echo "<td>";
        echo ($_SESSION["plateau"][$i][$j]) ? "<a href=\"main.php?x=$i&y=$j&command=" . $_SESSION["command"] ."\"><img src=\"bille.jpg\"/></a>" : "" ;
        echo "</td>";
    }
    echo "</tr>\n";
}

echo "</table>\n";

include("bottom.html");	//Pied de page