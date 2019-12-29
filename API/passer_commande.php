<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
 ?>

<?php

include_once('connexion.php');

$mytable ="cmd_commande";
$table_token="cmd_users_token";


try
{

foreach ($_POST as $key => $value) {
  //on cree des variabeles de façon automatique, exemple: $token
  ${$key} = $value;
}

//on vérifie le token
include_once('user_token.php');
$verifToken = verifToken($base, $table_token, $token);


//on initialise les variables d'envoi de fichier
$envoi_audio = array(
    "status" => "error",
    "error" => true,
    "message" => "Erreur de téléchargement du fichier : audio"
);
$envoi_bdd = array(
    "status" => "error",
    "error" => true,
    "message" => "Erreur de téléchargement du fichier : base de donnees"
);

if(isset($_FILES['fichierAudio']))
$envoi_audio = upload_fichier($_FILES['fichierAudio'], 'audio');

if(isset($_FILES['baseDeDonnees']))
$envoi_bdd = upload_fichier($_FILES['baseDeDonnees'], 'base de donnees');



if($envoi_audio['error']){
  echo json_encode($envoi_audio);
  exit;
}

if($envoi_bdd['error']){
  echo json_encode($envoi_bdd);
  exit;
}



//echo json_encode($response);



//var_dump($_POST);exit;


//nous avons les variables suivantes:
/*
description
langue
nbreCible
type
token
*/

$audio = $envoi_audio['name'];
$base_de_donnees = $envoi_bdd['name'];


$query = "INSERT INTO $mytable (description, langue, nbreCible, type, audio, base_de_donnees) 
                  VALUES ('$description', '$langue', '$nbreCible', '$type', '$audio', '$base_de_donnees')";
  
    $results = $base->exec($query);
    if($results){
      $reponse = array(
                "status" => "success",
                "error" => false,
                "message" => "Votre commande a été enregistrée avec succès."
              );
      echo json_encode($reponse);
    }else{
      $reponse = array(
                "status" => "erreur",
                "error" => true,
                "message" => "Erreur lors de l'enregistrement dans la base de données."
      );
      echo json_encode($reponse);
    }

}catch (Exception $e) {
        $reponse = array(
                "status" => "erreur",
                "error" => true,
                "message" => "Erreur lors de l'enregistrement."
              );
        echo json_encode($reponse);
          echo json_encode($e);
          exit;
}




function upload_fichier($fichier, $type){
    //repertoire ou on envoi le fichier
    $upload_dir = '../uploads/';

    $name = $fichier["name"];
    $tmp_name = $fichier["tmp_name"];
    $error = $fichier["error"];
    if($error > 0){
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Erreur de téléchargement du fichier : " . $type
        );
    }else 
    {
        $random_name = rand(1000,1000000)."-".$name;
        $upload_name = $upload_dir.strtolower($random_name);
        $upload_name = preg_replace('/\s+/', '-', $upload_name);
    
        if(move_uploaded_file($tmp_name , $upload_name)) {
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "Fichier chargé avec succès: ".$type,
                "name" => $random_name
              );
        }else
        {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Erreur de téléchargement du fichier: ".$type
            );
        }
    }

    return $response;
}



exit;


?>