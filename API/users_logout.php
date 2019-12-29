<?php header('Access-Control-Allow-Origin: *'); ?>

<?php

include_once('connexion.php');

$table_token="cmd_users_token";

$infos = json_decode(file_get_contents("php://input"));


try
    {



//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $token = (property_exists($infos, 'token')) ? addslashes($infos->token) : "";


//On accède au contenu de la base avec la commande SELECT.
$query = "DELETE FROM $table_token where token='$token'";


$results = $base->query($query);

if($results){
  echo "Utilisateur déconnecté avec succès";
}


$results->closeCursor(); 

}catch (Exception $e) {
        $reponse = array(
        	'etat' => "erreur",
        	'message' => "Erreur serveur"

        );
          echo json_encode($reponse);
          exit;
    }
exit;


?>