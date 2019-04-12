<?php

include 'bdd.php';
//include("Aliment.php");

class Program implements JsonSerializable{

	protected $globalMenu;
	protected $AlimentList;

	function __construct($globalMenu){
			$this->globalMenu = $globalMenu;
			$this->AlimentList = array();
	}

    /**
     * @return array
     */
    public function getGlobalMenu()
    {
        return $this->globalMenu;
    }

    /**
     * @param array $globalMenu
     */
    public function setGlobalMenu($globalMenu)
    {
        $this->globalMenu = $globalMenu;
    }

    /**
     * @return array
     */
    public function getAlimentList()
    {
        return $this->AlimentList;
    }

    
    public function setAlimentList()
    {
        $allaliment = array();

        foreach ($this->globalMenu as $daily) {

            // echo "menu ".json_encode( $daily)."<br><br><br>";
            
            foreach ($daily as  $meal) {

                // echo "meal ".json_encode($meal)."<br><br><br>";

                foreach ($meal as $aliment) {

                    array_push($allaliment, $aliment);
                     

                }
                
            } 
        }

      //echo "aliment ". json_encode($allaliment)."<br><br>";


    
        

        foreach ($allaliment as $mainaliment) {

         $aliment = new Aliment($mainaliment->getName(), $mainaliment->getQuantity(), $mainaliment->getCalory(), $mainaliment->getBakingMethod(), $mainaliment->getCategory());
           
            $alreadyDone = $this->inList($aliment);
     
            if($alreadyDone != 1){

                 foreach ($allaliment as $secondaliment) {
                    if( $aliment->getName() === $secondaliment->getName() ){
                            //echo "second ".$secondaliment->getName()."<br>";
                         //echo "second quantity ".$aliment->getQuantity()." ".$secondaliment->getQuantity()."<br>";
                        $quantity = $aliment->getQuantity() + $secondaliment->getQuantity();
                        // echo "second ".$quantity."<br>";
                        $aliment->setQuantity($quantity);
                        //echo "second after ".$aliment->getQuantity()."<br>";

                    }
                 }

                 array_push($this->AlimentList, $aliment);
           }

             

        }

        //echo "aliments ". json_encode($this->AlimentList);

    }



    function inList($aliment){

        $bool = 0;

        foreach ($this->AlimentList as $value) {

            if( $value->getName() ===  $aliment->getName() ){
                $bool = 1;
            }
        }

        return $bool;
    }

    

    public function jsonSerialize()
    {
        $data['globalMenu'] = $this->globalMenu;
        $data['AlimentList'] = $this->AlimentList;
        return $data;
    }



}


?>