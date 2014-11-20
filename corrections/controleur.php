<?php
//require "modele.php";
//require "vue.php";

class Controleur
{

    private $modele;
    private $vue;

    public function __construct($view, $modele)
    {
        $this->modele = $modele;
        $this->vue = $view;
    }

    function gererSalon($pseudo, $message)
    {
        try {

            if (!isset($pseudo)) {
                $salon = $this->modele->get10RecentMessage();
                $this->vue->generer($salon, false);
            } else {
                if (!empty($pseudo) && $this->modele->exists($pseudo) && (!empty($message))) {
                    $this->modele->majChat($pseudo, $message);
                    $salon = $this->modele->get10RecentMessage();
                    $this->vue->generer($salon, true);
                } else {
                    $salon = $this->modele->get10RecentMessage();
                    $this->vue->generer($salon, false);
                }
            }

        }// fin try
        catch (ConnexionException $e) {
            echo $e->afficher();
            exit;

        } catch (TableAccesException $e) {
            echo $e->afficher();
            exit;

        }
    }
}

?>
