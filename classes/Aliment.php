<?php
include 'bdd.php';


class Aliment implements JsonSerializable
{

	protected $name;
    protected $quantity;
    protected $calory;
    protected $baking_method;
    protected $category;

    /**
     * Aliment constructor.
     * @param $name
     * @param $quantity
     * @param $calory
     * @param $baking_method
     * @param $category
     */
    public function __construct($name, $quantity, $calory, $baking_method, $category)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->calory = $calory;
        $this->baking_method = $baking_method;
        $this->category = $category;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getCalory()
    {
        return $this->calory;
    }

    /**
     * @param mixed $calory
     */
    public function setCalory($calory)
    {
        $this->calory = $calory;
    }

    /**
     * @return mixed
     */
    public function getBakingMethod()
    {
        return $this->baking_method;
    }

    /**
     * @param mixed $baking_method
     */
    public function setBakingMethod($baking_method)
    {
        $this->baking_method = $baking_method;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function jsonSerialize()
    {
        $data['name'] = $this->name;
        $data['quantity'] = $this->quantity;
        $data['calory'] = $this->calory;
        $data['baking_method'] = $this->baking_method;
        $data['category'] = $this->category;
        return $data;
    }

}


?>