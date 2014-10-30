<?php
/**
 * Created by PhpStorm.
 * User: Fx
 * Date: 30/10/2014
 * Time: 18:27
 */

session_start();

if (!isset($_SESSION["plateau"])) {
    $_SESSION["plateau"] = array(array());
    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            $_SESSION["plateau"][$i][$j] = true;
        }
    }

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

    $_SESSION["plateau"][5][5] = false;
    $_SESSION["plateau"][5][6] = false;
    $_SESSION["plateau"][6][5] = false;
    $_SESSION["plateau"][6][6] = false;


}

include("head.html");

echo "<table>\n";

for ($i = 0; $i < 7; $i++) {
    echo "\t<tr>";
    for ($j = 0; $j < 7; $j++) {
        echo "<td>";
        echo ($_SESSION["plateau"][$i][$j]) ? "<img src=\"pion.jpg\"/>" : "vide" ;
        echo "</td>";
    }
    echo "</tr>\n";
}

echo "</table>\n";


include("bottom.html");