
<?php 
/*
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

        exit(0);
    }*/

    ?>

<?php

include 'bdd.php';


//echo json_encode("success");
$firstname = htmlentities($_POST['firstname']) ;
$lastname = htmlentities($_POST['lastname']) ;
$currentWeight = htmlentities($_POST['currentWeight']) ;
$size = htmlentities($_POST['size']) ;
$age = htmlentities($_POST['age']) ;
$gender = htmlentities($_POST['gender']) ;
$birthday = htmlentities($_POST['birthday']) ;
$email = htmlentities($_POST['email']) ;
$password = htmlentities($_POST['password']);

$allergies = htmlentities($_POST['allergies']);

//$query = "INSERT INTO USER(name, surname, birthday, email, password, weight, age, size, sex)VALUES(?,?,?,?,?,?,?,?,?)";


 $rq = $co->prepare("INSERT INTO USER(firstname, lastname, birthday, email, password, weight, age, size, sex)VALUES(?,?,?,?,?,?,?,?,?)");
  $rq->execute(array($firstname, $lastname, $birthday, $email, $password, $currentWeight, $age, $size, $gender));



  $a_iduser = $co->query("SELECT id_user from USER where id_user = (SELECT MAX(id_user) from USER)");

  $a_iduser = $a_iduser->fetchAll();

  $iduser =  $a_iduser[0]["id_user"] ;


$allergies = explode(',', $allergies);

foreach ($allergies as $value) {
    # code...


    $aliment = $value;

     $a_idaliment = $co->prepare("SELECT id_aliment from Aliment WHERE name = ?");
     $a_idaliment->execute(array($aliment));
     

     $idaliment = $a_idaliment->fetchAll();
     $idaliment = $idaliment[0]["id_aliment"];


      $insertallergy = $co->prepare("INSERT INTO Allergyprone (id_aliment , id_user) VALUES(?, ?)");
      $insertallergy->execute(array($idaliment, $iduser));


}

echo json_encode($allergies[0]);

?>