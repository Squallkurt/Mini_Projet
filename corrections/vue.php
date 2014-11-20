<?php

class Vue
{

    function init()
    {
        ?>
        <html>
        <body>
        <br/>
        <br/>

        <form method="post" action="noyau.php">
            Entrer votre pseudo <input type="text" name="pseudo"/>
            </br>
            Entrer votre message <input type="text" name="message"/>
            </br>
            </br>
            <input type="submit" name="soumettre" value="envoyer"/>
        </form>
        <br/>
        <br/>
        </body>
        </html>
    <?php
    }


    function generer($salon, $pseudoExiste)
    {
        ?>

        <html>
        <body>
        <?php
        //header("Content-type: text/html; charset=utf-8");
        if (!$pseudoExiste) {
            echo " <h1> il faut que vous soyez enregistré dans le salon ou saisir un message !!!!!!! </h1> <br/> <br/> <br/>";
        }
        ?>
        <br/>
        <br/>

        <form method="post" action="noyau.php">
            Entrer votre pseudo <input type="text" name="pseudo"/>
            </br>
            Entrer votre message <input type="text" name="message"/>
            </br>
            </br>
            <input type="submit" name="soumettre" value="envoyer"/>
        </form>
        <br/>
        <br/>



        <?php
        foreach ($salon as $message) {
//var_dump($tabMessage);
            echo $message["pseudo"] . ": " . $message["message"] . "<br/>";
        }




        ?>
        </body>
        </html>
    <?php
    }
}

?>
