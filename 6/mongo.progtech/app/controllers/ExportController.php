<?php ini_set('memory_limit', '-1');

use Phalcon\Flash;
use Phalcon\Session;

class ExportController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Владельцы');
        parent::initialize();
    }

    public function indexAction($collection = null, $offset = 0, $limit = 100000)
    {   
        $options = array(
            array(
                "del"   => 0
            ),
            "skip"  => $offset,
            "limit"  => $limit
        );
        
        if ($collection == "car") {
            $objects = Car::find($options);
            $data = array(array('Номер','Диллер','Водитель','Владелец','Модель','Грузоподъёмность'));
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    Dealer::findFirst(array(array("id" => (int)$obj->dealer_id)))->name,
                    Driver::findFirst(array(array("id" => (int)$obj->driver_id)))->name,
                    Owner::findFirst(array(array("id" => (int)$obj->owner_id)))->name,
                    $obj->model,
                    $obj->capacity
                ));
            }
        } elseif ($collection == "dealer") {
            $objects = Dealer::find($options);
            $data = array(array('Номер','И.Фамилия'));
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name
                ));
            }
        } elseif ($collection == "driver") {
            $objects = Driver::find($options);
            $data = array(array('Номер','И.Фамилия','Стаж','Зарплата'));
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name, 
                    $obj->experience, 
                    $obj->salary
                ));
            }
        } elseif ($collection == "organization") {
            $objects = Organization::find($options);
            $data = array(array('Номер','Название','Адрес')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name, 
                    $obj->address
                ));
            }
        } elseif ($collection == "owner") {
            $objects = Owner::find($options);
            $data = array(array('Номер','И.Фамилия')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name
                ));
            }
        } elseif ($collection == "product") {
            $objects = Product::find($options);
            $data = array(array('Номер','Название','Вес','Тип')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name, 
                    $obj->weight,
                    ProductType::findFirst(array(array("id" => (int)$obj->type_id)))->name
                ));
            }
        } elseif ($collection == "producttype") {
            $objects = ProductType::find($options);
            $data = array(array('Номер','Название')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name
                ));
            }
        } elseif ($collection == "shipment") {
            $objects = Shipment::find($options);
            $data = array(array('Номер','Товар','Номер перевозки', 'Количество')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    Product::findFirst(array(array("id" => (int)$obj->product_id)))->name,
                    Transportation::findFirst(array(array("id" => (int)$obj->transportation_id)))->id,
                    $obj->amount
                ));
            }
        } elseif ($collection == "store") {
            $objects = Store::find($options);
            $data = array(array('Номер','Название','Владелец')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    $obj->name,
                    Owner::findFirst(array(array("id" => (int)$obj->owner_id)))->name
                ));
            }
        } elseif ($collection == "transport") {
            $objects = Transportation::find($options);
            $data = array(array('Номер','Авто','Организация','Склад','Дата')); 
            foreach($objects as $obj) {
                array_push($data, array(
                    $obj->id, 
                    Car::findFirst(array(array("id" => (int)$obj->car_id)))->model,
                    Organization::findFirst(array(array("id" => (int)$obj->organization_id)))->name,
                    Store::findFirst(array(array("id" => (int)$obj->store_id)))->name,
                    $obj->date
                ));
            }
        }
        
        // file name to output
        $fname = date("Ymd_his") . ".xlsx";

        // temp file name to save before output
        $temp_file = tempnam(sys_get_temp_dir(), 'phpexcel');
        
        $writer = $this->xlsxWriter;
        $writer->writeSheet($data,'sheet1'); // write your data into excel sheet
        $writer->writeToFile($temp_file); // Name the file you want to save as
        
        $response = new \Phalcon\Http\Response();
        
        // Redirect output to a client’s web browser (Excel2007)
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="' . $fname . '"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // If you're serving to IE 9, then the following may be needed
        $response->setHeader('Cache-Control', 'max-age=1');

        //Set the content of the response
        $response->setContent(file_get_contents($temp_file));

        // delete temp file
        unlink($temp_file);

        //Return the response
        return $response;
    }
}