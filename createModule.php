<?php

include 'bdd.php';
include("classes/Module.php");
include("classes/Aliment.php");
include("classes/Program.php");
include("classes/DailyMenu.php");



$calorienum = htmlentities($_POST['calories']);

$activityfactor = htmlentities($_POST['activityfactor']);
$choosenmodule = htmlentities($_POST['choosenmodule']);

$enddate= htmlentities($_POST['enddate']);
$startdate = htmlentities($_POST['startdate']);

$enddatetime = new DateTime(htmlentities($_POST['enddate']));
$startdatetime = new DateTime(htmlentities($_POST['startdate']));
$iduser = htmlentities($_POST['iduser']);


$objectif = htmlentities($_POST['objectif']);
$hours = htmlentities($_POST['hours']);
$activity = htmlentities($_POST['activity']);

$days = $startdatetime->diff($enddatetime);
$days = $days->format('%R%a');


if( empty($activityfactor) ){
	$activityfactor = 0.0;
}else if(empty($activity) && empty($objectif) && empty($hours)){
	$activity = "no activity";
	$objectif = 0;
	$hours = 0.0;
}
 

     
	//$iduser = 20;
    $_allergies = "";
    //$allergies = array();
    $a_allergy = $co->prepare("SELECT Aliment.name as name from allergyprone natural join Aliment where allergyprone.id_user = ? ");
    $a_allergy->execute(array($iduser));

    if($a_allergy->rowCount() != 0){

    	

    	$a_allergy = $a_allergy->fetchAll();
    	$k = 0;
    	foreach ($a_allergy as $value) {

    		//array_push($allergies, $value["name"]);
    			$allergy  = $value["name"];
    			//echo $allergy."<br>";
    		if($k === 0){
    			$_allergies .=  "'".$allergy."'";
	    	}else{
	    		$_allergies .=  ",'".$allergy."'";
	    	}
	    	$k++;
    	}

    	//echo "hello ".$_allergies."\n";

 }



 //echo $co->query("SELECT * from Aliment where category = 'Vegetable' AND name NOT IN('eggplant','pork')" );
/*
 $calorienum=2400;
 $days=20;
 $choosenmodule = "GainWeight";
 $idmodule=17;
 $iduser = 18;*/


 if($choosenmodule === "GainWeight"){
	$o_program = createMenu($_allergies);
 }else{
 	$o_program = createMenu2($_allergies);
 }


$current=1;

$result = $co->prepare("INSERT INTO Module(name,typeOfTraining, startDate, endDate, current, id_user, goal, hours, activity) VALUES(?,?,?,?,?,?,?,?,?)");
 $result->execute(array($choosenmodule, $activityfactor, $startdate, $enddate, $current , $iduser, $objectif, $hours, $activity));

$a_idmodule = $co->query("SELECT id_module from Module where id_module = (SELECT MAX(id_module) from Module)");

$a_idmodule = $a_idmodule->fetchAll();

$idmodule = $a_idmodule [0]["id_module"] ;

//echo json_encode($res);




  for($i=0; $i < sizeof($o_program->getGlobalMenu()); $i++){

  	   $result = $co->prepare("INSERT INTO dailymenu(id_module, day) VALUES(?,?) ");

  	        $day = $i+1;
			$result->execute(array($idmodule, $day));

		$a_idmenu = $co->query("SELECT id_Menu from dailymenu where id_Menu = (SELECT MAX(id_Menu) from dailymenu)");
		$a_idmenu = $a_idmenu->fetchAll();
		$idmenu = $a_idmenu[0]["id_Menu"] ;


  		$Daily = $o_program->getGlobalMenu()[$i];
  	    
  	   //echo "<br><br><br><br><Strong style='font-size:5vw; color:green'> Jour ".($i+1)."</Strong><br><br><br><br>";

  	  // echo "<br> <strong>breakfast</strong> <br>";

		  $result = $co->prepare("INSERT INTO meal(MealName) VALUES(?) ");
			$result->execute(array("breakfast"));

		$a_idmeal = $co->query("SELECT id_meal from meal where id_meal = (SELECT MAX(id_meal) from meal)");
		$a_idmeal = $a_idmeal->fetchAll();
		$idmeal = $a_idmeal[0]["id_meal"];

		 foreach ($Daily->getBreakFast() as  $value) {
		 	
		 	$name = $value->getName();
			$quantity = $value->getQuantity();
			//echo $name;
			insertmeal($idmeal, $name, $quantity);

		 }
		 insertmenu($idmenu, $idmeal);






		if(!empty($Daily->getSnack1())){

			    $result = $co->prepare("INSERT INTO meal(MealName) VALUES(?) ");
				$result->execute(array("snack morning"));

				$a_idmeal = $co->query("SELECT id_meal from meal where id_meal = (SELECT MAX(id_meal) from meal)");
				$a_idmeal = $a_idmeal->fetchAll();
				$idmeal = $a_idmeal[0]["id_meal"];

			  foreach ($Daily->getSnack1() as  $value) {
			 	
			 	$name = $value->getName();
				$quantity = $value->getQuantity();
				insertmeal($idmeal, $name, $quantity);
			 }
			  insertmenu($idmenu, $idmeal);

		}




		//echo "<br> <strong> lunch </strong> <br>";

		   $result = $co->prepare("INSERT INTO meal(MealName) VALUES(?) ");
			$result->execute(array("lunch"));

			$a_idmeal = $co->query("SELECT id_meal from meal where id_meal = (SELECT MAX(id_meal) from meal)");
			$a_idmeal = $a_idmeal->fetchAll();
			$idmeal = $a_idmeal[0]["id_meal"];

		   foreach ($Daily->getLunch() as  $value) {
		 	 
		 	 $name = $value->getName();
			$quantity = $value->getQuantity();

			insertmeal($idmeal, $name, $quantity);

		 }
		  insertmenu($idmenu, $idmeal);




		//echo "<br> <strong> snack 2 </strong> <br>";


		  if(!empty($Daily->getSnack2())){

			   $result = $co->prepare("INSERT INTO meal(MealName) VALUES(?) ");
				$result->execute(array("snack afternoon"));

				$a_idmeal = $co->query("SELECT id_meal from meal where id_meal = (SELECT MAX(id_meal) from meal)");
				$a_idmeal = $a_idmeal->fetchAll();
				$idmeal = $a_idmeal[0]["id_meal"];

			   foreach ($Daily->getSnack2() as  $value) {
			 	
			 	$name = $value->getName();

				$quantity = $value->getQuantity();

				insertmeal($idmeal, $name, $quantity);
			 }
			  insertmenu($idmenu, $idmeal);

		}


		//echo "<br><strong> diner </strong><br>";

		    $result = $co->prepare("INSERT INTO meal(MealName) VALUES(?) ");
			$result->execute(array("diner"));

			$a_idmeal = $co->query("SELECT id_meal from meal where id_meal = (SELECT MAX(id_meal) from meal)");
			$a_idmeal = $a_idmeal->fetchAll();
			$idmeal = $a_idmeal[0]["id_meal"];

		  foreach ($Daily->getDiner() as  $value) {
		 	 

		 	$name = $value->getName();
		 	$quantity = $value->getQuantity();
			insertmeal($idmeal, $name, $quantity);

		 }
		  insertmenu($idmenu, $idmeal);

  	  

  }



function insertmeal($idmeal, $name, $quantity){
	 GLOBAL $co;
	 
	$result = $co->prepare("SELECT id_aliment FROM aliment WHERE name = ? ");
	$result->execute(array($name));
	$aliments = $result->fetchAll();
	$idaliment = $aliments[0]["id_aliment"];

	$composemeal = $co->prepare("INSERT INTO contain(id_meal, id_aliment, quantity) VALUES(?,?,?) ");
	$composemeal->execute(array($idmeal, $idaliment, $quantity));
}


function insertmenu($idmenu, $idmeal){
	 GLOBAL $co;
	$composemenu = $co->prepare("INSERT INTO compose(id_Menu, id_meal) VALUES(?,?) ");
	$composemenu->execute(array($idmenu, $idmeal));
}



function createMenu($_allergies){

	GLOBAL $calorienum;

	GLOBAL $days;

	

	$breakfastNeeded = $calorienum/4;
	$lunchNeeded = $calorienum/4;
	$dinerNeeded = $calorienum/4;
	$snackNeeded = $calorienum/8;

$a_NutritionProgram = array();

	for($i=0;$i<=$days; $i++){

		//echo "breakfast";

		$a_brf = findAliment('breakfast',$breakfastNeeded, $_allergies);

		//echo "snack 1";

		$a_snack1 = findAliment('snack',$snackNeeded, $_allergies);

		//echo "lunch";

		$a_lunch = findAliment('dish',$lunchNeeded, $_allergies);

		//echo "snack 2";

		$a_snack2 = findAliment('snack',$snackNeeded, $_allergies);

		//echo "diner";

		$a_diner = findAliment('dish',$dinerNeeded, $_allergies);

		$daily = new DailyMenu($a_brf, $a_snack1, $a_lunch, $a_snack2, $a_diner);

		array_push($a_NutritionProgram, $daily);
	}

	return new Program($a_NutritionProgram);

}



function createMenu2($_allergies){

    GLOBAL $calorienum;

	GLOBAL $days;

	


    $breakfastNeeded = $calorienum/3;
    $lunchNeeded = $calorienum/3;
    $dinerNeeded = $calorienum/3;
    

    $a_NutritionProgram = array();

    for($i=0;$i<=$days; $i++){

        //echo "breakfast";

        $a_brf = findAliment('breakfast',$breakfastNeeded, $_allergies);
       

        //echo "lunch";

        $a_lunch = findAliment('dish',$lunchNeeded, $_allergies);

        //echo "snack 2";

        

        $a_diner = findAliment('dish',$dinerNeeded, $_allergies);

        $daily = new DailyMenu($a_brf, array(), $a_lunch, array(), $a_diner);

        array_push($a_NutritionProgram, $daily);
    }

    return new Program($a_NutritionProgram);

}





function findAliment($mealName, $cal_restriction, $_allergies){
    GLOBAL $co;
	$incertitude = $cal_restriction * 0.10;
    $aliments = array();

    GLOBAL $choosenmodule;
    //GLOBAL $_allergies;

	switch ($mealName){
		//$_allergies = "'".implode(' \',\' ' , $allergies)."'";
		case 'breakfast':

			$result = "";

			if($choosenmodule === "GainWeight"){
				$result = $co->prepare("SELECT * from Aliment where category = ? AND name NOT IN(".$_allergies.")" );
				$result->execute(array('breakfast'));
			}else{
				$result = $co->prepare("SELECT * from Aliment where category = ? AND HighCalories = 0 AND name NOT IN(".$_allergies.")" );
				$result->execute(array('breakfast'));
			}

			$result = $result->fetchAll();
			$nb = rand(0,sizeof($result)-1);

			$al1 = $result[$nb];

			$cal = produitEnCroix(100, $al1['calories_per_100g'], $al1['average_ration']);

			$quantity="";
			$quantity2="";


			if( $cal > ($cal_restriction + $incertitude) ){

				 $quantity = $cal_restriction/($al1['calories_per_100g']/100);

			}else if($cal >= ($cal_restriction - $incertitude) && $cal <= ($cal_restriction + $incertitude)){
				 $quantity = $cal/($al1['calories_per_100g']/100);
				 
			}else{

				$quantity = $cal/($al1['calories_per_100g']/100);

				$nb2=0;
				do{
					$nb2 = rand(0,sizeof($result)-1);
				}while($nb === $nb2);
                // echo "cccc "+$nb2;
				$al2 = $result[$nb2];
				$missingCalories = $cal_restriction - $cal;
				$quantity2 = $missingCalories/($al2['calories_per_100g']/100);
				
			}

			array_push($aliments, new Aliment($al1['name'], $quantity, $al1['calories_per_100g'], 'no baking method',$al1['category'] ));

			if($quantity2 != "")
				array_push($aliments, new Aliment($al2['name'], $quantity2, $al2['calories_per_100g'], 'no baking method',$al2['category'] ));

			break;

		case 'dish':

			$res = "";
			if($choosenmodule === "GainWeight"){
			    $res = $co->prepare("SELECT * from Aliment where (category =? OR category =?)  AND name NOT IN(".$_allergies.")" );
				$res->execute(array('Meat', 'Fish'));
			}else{
				$res = $co->prepare("SELECT * from Aliment where (category =? OR category =?) AND HighCalories = 0  AND name NOT IN(".$_allergies.")" );
				$res->execute(array('Meat', 'Fish'));
			}

			$res = $res->fetchAll();
			$nb = rand(0,sizeof($res)-1);

			$meat = $res[$nb];
			$meatCal = produitEnCroix(100, $meat['calories_per_100g'], $meat['average_ration']);



			if($choosenmodule === "GainWeight"){
					$res = $co->prepare("SELECT * from Aliment where category = ? AND name NOT IN(".$_allergies.")" );
					$res->execute(array('SideDish'));
			}else{
				$res = $co->prepare("SELECT * from Aliment where category = ? AND HighCalories = 0  AND name NOT IN(".$_allergies.")" );
					$res->execute(array('SideDish'));

			}

			$res = $res->fetchAll();
			$nb = rand(0,sizeof($res)-1);

			$sidedish = $res[$nb];
			$sidedishCal = produitEnCroix(100, $sidedish['calories_per_100g'], $sidedish['average_ration']);


			if($choosenmodule === "GainWeight"){
					$res = $co->prepare("SELECT * from Aliment where category = ? AND name NOT IN(".$_allergies.")" );
					$res->execute(array('Vegetable'));
			}else{
					$res = $co->prepare("SELECT * from Aliment where category = ? AND HighCalories = 0 AND name NOT IN(".$_allergies.")" );
					$res->execute(array('Vegetable'));
			}

			//echo "SELECT * from Aliment where category = 'Vegetable' AND name NOT IN($_allergies)";

			$res = $res->fetchAll();
			$nb = rand(0,sizeof($res)-1);

			$vegetable = $res[$nb];
			$vegetableCal = produitEnCroix(100, $vegetable['calories_per_100g'], $vegetable['average_ration']);

			$mealCal = $meatCal + $sidedishCal + $vegetableCal;

			$quantityMeat=0;
			$quantitySidedish=0;
			$quantityVegetable=0;

			//echo "calorieeees ".$mealCal." and ".$cal_restriction;

			if($mealCal > ($cal_restriction + $incertitude)){
               // echo "oui";
			}else if($mealCal >= ($cal_restriction - $incertitude) && $mealCal <= ($cal_restriction + $incertitude)){
				$quantityMeat = $meatCal/($meat['calories_per_100g']/100);
				//array_push($aliments, new Aliment($meat['name'], $quantityMeat, $meat['calories_per_100g'], 'no baking method', $meat['category'] ));

				$quantitySidedish = $sidedishCal/($sidedish['calories_per_100g']/100);
				//array_push($aliments, new Aliment($sidedish['name'], $quantitySidedish, $sidedish['calories_per_100g'], 'no baking method',$sidedish['category']));

				$quantityVegetable = $vegetableCal/($vegetable['calories_per_100g']/100);
				//array_push($aliments, new Aliment($vegetable['name'], $quantityVegetable, $vegetable['calories_per_100g'], 'no baking method',$vegetable['category'] ));
			}else{
				$missingCalories = $cal_restriction - $mealCal;

				if($missingCalories - $meatCal > $incertitude){

					$meatCal += $meatCal;
					$mealCal = $meatCal + $sidedishCal + $vegetableCal;
					$missingCalories  = $cal_restriction - $mealCal;

					$quantityMeat = $meatCal/($meat['calories_per_100g']/100);
					//array_push($aliments, new Aliment($meat['name'], $quantityMeat, $meat['calories_per_100g'], 'no baking method', $meat['category'] ));

					$quantitySidedish = ($sidedishCal+$missingCalories)/($sidedish['calories_per_100g']/100);
					//array_push($aliments, new Aliment($sidedish['name'], $quantitySidedish, $sidedish['calories_per_100g'], 'no baking method',$sidedish['category']));

					$quantityVegetable = $vegetableCal/($vegetable['calories_per_100g']/100);
					//array_push($aliments, new Aliment($vegetable['name'], $quantityVegetable, $vegetable['calories_per_100g'], 'no baking method',$vegetable['category'] ));

				}else if(($missingCalories - $meatCal) < $incertitude && ($missingCalories - $meatCal) > (0-$incertitude)){

					$meatCal += $meatCal;
					$mealCal = $meatCal + $sidedishCal + $vegetableCal;
					$missingCalories  = $cal_restriction - $mealCal;

					$quantityMeat = $meatCal/($meat['calories_per_100g']/100);
					$quantitySidedish = $sidedishCal/($sidedish['calories_per_100g']/100);
					$quantityVegetable = $vegetableCal/($vegetable['calories_per_100g']/100);
					//array_push($aliments, new Aliment($meat['name'], $quantityMeat, $meat['calories_per_100g'], 'no baking method', $meat['category'] ));

				}else if(($missingCalories - $meatCal) < (0-$incertitude)){

					$missingCalories = $cal_restriction-$mealCal;

					$quantityMeat = $meatCal/($meat['calories_per_100g']/100);
					$quantitySidedish = ($sidedishCal+$missingCalories)/($sidedish['calories_per_100g']/100);
					$quantityVegetable = $vegetableCal/($vegetable['calories_per_100g']/100);

					//echo 'found '.$missingCalories;
				}

			}

			array_push($aliments, new Aliment($meat['name'], $quantityMeat, $meat['calories_per_100g'], 'no baking method', $meat['category'] ));

			array_push($aliments, new Aliment($sidedish['name'], $quantitySidedish, $sidedish['calories_per_100g'], 'no baking method',$sidedish['category']));
			
			array_push($aliments, new Aliment($vegetable['name'], $quantityVegetable, $vegetable['calories_per_100g'], 'no baking method',$vegetable['category'] ));

		break;

		case 'snack':
			
			$result="";
			if($choosenmodule === "GainWeight"){
					$result = $co->prepare("SELECT * from Aliment where (category = ? OR category = ?) AND name NOT IN(".$_allergies.")" );
					$result->execute(array('snack','Fruit'));
			}else{
					$result = $co->prepare("SELECT * from Aliment where (category = ? OR category = ?) AND HighCalories = 0  AND name NOT IN(".$_allergies.")" );
					$result->execute(array('snack','Fruit'));
			}


			$result = $result->fetchAll();
			$nb = rand(0,sizeof($result)-1);

			$snack = $result[$nb];

			$cal = produitEnCroix(100, $snack['calories_per_100g'], $snack['average_ration']);

			$quantity="";
			$quantity2="";


			if( $cal > ($cal_restriction + $incertitude) || $cal < ($cal_restriction - $incertitude) ){

				 $quantity = $cal_restriction/($snack['calories_per_100g']/100);

			}else if($cal >= ($cal_restriction - $incertitude) && $cal <= ($cal_restriction + $incertitude)){
				 $quantity = $cal/($snack['calories_per_100g']/100);
				 
			}

			array_push($aliments, new Aliment($snack['name'], $quantity, $snack['calories_per_100g'], 'no baking method',$snack['category'] ));

		break;

		default:
		 
		break;
	}

	return $aliments;

}






function produitEnCroix($val1, $val2, $val3){
	return ($val3*$val2)/$val1;
}



echo json_encode("ok");



?>