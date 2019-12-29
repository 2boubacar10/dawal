<?php 
					
	try
	{

	$base = 	new PDO ('mysql:host=localhost;dbname=commandes','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e){
		die('Erreur: '.$e->getMessage());
	}
?>
