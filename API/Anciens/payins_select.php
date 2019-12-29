<?php header('Access-Control-Allow-Origin: *'); ?>

<?php


include_once('connexion.php');

$mytable ="payins";


//On accède au contenu de la base avec la commande SELECT.
$query = "SELECT * FROM $mytable";
$results = $base->query($query);



//On crée un tableau pour stocker les resultats
$data= array();


while ($res= $results->fetch())
{
//insert row into array
array_push($data, $res);
}

//you can return a JSON array
print json_encode($data);

$results->closeCursor(); 
exit;

/*
while ($row = $results->fetchArray()) {
   echo $row['id_comment'];
   echo $row['contenu_comment']; 
   echo $row['id_art_comment_fk'];
   echo $row['id_commentateur_fk'];
   echo "<br>";
   echo "<br>";
}*/


?>