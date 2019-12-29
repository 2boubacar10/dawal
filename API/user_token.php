<?php

//methode pour envoyer et recupèrer le token envoyer dans la base de données
function getToken($base, $table, $email){

	try {
	$token = sha1(uniqid());
	$query = "
	DELETE FROM $table where email_user='$email';
	INSERT INTO $table (`email_user`, `token`) VALUES ('$email', '$token');
	";
  
	$results = $base->exec($query);
	return $token;

	} catch (Exception $e) {
		var_dump($e);
	}

}

function verifToken($base, $table, $token){


	//On accède au contenu de la base avec la commande SELECT.
		$query = "SELECT token FROM $table where token=$token";

		$results = $base->query($query);

		//On crée un tableau pour stocker les resultats
		$data= array();

		$token="";

		while ($res = $results->fetch())
		{
		$data['token'] = $res;
		}


		if(sizeof($data)==0){
			$response = array(
            "status" => "error",
            "error" => true,
            "message" => "Veuillez vous reconnecter!"
		);

		echo json_encode($response);
		exit;
		return false;
		}else{
			return true;
		}
}

?>