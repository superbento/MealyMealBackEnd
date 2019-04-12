
<?php

include 'bdd.php';

$today = htmlentities($_POST['today']);
$startDate = htmlentities($_POST['startdate']);
$iduser = $_POST['iduser'];

$today = new DateTime($today);
$startDate =  new DateTime($startDate);

$days = $startDate->diff($today);
$days = $days->format('%R%a');


 $result = $co->prepare("SELECT SUM(compose.done) as done, compose.id_Menu as id_Menu from Module inner join dailymenu on module.id_module = dailymenu.id_module inner join compose on dailymenu.id_Menu = compose.id_Menu where module.id_user = ? AND module.current = ? AND dailymenu.day < ? group by id_Menu");
 $result->execute(array($iduser, 1, $days));


 $array = array(); 

 $result = $result->fetchAll();

foreach ($result as $value) {
	 if ($value['done'] === NULL){
	 	$done = $value['done'];
	 }else{
	 	$done = $value['done'];
	 }

	$percentage = (intval($done)/5)*100 ;
	array_push($array , $percentage);
}

echo json_encode($array);


?>