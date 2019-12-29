<?php header('Access-Control-Allow-Origin: *'); ?>

<?php

include_once('connexion.php');

$mytable ="cmd_users";
$table_token="cmd_users_token";

$infos = json_decode(file_get_contents("php://input"));

$salt = "Jklnt@2016&&";


try
    {



//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $email = (property_exists($infos, 'email')) ? addslashes($infos->email) : "";
  $mot_de_passe = (property_exists($infos, 'motdepasse')) ? addslashes($infos->motdepasse) : "";


$mot_de_passe = sha1($salt.$mot_de_passe);

//On accède au contenu de la base avec la commande SELECT.
$query = "SELECT prenom, nom, email, is_admin FROM $mytable where email='$email' and mot_de_passe='$mot_de_passe'";


$results = $base->query($query);

//On crée un tableau pour stocker les resultats
$data= array();

$token="";

while ($res= $results->fetch())
{

$data['infosUser'] = $res;

//on recupère le token
include_once('user_token.php');
$token = getToken($base, $table_token, $email);
}


if(sizeof($data)==0){
	$data["identifiant"]="incorrect";
}else{
	$data['etat'] = "bon";
	$data['token'] = $token;
}

//you can return a JSON array
print json_encode($data);

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