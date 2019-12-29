<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
 //error_reporting(E_ALL);
 //ini_set('display_errors', 1); 

include_once("connexion.php");


$mytable ="users";


$data = json_decode(file_get_contents("php://input"));



//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $firstname = (property_exists($data, 'firstname')) ? $data->firstname : "";
  $lastname = (property_exists($data, 'lastname')) ? $data->lastname : "";
  $email = (property_exists($data, 'email')) ? $data->email : "";
  $password = (property_exists($data, 'motdepasse')) ? $data->motdepasse : "";
  //$is_admin = (property_exists($data, 'is_admin')) ? $data->is_admin : "0/1";



try
    {

    $firstname= addslashes($firstname);

        $query = "INSERT INTO $mytable (first_name, last_name, email,password, is_admin) 
	                VALUES ('$firstname', '$lastname', '$email', '$password', 0)";
  
    $results = $base->exec($query);
    if($results){
      $reponse = array('message' => "bon");
      echo json_encode($reponse);
    }else{
      $reponse = array('message' => "erreur");
      echo json_encode($reponse);
    }
	  
    }
catch (Exception $e) {
        $reponse = array('message' => "erreur");
          echo json_encode($reponse);
    }
?>