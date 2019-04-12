<?php

include 'bdd.php';

class DailyMenu implements JsonSerializable
{

     public $breakFast;
     public$snack1;
     public $lunch;
      public $snack2;
     public $diner;

    /**
     * DailyMenu constructor.
     * @param $breakFast
     * @param $snack1
     * @param $lunch
     * @param $snack2
     * @param $diner
     */
    public function __construct($breakFast, $snack1, $lunch, $snack2, $diner)
    {
        $this->breakFast = $breakFast;
        $this->snack1 = $snack1;
        $this->lunch = $lunch;
        $this->snack2 = $snack2;
        $this->diner = $diner;
    }

    /**
     * @return array
     */
    public function getBreakFast()
    {
        return $this->breakFast;
    }

    /**
     * @param array $breakFast
     */
    public function setBreakFast($breakFast)
    {
        $this->breakFast = $breakFast;
    }

    /**
     * @return array
     */
    public function getSnack1()
    {
        return $this->snack1;
    }

    /**
     * @param array $snack1
     */
    public function setSnack1($snack1)
    {
        $this->snack1 = $snack1;
    }

    /**
     * @return array
     */
    public function getLunch()
    {
        return $this->lunch;
    }

    /**
     * @param array $lunch
     */
    public function setLunch($lunch)
    {
        $this->lunch = $lunch;
    }

    /**
     * @return array
     */
    public function getSnack2()
    {
        return $this->snack2;
    }

    /**
     * @param array $snack2
     */
    public function setSnack2($snack2)
    {
        $this->snack2 = $snack2;
    }

    /**
     * @return array
     */
    public function getDiner()
    {
        return $this->diner;
    }

    /**
     * @param array $diner
     */
    public function setDiner($diner)
    {
        $this->diner = $diner;
    }

  function iterateVisible() {

     echo "MyClass::iterateVisible:\n";

     foreach ($this as $key => $value) {
         print " aggg $key => $value\n";
     }

  }


    public function jsonSerialize()
    {
        $data['breakFast'] = $this->breakFast;
        $data['snack1'] = $this->snack1;
        $data['lunch'] = $this->lunch;
        $data['snack2'] = $this->snack2;
        $data['diner'] = $this->diner;
        return $data;
    }

}


?>