<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
 //error_reporting(E_ALL);
 //ini_set('display_errors', 1); 

include_once("connexion.php");


$mytable ="payins";


$data = json_decode(file_get_contents("php://input"));



//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $wallet_id = (property_exists($data, 'wallet_id')) ? $data->wallet_id : "";
  $amount = (property_exists($data, 'amount')) ? $data->amount : "";



try
    {
        $query = "INSERT INTO $mytable (wallet_id, amount) 
	                VALUES ('$wallet_id', '$amount')";
  
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