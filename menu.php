


<?php

function getMenu($iduser){
	
$rqent = "SELECT * FROM User inner join Module ON User.id_user = Module.id_user WHERE User.id_user = ? AND Module.current = ?";
	$rq = $co->prepare($rqent);
	$rq->execute(array($iduser, 1));

		$res = $rq->fetchAll();

		$res = $res[0];
    $user = new User($res["id_user"],$res["firstname"], $res["lastname"], $res["weight"], $res["size"], $res["age"], $res["sex"], $res["email"], $res["birthday"]);


    
    if($res["name"] != ""){

    $module = new Module($res["id_user"], $res["name"], $res["startDate"], $res["endDate"], $res["typeOfTraining"]);

    $id_module = $res["id_module"];


   $query2 = "SELECT * FROM DailyMenu WHERE id_module = $id_module ";
	$rq = $co->prepare($query2);
	$rq->execute(array($id_module));

	$allMenus = $rq->fetchAll();


	/*$a_breakfast=array();
	$a_snack1=array();
	$a_lunch=array();
	$a_snack2=array();
	$a_diner=array();*/

	$daily = "";

	$a_Program = array();


	for($k=0; $k<sizeof($allMenus); $k++) {
		

		$value = $allMenus[$k];
		$idMenu = $value['id_Menu'];

		$query3 = "SELECT * FROM DailyMenu NATURAL JOIN compose NATURAL JOIN meal WHERE dailymenu.id_Menu = ? ";
		$rq = $co->prepare($query3);
		$rq->execute(array($idMenu));
		$allMeal = $rq->fetchAll();


		$a_breakfast=array();
		$a_snack1=array();
		$a_lunch=array();
		$a_snack2=array();
		$a_diner=array();

			for($i=0; $i< sizeof($allMeal); $i++) {

				 $value2 = $allMeal[$i];
				$idMeal  = $value2['id_meal'];

				$query4 = "SELECT * FROM meal NATURAL JOIN contain NATURAL JOIN aliment WHERE meal.id_meal= ? ";
				$rq = $co->prepare($query4);
				$rq->execute(array($idMeal ));
				$meal = $rq->fetchAll();

			

				for ($j=0; $j< sizeof($meal); $j++) {

					 $value3 =  $meal[$j];
              
					$Aliment = new Aliment($value3['name'], $value3['quantity'], $value3['calories_per_100g'], 'no baking method', $value3['category']);

					switch ($value2['MealName']){
					case 'breakfast':
						array_push($a_breakfast, $Aliment);
					break;
					case 'snack morning':
						array_push($a_snack1, $Aliment);
					break;
					case 'lunch':
						array_push($a_lunch, $Aliment);
					break;
					case 'snack afternoon':
						array_push($a_snack2, $Aliment);
					break;
					case 'diner':
						array_push($a_diner, $Aliment);
					break;
					default:
					break;

					}
				
				}
			}


			$daily = new DailyMenu($a_breakfast, $a_snack1, $a_lunch, $a_snack2, $a_diner);
	
	        array_push($a_Program, $daily);
	}




	$Program = new Program($a_Program);
	$Program->setAlimentList();

	$module->setProgram($Program);
	$user->setModule($module);

  }

	return $user;
}



?>