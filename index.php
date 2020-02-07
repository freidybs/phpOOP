<?php
class workerDay{
    public $currentDate;
    public $enterTime;
    public $exitTime;

    function workerDay($currentDate,$enterTime,$exitTime)
    {
        $this->currentDate=$currentDate;
        $this->enterTime=$enterTime;
        $this->exitTime=$exitTime;
    }
}
abstract class Employee{
    private $name;
    public  function getName(){
        return $this->name;
    }
    public  function setName($name){
        $this->name = $name;
    }

    private $phone;
    public  function getPhone(){
        return $this->phone;
    }
    public  function setPhone($phone){
        $this->phone = $phone;
    }

    private $numberEmployee;
    public  function getNumberEmployee(){
        return $this->numberEmployee;
    }
    public  function setNumberEmployee($numberEmployee){
        $this->numberEmployee = $numberEmployee;
    }

    private $address;
    public  function getAddress(){
        return $this->address;
    }
    public  function setAddress($address){
        $this->address = $address;
    }
    public $fromDate;
    static $incomeTax=0.1;
    static $nationalInsuranceC=0.035;
    function Employee($name,$phone,$numberEmployee,$address){
        $this->name=$name;
        $this->phone=$phone;
        $this->numberEmployee=$numberEmployee;
        $this->address=$address;
    }
    public $reportHours=array();
    public  function applyReport($typeOfReport)
    {
        if($typeOfReport=="enter")
        {
            $currentReport=new workerDay();
            $currentReport->currentDate=date("Y,m,d");
            $currentReport->enterTime=date('H:i');
            array_push($reportHours,$currentReport);

        }
        else{
            foreach($this->reportHours as $report) {
                if ($report->currentDate==date("Y,m,d")) {
                    $report->exitTime=date('H:i');
                }
            }

        }
    }

    public function EmployeeDetails()
    {
        echo "name",$this->name,"<br/>",
        "phone",$this->phone,"<br/>",
        "id",$this->numberEmployee,"<br/>",
        "address",$this->address,"<br/>";
    }

    public function Seniority($date1,$date2)
    {
        $delta = strtotime($date2) - strtotime($date1);
        return round($delta/(60*60*24)/31);
    }

    abstract protected function salaryBrt();

    public function hoursInMonth()
    {
        $sum=0;
        foreach ($this->reportHours as $hours){
            $time_diff=(strtotime($hours->exitTime)-strtotime($hours->enterTime))/3600;

            $sum+=$time_diff;
        }
        return $sum;
    }
    function neto()
    {
        return $this->salaryBrt()-($this->insurance())-($this->incomeTax());
    }

    function insurance()
    {
        return self::$nationalInsuranceC * ($this->salaryBrt());
    }

    function incomeTax()
    {
        return self::$incomeTax * ($this->salaryBrt());
    }

}
class Programmer extends Employee
{
    public $salary;
    function Programmer($name,$phone,$numberEmployee,$address)
    {
        echo "I am Programmer";
        parent::Employee($name,$phone,$numberEmployee,$address);

    }
    function salaryBrt()
    {
        return $this->salary;
    }
}
class QA extends Employee
{
    private $perHour;
    function QA($name,$phone,$numberEmployee,$address)
    {
        echo "I am QA";
        parent::Employee($name,$phone,$numberEmployee,$address);

    }
    function salaryBrt()
    {
        return $this->perHour*($this->hoursInMonth());
    }

}

class ProductManager extends Employee
{
    private $profitFromProduct;
    private $salary;
    function ProductManager($name,$phone,$numberEmployee,$address)
    {
        echo "I am ProductManager";
        parent::Employee($name,$phone,$numberEmployee,$address);

    }
    public function salaryBrt()
    {
        return $this->salary+0.03*($this->profitFromProduct);
    }
}

$programmer=new Programmer("israel israeli","0556677889","222333444","lando5");
$programmer->EmployeeDetails();
echo get_class($programmer);
$date1="10-10-2010";
$date2="10-11-2010";
echo $programmer->Seniority($date1,$date2);
echo "  ";
$hours=new workerDay("10-10-2010","10:10","19:10");
echo $hours->currentDate;
echo "   ";
array_push($programmer->reportHours,$hours);
echo $programmer->reportHours[0]->currentDate;
echo "   ";
echo $programmer->hoursInMonth();
$programmer->salary=7000;
echo $programmer->salaryBrt();
echo "   ";
echo $programmer->neto();
$productmanager=new ProductManager("sara","0544544545","123456789","yaffo88");

$qa=new QA("shira shiran","0567894321","123456432","bialik43");
?>


