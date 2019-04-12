
<?php

include 'bdd.php';
include("classes/Module.php");
include("classes/Aliment.php");
include("classes/Program.php");
include("classes/DailyMenu.php");

$iduser = $_POST['iduser'];
$day =  $_POST['day'];

$breakfast = convertBool($_POST['breakfast']);
$snack1 = convertBool($_POST['snack1']);
$lunch = convertBool($_POST['lunch']);
$snack2 = convertBool($_POST['snack2']);
$diner = convertBool($_POST['diner']);



$a_idmenu= $co->query("SELECT compose.done as done , compose.id_Menu as id_Menu, compose.id_meal as id_meal from Module inner join dailymenu on module.id_module = dailymenu.id_module inner join compose on dailymenu.id_Menu=compose.id_Menu where module.id_user = $iduser AND module.current = 1 AND dailymenu.day = $day");





if($a_idmenu->rowCount() === 3){

	$a_idmenu = $a_idmenu->fetchAll();
	$idbreakfast = $a_idmenu[0]["id_meal"];
	$idlunch= $a_idmenu[1]["id_meal"];
	$iddiner = $a_idmenu[2]["id_meal"];

   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ?");
			$result->execute(array($breakfast, $idbreakfast));
   
   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ?");
			$result->execute(array($lunch, $idlunch));
   
   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ?");
			$result->execute(array($diner, $iddiner));


}else{

	$a_idmenu = $a_idmenu->fetchAll();
	$idbreakfast = $a_idmenu[0]["id_meal"];
	$idsnack1= $a_idmenu[1]["id_meal"];
	$idlunch= $a_idmenu[2]["id_meal"];
	$idsnack2= $a_idmenu[3]["id_meal"];
	$iddiner = $a_idmenu[4]["id_meal"];

   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ? ");
			$result->execute(array($breakfast, $idbreakfast));

   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ? ");
			$result->execute(array($snack1, $idsnack1));

   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ? ");
			$result->execute(array($lunch, $idlunch));

   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ? ");
			$result->execute(array($snack2, $idsnack2));

   $result = $co->prepare("UPDATE compose set done = ? WHERE id_meal = ? ");
			$result->execute(array($diner, $iddiner));

} 


echo json_encode($snack2);


/*SELECT compose.done as done, compose.id_Menu as id_Menu, compose.id_meal as id_meal from Module inner join dailymenu on module.id_module = dailymenu.id_module inner join compose on dailymenu.id_Menu = compose.id_Menu where module.id_user = 3 AND module.current =1 AND dailymenu.day = 1*/


function convertBool($var){
	if($var === 'true'){
		return 1;
	}else{
		return 0;
	}
}


?>