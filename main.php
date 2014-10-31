<?php
/**
<<<<<<< HEAD
* Created by PhpStorm.
* User: Fx
* Date: 30/10/2014
* Time: 18:27
*/
session_start(); // Démarrage d'une session
// Commande par défaut (début du jeu)
$command = "";
// Si une commande spécifique est demandée
if (isset($_GET["command"])) {
	$command = $_GET["command"];
}
// Pas de commande spécifiée ? Reset du plateau pour lancer le jeu
if ($command == "") {
	resetPlateau();
	$command = "debut";
} else {
	// Si aucun mouvement possible on retourne le résultat c'est à dire gagné ou perdu
	if (aucunMouvementPossible()) {
		resultat();
		return;
	}
	if ($command == "debut") {
		// Suppression de la bille demandée pour pouvoir commencer la partie
		$_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;
		$command = "choix";
	} else if ($command == "choix") {
		// Pion choisi, on l'enregistre en session
		$_SESSION["choix"] = array("x" => $_GET["x"], "y" => $_GET["y"]);
	} else if ($command == "action") {
		if (mouvementPossible(array("x" => $_GET["x"], "y" => $_GET["y"]), $_SESSION["choix"])) {
			$command = "choix";
		}
	}
}
if (!isset($_SESSION["plateau"])) { // Si le plateau n'existe pas :
	resetPlateau(); // On le créer
=======
 * Created by PhpStorm.
 * User: Fx
 * Date: 30/10/2014
 * Time: 18:27
 */

session_start();    // Démarrage d'une session

// Commande par défaut (début du jeu)
$command = "";

// Si une commande spécifique est demandée
if (isset($_GET["command"])) {
    $command = $_GET["command"];
}

// Pas de commande spécifiée ? Reset du plateau pour lancer le jeu
if ($command == "") {
    resetPlateau();
    $command = "debut";
} else {
    // Si aucun mouvement possible on retourne le résultat c'est à dire gagné ou perdu
    if (aucunMouvementPossible()) {
        resultat();
        return;
    }
    if ($command == "debut") {
        // Suppression de la bille demandée pour pouvoir commencer la partie
        $_SESSION["plateau"][$_GET["x"]][$_GET["y"]] = false;
        $command = "choix";
    } else if ($command == "choix") {
        // Pion choisi, on l'enregistre en session
        $_SESSION["choix"] = array("x" => $_GET["x"], "y" => $_GET["y"]);
    } else if ($command == "action") {
        if (mouvementPossible(array("x" => $_GET["x"], "y" => $_GET["y"]), $_SESSION["choix"])) {
            $command = "choix";
        }
    }

}

if (!isset($_SESSION["plateau"])) {        // Si le plateau n'existe pas :
    resetPlateau();                        // On le créer
>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
}
/* Fonction qui créer le plateau de jeu ou a défaut qui permet de le re-créer en cas d'erreur de l'utilisateur dans l'URL
<<<<<<< HEAD
ou s'il décide de reinitialiser le jeu*/
function resetPlateau()
{
	$_SESSION["plateau"] = array(array()); //Création d'un tableau a deux dimensions qui représentera le plateau
	for ($i = 0; $i < 7; $i++) {
		for ($j = 0; $j < 7; $j++) {
			$_SESSION["plateau"][$i][$j] = true; //On donne la valeur True à toutes les cases du plateau
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
=======
 ou s'il décide de reinitialiser le jeu*/
function resetPlateau()
{

    $_SESSION["plateau"] = array(array());    //Création d'un tableau a deux dimensions qui représentera le plateau
    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            $_SESSION["plateau"][$i][$j] = true;    //On donne la valeur True à toutes les cases du plateau
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


>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
/*Fonction qui permet à l'utilisateur de jouer un coup après le retrait de la bille au démarrage.
On test d'abord si la bille selectionnée par l'utilisateur existe, ensuite on test si la case cible est bien vide
Si c'est le cas, on va faire un test pour savoir si la case cible est bien égale
à la case ce trouvant deux cases a coté de la bille selectionnée (un cas pour gauche, un pour droit, un pour haut et un pour bas)
et si la case entre la bille selectionnée et la case cible, contient bien une bille.
Si c'est le cas, on fait le mouvement, sinon l'utilisateur recevra un message disant que le mouvement n'est pas possible*/
<<<<<<< HEAD
	/**
	* @param $point1 Destination
	* @param $point2
	* @return bool true si le mouvement est possible, sinon false
	*/
function mouvementPossible($point1, $point2)
{
	if (abs($point1["x"] - $point2["x"]) != 2) {
		return false;
	}
	if (abs($point1["y"] - $point2["y"]) != 2) {
		return false;
	}
	if ($_SESSION[$point1["x"]][$point1["y"]]) {
		return false;
	}
	// Déplacement vertical
	if ($point1["x"] == $point2["x"]) {
		if ($point1["y"] > $point2["y"]) {
			$inc = 1;
		} else {
			$inc = -1;
		}
		if ($_SESSION["plateau"][$point1["x"]][$point1["y"] + $inc]) {
			$_SESSION["plateau"][$point1["x"]][$point1["y"] + $inc] = false;
			$_SESSION["plateau"][$point2["x"]][$point2["y"]] = false;
			$_SESSION["plateau"][$point1["x"]][$point1["y"]] = true;
			return true;
		}
	} else {
		// Déplacement horizontal
		if ($point1["x"] > $point2["x"]) {
			$inc = 1;
		} else {
			$inc = -1;
		}
		if ($_SESSION["plateau"][$point1["x"] + $inc][$point1["y"]]) {
			$_SESSION["plateau"][$point1["x"] + $inc][$point1["y"]] = false;
			$_SESSION["plateau"][$point2["x"]][$point2["y"]] = false;
			$_SESSION["plateau"][$point1["x"]][$point1["y"]] = true;
			return true;
		}
	}
=======
/**
 * @param $point1 Destination
 * @param $point2
 * @return bool true si le mouvement est possible, sinon false
 */
function mouvementPossible($point1, $point2)
{

    if (abs($point1["x"] - $point2["x"]) != 2) {
        return false;
    }

    if (abs($point1["y"] - $point2["y"]) != 2) {
        return false;
    }

    if ($_SESSION[$point1["x"]][$point1["y"]]) {
        return false;
    }

    // Déplacement vertical
    if ($point1["x"] == $point2["x"]) {
        if ($point1["y"] > $point2["y"]) {
            $inc = 1;
        } else {
            $inc = -1;
        }
        if ($_SESSION["plateau"][$point1["x"]][$point1["y"] + $inc]) {
            $_SESSION["plateau"][$point1["x"]][$point1["y"] + $inc] = false;
            $_SESSION["plateau"][$point2["x"]][$point2["y"]] = false;
            $_SESSION["plateau"][$point1["x"]][$point1["y"]] = true;
            return true;
        }

    } else {
        // Déplacement horizontal
        if ($point1["x"] > $point2["x"]) {
            $inc = 1;
        } else {
            $inc = -1;
        }
        if ($_SESSION["plateau"][$point1["x"] + $inc][$point1["y"]]) {
            $_SESSION["plateau"][$point1["x"] + $inc][$point1["y"]] = false;
            $_SESSION["plateau"][$point2["x"]][$point2["y"]] = false;
            $_SESSION["plateau"][$point1["x"]][$point1["y"]] = true;
            return true;
        }
    }
>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
}

// Fonction qui test si un mouvement est encore possible
function aucunMouvementPossible()
{
<<<<<<< HEAD
	for ($i = 1; $i < 6; $i++) {
		for ($j = 1; $j < 6; $j++) {
			if ($_SESSION["plateau"][$i][$j] == true) {
				if (($_SESSION["plateau"][$i + 1][$j] == true) && ($_SESSION["plateau"][$i + 2][$j] == false)) {
					return false;
				} else if (($_SESSION["plateau"][$i - 1][$j] == true) && ($_SESSION["plateau"][$i - 2][$j] == false)) {
					return false;
				} else if (($_SESSION["plateau"][$i][$j + 1] == true) && ($_SESSION["plateau"][$i][$j + 2] == false)) {
					return false;
				} else if (($_SESSION["plateau"][$i][$j - 1] == true) && ($_SESSION["plateau"][$i][$j - 2] == false)) {
					return false;
				}
			}
		}
	}
=======
    for ($i = 1; $i < 6; $i++) {
        for ($j = 1; $j < 6; $j++) {
            if ($_SESSION["plateau"][$i][$j] == true) {
                if (($_SESSION["plateau"][$i + 1][$j] == true) && ($_SESSION["plateau"][$i + 2][$j] == false)) {
                    return false;
                } else if (($_SESSION["plateau"][$i - 1][$j] == true) && ($_SESSION["plateau"][$i - 2][$j] == false)) {
                    return false;
                } else if (($_SESSION["plateau"][$i][$j + 1] == true) && ($_SESSION["plateau"][$i][$j + 2] == false)) {
                    return false;
                } else if (($_SESSION["plateau"][$i][$j - 1] == true) && ($_SESSION["plateau"][$i][$j - 2] == false)) {
                    return false;
                }

            }
        }
    }
>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
}
// Fonction qui donne le résultat final suivant le déroulement du jeu
function resultat()
{
<<<<<<< HEAD
$cpt = 0;
	for ($i = 0; $i < 7; $i++) {
		for ($j = 0; $j < 7; $j++) {
			if ($_SESSION["plateau"][$i][$j] == true) {
				$cpt++;
			}
		}
	}
	if ($cpt == 1) {
		echo "\t<p>Vous avez gagné !!!</p>\n";
	}
	if ($cpt > 1) {
		echo "\t<p>Vous avez perdu !!!</p>\n";
	}
}
include("head.html"); //Entete de la page
=======

    $cpt = 0;
    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            if ($_SESSION["plateau"][$i][$j] == true) {
                $cpt++;
            }
        }
    }
    if ($cpt == 1) {
        echo "\t<p>Vous avez gagné !!!</p>\n";
    }
    if ($cpt > 1) {
        echo "\t<p>Vous avez perdu !!!</p>\n";
    }

}

include("head.html");    //Entete de la page

>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
// Affichage du plateau de jeu
echo "<table>\n";
for ($i = 0; $i < 7; $i++) {
<<<<<<< HEAD
	echo "\t<tr>";
	for ($j = 0; $j < 7; $j++) {
		if ((($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][0][0])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][0][1])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][1][0])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][1][1])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][5][0])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][5][1])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][6][0])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][6][1])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][5][5])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][5][6])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][6][5])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][6][6])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][0][5])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][0][6])) ||
		(($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][1][5])) || (($_SESSION["plateau"][$i][$j])==($_SESSION["plateau"][1][6]))){
			echo "<td>";
			echo "</td>";
		}else{
			echo "<td>";
			echo "<a href=\"main.php?x=$i&y=$j&command=$command\"\"><img src=" . (($_SESSION["plateau"][$i][$j]) ? "\"bille.jpg\"" : "\"vide.png\"") . "/></a>";
			echo "</td>";
		}
	}
	echo "</tr>\n";
=======
    echo "\t<tr>";
    for ($j = 0; $j < 7; $j++) {
        echo "<td>";
        echo "<a href=\"main.php?x=$i&y=$j&command=$command\"\"><img src=" . (($_SESSION["plateau"][$i][$j]) ? "\"bille.jpg\"" : "\"nada.png\"") . "/></a>";
        echo "</td>";
    }
    echo "</tr>\n";
>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
}
echo "</table>\n";
<<<<<<< HEAD
include("bottom.html"); //Pied de page
=======

include("bottom.html");    //Pied de page
>>>>>>> 0c4571bca892285b07e7850e5117c2083c01a38c
