<?php header('Access-Control-Allow-Origin: *'); ?>

<?php

include_once('connexion.php');

$mytable ="cmd_users";

$salt = "Jklnt@2016&&";

$data = json_decode(file_get_contents("php://input"));


$tableauDonnees = array();

/**
 * 
 */
class Utilisateur
{
	public $prenom;
	public $nom;
	public $email;
	public $telephone;
	public $password;
	public $passwordC;
}

$perso = new Utilisateur;

//meme fonction que isset, mais donne un résultat même quand la valeur est null
  $perso->prenom = addslashes((property_exists($data, 'prenom')) ? $data->prenom : "");
  $perso->nom = addslashes((property_exists($data, 'nom')) ? $data->nom : "");
  $perso->email = addslashes((property_exists($data, 'email')) ? $data->email : "");
  $perso->telephone = addslashes((property_exists($data, 'telephone')) ? $data->telephone : "");
  $perso->password = addslashes((property_exists($data, 'motdepasse')) ? $data->motdepasse : "");
  $perso->passwordC = addslashes((property_exists($data, 'motdepasseconfirmer')) ? $data->motdepasseconfirmer : "");

  if($perso->password != $perso->passwordC){
  	$reponse = array('message' => "Les deux mots de passe ne correspondent pas");
  	echo json_encode($reponse);
	exit;
  }


 $perso->password = sha1($salt.$perso->password);



try
    {

    	//On regarde si l'email n'est pas déjà dans la plateforme
		$query = "SELECT email FROM $mytable where email='$perso->email' or telephone='$perso->telephone'";

		$results = $base->query($query);

		//On crée un tableau pour stocker les resultats
		$data= array();

		while ($res= $results->fetch())
		{
		//insert row into array
		array_push($data, $res);
		}

		$nbreUser = sizeof($data);


		if($nbreUser==0){

			$query = "INSERT INTO $mytable (prenom, nom, email, telephone, mot_de_passe, is_admin) 
	                VALUES ('$perso->prenom', '$perso->nom', '$perso->email','$perso->telephone', '$perso->password', 0)";
  
		    $results = $base->exec($query);
		    if($results){
		      $reponse = array(
				'etat' => "bon",
				'message' => "Vos identifiants ont été créées avec succès."
			);
		      
		      echo json_encode($reponse);
		    }else{
		      $reponse = array(
		      	'etat' => "erreur",
		      	'message' => "Erreur serveur. Veuillez-nous contacter"
		      );
		      echo json_encode($reponse);
		      exit;
		    }

		}else{
			//un utilisateur avec cet email ou ce numéro de téléphone existe déjà
			$erreur = array(
				'message' => "Un utilisateur avec ce numéro ou cet e-mail existe déjà sur notre plateforme",
				'etat' => "erreur"
			);
			echo json_encode($erreur);
			exit;
		}

	
	  
    }
catch (Exception $e) {
        $reponse = array('message' => "erreur");
          echo json_encode($reponse);
          exit;
    }
?>