<?php
 
  include 'bdd.php';
  include("classes/Aliment.php");
  include("classes/Module.php");
include("classes/Program.php");
include("classes/DailyMenu.php");
include("classes/User.php");



$aliment = $_POST['aliment'];
$iduser = $_POST['iduser'];

 $a_idaliment = $co->prepare("SELECT id_aliment from Aliment WHERE name = ?");
 $a_idaliment->execute(array($aliment));
 

 $idaliment = $a_idaliment->fetchAll();
 $idaliment = $idaliment[0]["id_aliment"];


  $insertallergy = $co->prepare("INSERT INTO Allergyprone (id_aliment , id_user) VALUES(?, ?)");
  $insertallergy->execute(array($idaliment, $iduser));

?>