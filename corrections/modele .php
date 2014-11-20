<?php

// Classe generale de definition d'exception
class MonException extends PDOException
{
    private $chaine;

    public function __construct($chaine)
    {
        $this->chaine = $chaine;
    }

    public function afficher()
    {
        return $this->chaine;
    }

}


// Exception relative à un probleme de connexion
class ConnexionException extends MonException
{
}

// Exception relative à un probleme d'accès à une table
class TableAccesException extends MonException
{
}


// Classe qui gère les accès à la base de données

class Modele
{

    private $connexion;


    // methode qui permet de se connecter à la base

// s'il y a un problème de connexion, une exception de type ConnexionException est levée. 

    public function get10RecentMessage()
    {
        $this->connexion();

        try {

            $statement = $this->connexion->query("SELECT pseudonyme.pseudo ,salon.message FROM salon, pseudonyme where salon.idpseudo=pseudonyme.id ORDER BY salon.id DESC LIMIT 0, 10;");
            return ($statement->fetchAll(PDO::FETCH_ASSOC));

        } catch (PDOException $e) {
            $this->deconnexion();
            throw new TableAccesException("problème avec la table salon get");
        }
    }


    // méthode qui permet de se deconnecter de la base

    public function connexion()
    {
        try {
            $chaine = "mysql:host=localhost;dbname=hadjrabia-n";
            $this->connexion = new PDO($chaine, "hadjrabia-n", "");
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $exception = new ConnexionException("problème de connection à la base");
            throw $exception;
        }
    }


// méthode qui permet de récupérer les 10 derniers post sur le salon

    public function deconnexion()
    {
        $this->connexion = null;
    }



// ajoute un post sur le chat => pseudo + message
// precondition: le pseudo existe dans la table chat

    public function majChat($pseudo, $texte)
    {
        $this->connexion();
        try {
            $statement = $this->connexion->query("select id from pseudonyme where pseudo='$pseudo';");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $statement = $this->connexion->query("INSERT INTO salon (idpseudo, message) VALUES(" . $result['id'] . ",'$texte');");

        } catch (PDOException $e) {
            $this->deconnexion();
            throw new TableAccesException("problème avec la table salon");
        }
    }


    public function exists($pseudo)
    {

        $this->connexion();
        try {
            $statement = $this->connexion->query("select id from pseudonyme where pseudo='$pseudo';");
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result["id"] != NUll) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->deconnexion();
            throw new TableAccesException("problème avec la table pseudonyme");
        }


    }


}

?>
