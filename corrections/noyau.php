<?php
require "modele.php";
require "vue.php";
require "controleur.php";

$modele = new Modele();
$vue = new Vue();;
$controleur = new Controleur($vue, $modele);

$controleur->gererSalon($_POST["pseudo"], $_POST["message"]);
?>
