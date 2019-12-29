<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
 //error_reporting(E_ALL);
 //ini_set('display_errors', 1); 

include_once("connexion.php");


$mytable ="cards";


$data = json_decode(file_get_contents("php://input"));



//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $card_id = (property_exists($data, 'id')) ? $data->id : "";




try
    {
        $query = "DELETE FROM $mytable where id={$card_id}";
  
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