
<?php
 
  include 'bdd.php';
  include("classes/Aliment.php");
  include("classes/Module.php");
include("classes/Program.php");
include("classes/DailyMenu.php");
include("classes/User.php");



$alimentname = $_POST['alimentname'];
$iduser = $_POST['iduser'];

 $a_idaliment = $co->prepare("SELECT id_aliment from Aliment WHERE name = ?");
 $a_idaliment->execute(array($alimentname));
 

 $idaliment = $a_idaliment->fetchAll();
 $idaliment = $idaliment[0]["id_aliment"];


  $insertallergy = $co->prepare("DELETE FROM Allergyprone WHERE id_aliment = ? AND id_user = ?");
  $insertallergy->execute(array($idaliment, $iduser));


  echo json_encode($alimentname);

?>