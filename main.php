<?php
/**
 * Created by PhpStorm.
 * User: Fx
 * Date: 30/10/2014
 * Time: 18:27
 */
session_start(); // Démarrage d'une session
error_reporting(1);
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
        // Pion choisi, on l'enregistre en session: on vérifie que l'on a cliqué sur un pion, et non sur une case vide
        if (choixOk(array("x" => $_GET["x"], "y" => $_GET["y"]))) {
            $_SESSION["choix"] = array("x" => $_GET["x"], "y" => $_GET["y"]);
            $command = "action";
        }
    } else if ($command == "action") {

        if (mouvementPossible(array("x" => $_GET["x"], "y" => $_GET["y"]), $_SESSION["choix"])) {
            $command = "choix";
        }
    }
}
if (!isset($_SESSION["plateau"])) { // Si le plateau n'existe pas :
    resetPlateau(); // On le créer
}
/* Fonction qui créer le plateau de jeu ou a défaut qui permet de le re-créer en cas d'erreur de l'utilisateur dans l'URL
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

/*Fonction qui permet à l'utilisateur de jouer un coup après le retrait de la bille au démarrage.
On test d'abord si la bille selectionnée par l'utilisateur existe, ensuite on test si la case cible est bien vide
Si c'est le cas, on va faire un test pour savoir si la case cible est bien égale
à la case ce trouvant deux cases a coté de la bille selectionnée (un cas pour gauche, un pour droit, un pour haut et un pour bas)
et si la case entre la bille selectionnée et la case cible, contient bien une bille.
Si c'est le cas, on fait le mouvement, sinon l'utilisateur recevra un message disant que le mouvement n'est pas possible*/
/**
 * @param $point1 Destination
 * @param $point2
 * @return bool true si le mouvement est possible, sinon false
 */
function mouvementPossible($point1, $point2)
{
    // Si on ne se déplace pas de deux cases horizontalement ou verticalement, alors déplacement impossible
    if ((abs($point1["x"] - $point2["x"]) != 2) && (abs($point1["y"] - $point2["y"]) != 2)) {
        return false;
    }

    // Si la case d'arrivée ($point1) est occupée, alors déplacement impossible
    if ($_SESSION[$point1["x"]][$point1["y"]]) {
        return false;
    }

    // Déplacement vertical
    if ($point1["x"] == $point2["x"]) {
        if ($point1["y"] > $point2["y"]) {
            $inc = -1;
        } else {
            $inc = 1;
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
            $inc = -1;
        } else {
            $inc = 1;
        }
        if ($_SESSION["plateau"][$point1["x"] + $inc][$point1["y"]]) {
            $_SESSION["plateau"][$point1["x"] + $inc][$point1["y"]] = false;
            $_SESSION["plateau"][$point2["x"]][$point2["y"]] = false;
            $_SESSION["plateau"][$point1["x"]][$point1["y"]] = true;
            return true;
        }
    }
}

/**
 * Vérifie que le point est jouable: il doit s'agir d'un pion
 * @param $point Point à tester
 * @return bool true si le point est un pion, sinon false
 */
function choixOk($point)
{
    return $_SESSION["plateau"][$point["x"]][$point["y"]];
}

// Fonction qui test si un mouvement est encore possible
function aucunMouvementPossible()
{
    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            if ($_SESSION["plateau"][$i][$j] == true) {
                try {
                    if (($_SESSION["plateau"][$i + 1][$j] == true) && ($_SESSION["plateau"][$i + 2][$j] == false)) {
                        return false;
                    }
                } catch (Exception $e) {
                }
                try {
                    if (($_SESSION["plateau"][$i - 1][$j] == true) && ($_SESSION["plateau"][$i - 2][$j] == false)) {
                        return false;
                    }
                } catch (Exception $e) {
                }
                try {
                    if (($_SESSION["plateau"][$i][$j + 1] == true) && ($_SESSION["plateau"][$i][$j + 2] == false)) {
                        return false;
                    }
                } catch (Exception $e) {
                }
                try {
                    if (($_SESSION["plateau"][$i][$j - 1] == true) && ($_SESSION["plateau"][$i][$j - 2] == false)) {
                        return false;
                    }
                } catch (Exception $e) {
                }

            }
        }

        // Si on arrive jusque là, c'est que l'on a trouvé aucune possibilité de mouvement
        return true;
    }
}

// Fonction qui donne le résultat final suivant le déroulement du jeu
function resultat()
{

    $cpt = 0;
    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            if ($_SESSION["plateau"][$i][$j] == true) {
                $cpt++;
            }
        }
    }
    if ($cpt == 1) {
        echo "vous avez gagné !!!";
    } else {
        echo "vous avez perdu !!!";
    }

}

include("head.html");    //Entete de la page

// Affichage du plateau de jeu
echo "<table>\n";

for ($i = 0; $i < 7; $i++) {
    echo "\t<tr>";
    for ($j = 0; $j < 7; $j++) {
        echo "<td>";
        echo "<a href=\"main.php?x=$i&y=$j&command=$command\"\"><img src=" . (($_SESSION["plateau"][$i][$j]) ? "\"bille.jpg\"" : "\"vide.png\"") . "/></a>";
        echo "</td>";
    }
    echo "</tr>\n";
}

echo "</table>\n";

include("bottom.html");    //Pied de page