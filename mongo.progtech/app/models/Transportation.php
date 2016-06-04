<?php

use Phalcon\Mvc\Collection;

class Transportation extends Collection
{
    public $_id;
    
    public $id;

    public $car_id;

    public $organization_id;

    public $store_id;

    public $date;
     
    public $del;
    
    // Название таблицы
    public function getSource()
    {
        return "transportation";
    }
    
    public function lastDay()        
    {   
        $cd = date("d") - 1;
        if ($cd < 10) $cd = "0" . $cd;
        
        $cm = date("m");
        if ($cm < 10) $cm = "0" . $cm;
        
        $cy = date("Y");
        
        return Transportation::find([[ 'date' => [ '$regex' => $cy . '-' . $cm . '-' . $cd ] ]]);
    }
    
    public function lastMonth()        
    {   
        $cm = date("m") - 1;
        if ($cm < 10) $cm = "0" . $cm;
        
        $cy = date("Y");

        return Transportation::find([[ 'date' => [ '$regex' =>  $cy . '-' . $cm . '-.*' ] ]]);
    }
    
    public function lastYear()        
    {   
        $cy = date("Y") - 1;
        
        return Transportation::find([[ 'date' => [ '$regex' => $cy . '-.*' ] ]]);
    }

}
