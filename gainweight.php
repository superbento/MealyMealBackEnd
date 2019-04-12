<?php

include 'bdd.php';
//include("classes/Module.php");
include("classes/Aliment.php");
include("classes/Program.php");
include("classes/DailyMenu.php");





/*$calorienum = 2400;

	$days = 20;

	$breakfastNeeded = 2400/4;
	$lunchNeeded = 2400/4;
	$dinerNeeded = 2400/4;
	$snackNeeded = 2400/8;

       echo "breakfast";
		$a_brf = findAliment('breakfast',$breakfastNeeded);

		echo "snack 1";

		$a_snack1 = findAliment('snack',$snackNeeded);

		echo "lunch";

		$a_lunch = findAliment('dish',$lunchNeeded);

		echo "snack 2";

		$a_snack2 = findAliment('snack',$snackNeeded);

		echo "diner";*/


$o_program = createMenu();

$o_program;

  for($i=0; $i< sizeof($o_program->getGlobalMenu()); $i++){

  	//var_dump($o_program->getGlobalMenu()[$i]);
  		$Daily = $o_program->getGlobalMenu()[$i];
  	    
  	   echo "<br><br><br><br><Strong style='font-size:5vw; color:green'> Jour ".($i+1)."</Strong><br><br><br><br>";

  	   echo "<br> <strong>breakfast</strong> <br>";
		// var_dump($Daily->getBreakFast());
		 foreach ($Daily->getBreakFast() as  $value) {
		 	echo $value->getName()."<br>";
		 	echo "quantity ".$value->getQuantity() . "g";
		 	echo"<br><br>";
		 }

		echo "<br> <strong> snack 1 </strong> <br>";

		  //var_dump($Daily->getSnack1());
		  foreach ($Daily->getSnack1() as  $value) {
		 	echo $value->getName()."<br>";
		 	echo "quantity ".$value->getQuantity() . "g";
		 	echo"<br><br>";
		 }

		echo "<br> <strong> lunch </strong> <br>";

		 //var_dump($Daily->getLunch());
		   foreach ($Daily->getLunch() as  $value) {
		 	  echo $value->getName()."<br>";
		 	 echo "quantity ".$value->getQuantity() . "g";
		 	 echo"<br><br>";
		 }


		echo "<br> <strong> snack 2 </strong> <br>";

		  //var_dump($Daily->getSnack2());
		   foreach ($Daily->getSnack2() as  $value) {
		 	  echo $value->getName()."<br>" ;
		 	echo "quantity ".$value->getQuantity() . "g";

		 	echo"<br><br>";
		 }

		echo "<br><strong> diner </strong><br>";

		  //var_dump($Daily->getDiner());

		  foreach ($Daily->getDiner() as  $value) {
		 	  echo $value->getName()."<br>";
		 	 echo "quantity ".$value->getQuantity() . "g";
		 	 echo"<br><br>";
		 }


  	  

  }


function createMenu(){

	$calorienum = 2400;

	$days = 20;

	$breakfastNeeded = 2400/4;
	$lunchNeeded = 2400/4;
	$dinerNeeded = 2400/4;
	$snackNeeded = 2400/8;

$a_NutritionProgram = array();

	for($i=0;$i<$days; $i++){

		//echo "breakfast";

		$a_brf = findAliment('breakfast',$breakfastNeeded);

		//echo "snack 1";

		$a_snack1 = findAliment('snack',$snackNeeded);

		//echo "lunch";

		$a_lunch = findAliment('dish',$lunchNeeded);

		//echo "snack 2";

		$a_snack2 = findAliment('snack',$snackNeeded);

		//echo "diner";

		$a_diner = findAliment('dish',$dinerNeeded);

		$daily = new DailyMenu($a_brf, $a_snack1, $a_lunch, $a_snack2, $a_diner);

		array_push($a_NutritionProgram, $daily);
	}

	return new Program($a_NutritionProgram);

}


function findAliment($mealName, $cal_restriction){
    GLOBAL $co;
	$incertitude = $cal_restriction * 0.10;
    $aliments = array();

	switch ($mealName){
		case 'breakfast':

			$result = $co->prepare("SELECT * from Aliment where category = ? ");
			$result->execute(array('breakfast'));

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

		    $res = $co->prepare("SELECT * from Aliment where category =? OR category =?");
			$res->execute(array('Meat', 'Fish'));

			$res = $res->fetchAll();
			$nb = rand(0,sizeof($res)-1);

			$meat = $res[$nb];
			$meatCal = produitEnCroix(100, $meat['calories_per_100g'], $meat['average_ration']);




			$res = $co->prepare("SELECT * from Aliment where category = ? ");
			$res->execute(array('SideDish'));

			$res = $res->fetchAll();
			$nb = rand(0,sizeof($res)-1);

			$sidedish = $res[$nb];
			$sidedishCal = produitEnCroix(100, $sidedish['calories_per_100g'], $sidedish['average_ration']);



			$res = $co->prepare("SELECT * from Aliment where category = ? ");
			$res->execute(array('Vegetable'));

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
			
			$result = $co->prepare("SELECT * from Aliment where category = ? OR category = ? ");
			$result->execute(array('snack','Fruit'));

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
		 echo "default";
		break;
	}

	return $aliments;

}

function produitEnCroix($val1, $val2, $val3){
	return ($val3*$val2)/$val1;
}

?>