
 <?php
 
  include 'bdd.php';
  include("classes/Aliment.php");
  include("classes/Module.php");
include("classes/Program.php");
include("classes/DailyMenu.php");
include("classes/User.php");


	$rqent = "SELECT name FROM Aliment ";
	$rq = $co->query($rqent);
	$rq = $rq->fetchAll();

	$aliments = array();

	foreach ($rq as $value) {

		array_push($aliments, $value['name']);

	}

	echo json_encode($aliments);

?>