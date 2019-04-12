
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


echo json_encode("success");

$firstname = htmlentities($_POST['firstname']) ;
$lastname = htmlentities($_POST['lastname']) ;
$currentWeight = htmlentities($_POST['currentWeight']) ;
$size = htmlentities($_POST['size']) ;
$age = htmlentities($_POST['age']) ;
$gender = htmlentities($_POST['gender']) ;
$birthday = htmlentities($_POST['birthday']) ;
$email = htmlentities($_POST['email']) ;
$password = htmlentities($_POST['password']);

//$query = "INSERT INTO USER(name, surname, birthday, email, password, weight, age, size, sex)VALUES(?,?,?,?,?,?,?,?,?)";
try{

 $rq = $co->prepare("UPDATE USER SET  firstname=?, lastname=?, age=?,sex=?,birthday=?, password = ?, size = ?,weight=? WHERE email = ?");
  $rq->execute(array( $firstname, $lastname, $age, $gender, $birthday, $password, $size, $currentWeight,$email));

  echo json_encode("success");

} catch(Exception $e){

    echo json_encode($e);

}

?>