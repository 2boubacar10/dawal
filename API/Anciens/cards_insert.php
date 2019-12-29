<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
 //error_reporting(E_ALL);
 //ini_set('display_errors', 1); 

include_once("connexion.php");


$mytable ="cards";


$data = json_decode(file_get_contents("php://input"));



//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $user_id = (property_exists($data, 'user_id')) ? $data->user_id : "";
  $last_4 = (property_exists($data, 'last_4')) ? $data->last_4 : "";
  $brand = (property_exists($data, 'brand')) ? $data->brand : "";
  $expired_at = (property_exists($data, 'expired_at')) ? $data->expired_at : "";


try
    {
        $query = "INSERT INTO $mytable (last_4, brand, expired_at, user_id) 
                    VALUES ('$last_4', '$brand', '$expired_at', '$user_id')";
  
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