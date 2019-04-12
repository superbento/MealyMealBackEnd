<?php
include 'bdd.php';



$allergies = ["eggplant", "pork"];


/*$al = "'".implode(' \',\' ' , $allergies)."'" ;
echo $al."<br>"; 

$x = "'".$allergies[0]."',";*/


$_allergies = "";

$a_allergy = $allergies;
    	$k = 0;
    	foreach ($a_allergy as $value) {

    		//array_push($allergies, $value["name"]);

    		if($k === 0){
    			$_allergies .=  "'".$value."'";
	    	}else{
	    		$_allergies .=  ",'".$value."'";
	    	}
	    	$k++;
    	}

echo $_allergies;


$q = "SELECT * from Aliment where category = 'Vegetable' AND name NOT IN ($_allergies)";
$query = $co->query($q );

echo $q;

/*$iduser = 18;

 $allergies = array();
    $a_allergy = $co->prepare("SELECT Aliment.name as name from allergyprone natural join Aliment where allergyprone.id_user = ? ");
    $a_allergy->execute(array($iduser));

    if($a_allergy->rowCount() != 0){

    	$a_allergy = $a_allergy->fetchAll();

    	foreach ($a_allergy as $value) {

    		array_push($allergies, $value["name"]);

    	}

    }


    var_dump($allergies);*/



?>