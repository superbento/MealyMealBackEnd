<?php

include 'bdd.php';


/*abstract class Model {

    public function jsonSerialize() {
        $getter_names = get_class_methods(get_class($this));
        $gettable_attributes = array();
        foreach ($getter_names as $key => $value) {
            if(substr($value, 0, 4) === 'get_') {
                $gettable_attributes[substr($value, 4, strlen($value))] = $this->$value();
            }
        }
        return $gettable_attributes;
    }

}
*/

class User implements JsonSerializable
{


    protected $id;
    protected $firstname;
    protected $lastname;
    protected $weight;
    protected $size;
    protected $age;
    protected $gender;
    protected $email;
    protected $birthday;
    protected $module;
    protected $allergies;


    public function __construct($id, $firstname, $lastname, $weight, $size, $age, $gender, $email, $birthday)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        $this->weight = $weight;
        $this->size = $size;
        $this->age = $age;
        $this->gender = $gender;

        $this->email = $email;
        $this->birthday = $birthday;

        $this->allergies = array();
    }


    function getId()
    {
        return $this->id;
    }

    function getFirstName()
    {
        return $this->firstname;
    }

    function getLastName()
    {
        return $this->lastname;
    }

    function getEmail()
    {
        return $this->email;
    }


    function getGender()
    {
        return $this->gender;
    }



    function setModule($module)
    {
       $this->module = $module;
    }

    function addAllergy($allergy)
    {
       array_push($this->allergies, $allergy);
    }


    public function jsonSerialize()
    {
        $data['id'] = $this->id;
        $data['firstname'] = $this->firstname;
        $data['lastname'] = $this->lastname;
        $data['weight'] = $this->weight;
        $data['size'] = $this->size;
        $data['age'] = $this->age;
        $data['gender'] = $this->gender;
        $data['email'] = $this->email;
        $data['birthday'] = $this->birthday;
        $data['module'] = $this->module;
        $data['allergies'] = $this->allergies;

        return $data;
    }


}


?>