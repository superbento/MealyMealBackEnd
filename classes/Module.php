<?php


class Module implements JsonSerializable
{

	protected $id;
    protected $name;
    protected $startDate;
    protected $activityFactor;
    protected $endDate;
    protected $program;

    public function __construct( $id, $name, $startDate, $endDate, $activityFactor){
			$this->id =$id;
			$this->name = $name;
			$this->startDate = $startDate;
			$this->endDate = $endDate;
			$this->activityFactor = $activityFactor;
			//$this->program = $program;
	}

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getActivityFactor()
    {
        return $this->activityFactor;
    }

    /**
     * @param mixed $activityFactor
     */
    public function setActivityFactor($activityFactor)
    {
        $this->activityFactor = $activityFactor;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param mixed $program
     */
    public function setProgram($program)
    {
        $this->program = $program;
    }


    public function jsonSerialize()
    {
        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['startDate'] = $this->startDate;
        $data['endDate'] = $this->endDate;
        $data['activityFactor'] = $this->activityFactor;
        $data['program'] = $this->program;
        return $data;
    }


}


?>