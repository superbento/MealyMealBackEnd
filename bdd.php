<?php


 if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);C:\Users\Administrator\Downloads\MealyMealBackEnd;
    }

    

  $co ="";
    
    try
{
       //$co = new PDO('mysql:host=localhost;dbname=skopun_', 'Noah_hazoume', 'Bordeaux25' );

    $co = new PDO('mysql:host=localhost; dbname=projet_efrei_mealymeal', 'root', '');


}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}




/*
$mail = $_POST['Email'];
$fname = $_POST['Prenom'];
$lname = $_POST['Nom'];
$mail2 = $_POST['Email2'];
$mdp = $_POST['Password'];
$sex= '';
$filepath= "";


$rqent = "SELECT * FROM app_user WHERE email = '$mail' ";
$rq = $co->query($rqent);






if ($rq->rowCount() == 0){


   $rqt = "INSERT INTO `app_user` (first_name, last_name, email, email_bis, password_ ) VALUES ('$fname', '$lname', '$mail', '$mail2', '$mdp') ";

   $co->query($rqt);

   echo "CESURE"."valide : ".$rqt." CESURE";

     } else {

       echo "nonvalide"."CESURE";

     }*/


?>