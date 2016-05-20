<?php ini_set('memory_limit', '-1');

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OwnerController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Владельцы');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $owners = Owner::find();
        
        $paginator = new Paginator(array(
            "data"  => $owners,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $owner = Owner::findFirstById($id);
            if (!$owner) {
                $this->flash->error("Владелец не найден");
                return $this->forward("owner/index");
            }

            $this->view->form = new OwnerForm($owner, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("owner/index");
        }

        $id = $this->request->getPost("id", "int");
        $owner = Owner::findFirstById($id);
        
        if (!$owner) {
            $this->flash->error("Владелец не найден");
            return $this->forward("owner/index");
        }

        $form = new OwnerForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $owner)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('owner/new');
        }
        

        if ($owner->save() == false) {
            foreach ($owner->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('owner/new');
        }

        $form->clear();

        $this->flash->success("Владелец успешно изменён");
        return $this->forward("owner/index");
    }
    
    public function newAction()
    {
        $this->view->form = new OwnerForm(null, array('edit' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("owner/index");
        }

        $form = new OwnerForm;
        $owner = new Owner();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $owner)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('owner/new');
        }

        if ($owner->save() == false) {
            foreach ($owner->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('owner/new');
        }

        $form->clear();

        $this->flash->success("Владелец успешно создан");
        return $this->forward("owner/index");
    }
    
    public function deleteAction($id)
    {
        $owner = Owner::findFirstById($id);
        
        if (!$owner) {
            $this->flash->error("Владелец не найден");
            return $this->forward("owner/index");
        }
        
        $owner->del = 1;

        if ($owner->save() == false) {
            foreach ($owner->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('owner/new');
        }

        $this->flash->success("Владелец успешно удалён");
        return $this->forward("owner/index");
    }
    
    public function exportAction($offset = 0, $limit = 100000)
    {   
        $owners = Owner::find(array(
            "del = 0",
            "offset" => $offset,
            "limit"  => $limit
        ));
        
        $data = array(
            array('Номер','И.Фамилия'),
        );
        
        foreach($owners as $owner) {
            array_push($data, array($owner->id, $owner->name));
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
        
        /*
        if ($offset == 0) {
            $owners_count = count(Owner::find(array("del = 0")));
        }

        $owners = Owner::find(array(
            "del = 0",
            "offset" => $offset,
            "limit"  => $limit
        ));
        
        if ($offset == 0 && $owners_count <= 25000) {
            
            $phpExcel = $this->phpExcel;
        
            $page = $phpExcel->setActiveSheetIndex(0);
            
            $page->setCellValue("A1", "Номер");
            $page->setCellValue("B1", "И.Фамилия");

            $i = 0;
            foreach($owners as $owner) {
                $page->setCellValue("A" . ($i + 2), $owner->id);
                $page->setCellValue("B" . ($i + 2), $owner->name);
                $i++;
            }

            $page->setTitle("Владельцы");

            // file name to output
            $fname = date("Ymd_his") . ".xlsx";

            // temp file name to save before output
            $temp_file = tempnam(sys_get_temp_dir(), 'phpexcel');

            $objWriter = new PHPExcel_Writer_Excel2007($phpExcel);
            $objWriter->save($temp_file);

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
        } else {
            $parts = $owners_count / 25000;
            return $this->forward("owner/exports/" . round($parts, 0, PHP_ROUND_HALF_UP));
        } */
    }
    
    public function exportsAction($parts = 0)
    {
        $this->view->parts = $parts;
    }
    
    public function testAction($count = 0)
    {
        for($i = 0; $i < $count; $i++ ) {
            
            $owner = new Owner();
    
            $owner->name = $this->generateString();
            
            $owner->save();
        }
        
        echo "Добавлено";
    }
    
    private function generateString(){
        $chars = 'абвгдеёжзиклмнопрстуфхцчшщыэюя';
        $string = '';
        for ($i = 0; $i < rand(3, 8); $i++) {
            $string .= mb_substr($chars, rand(0, 29), 1, "UTF-8");
        }
        return $string;
    }
}
