<?php

include 'bdd.php';
 
 $iduser = $_POST['iduser'];

$result = $co->prepare("UPDATE Module SET current = 0 where id_user = ?");
 $result->execute(array( $iduser));

 echo json_encode($result);

?>
