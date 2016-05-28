<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class TransportController extends ControllerBase
{
    private $cascade = false;
    
    public function initialize()
    {
        $this->tag->setTitle('Управление перевозками');
        parent::initialize();
    }

    public function indexAction($numberPage = 1, $interval = null)
    {
        $interval = $this->request->getPost("interval");
        
        if (!$interval) {
            $transports = Transportation::find(array(array("del" => 0)));
        } elseif ($interval == "year") {
            $transports = Transportation::lastYear();
            $this->view->status = "за последний год";
        } elseif ($interval == "month") {
            $transports = Transportation::lastMonth();
            $this->view->status = "за последний месяц";
        } elseif ($interval == "day") {
            $transports = Transportation::lastDay();
            $this->view->status = "за последний день";
        }
        
        foreach($transports as $transport) {
            if (Car::findFirst(array(array("id" => (int)$transport->car_id)))->del == 1 or Organization::findFirst(array(array("id" => (int)$transport->organization_id)))->del == 1 or Store::findFirst(array(array("id" => (int)$transport->store_id)))->del == 1) {
                $transport->del = 1;
                $transport->save();
            }
        }
        
        $paginator = new Paginator(array(
            "data"  => $transports,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $transport = Transportation::findFirst(array(array("id" => (int)$id)));
            if (!$transport) {
                $this->flash->error("Перевозка не найдена");
                return $this->forward("transport/index");
            }

            $this->view->form = new TransportForm($transport, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("transport/index");
        }

        $id = $this->request->getPost("id");
        $transport = Transportation::findById($id);
        
        if (!$transport) {
            $this->flash->error("Перевозка не найдена");
            return $this->forward("transport/index");
        }

        $form = new TransportForm;
        
        $data = $this->request->getPost();
        if (!$form->isValid($data, $transport)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('transport/new');
        }

        if ($transport->save() == false) {
            foreach ($transport->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('transport/new');
        }

        $form->clear();

        $this->flash->success("Перевозка успешно изменёна");
        return $this->forward("transport/index");
    }
    
    public function newAction()
    {
        $this->view->form = new TransportForm(null, array('edit' => true, 'create' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("transport/index");
        }
        
        $form = new TransportForm;
        $transport = new Transportation();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $transport)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('transport/new');
        }

        $count = count(Transportation::find());
        $transport->id = $count + 1;
        $transport->del = 0;
        
        if ($transport->save() == false) {
            foreach ($transport->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('transport/new');
        }

        $form->clear();

        $this->flash->success("Перевозка успешно создана");
        return $this->forward("transport/index");
    }
    
    
    public function deleteAction($id)
    {
        $transport = Transportation::findFirst(array(array("id" => (int)$id)));
        
        if (!$transport) {
            $this->flash->error("Перевозка не найден");
            return $this->forward("transport/index");
        }
        
        $transport->del = 1;

        if ($transport->save() == false) {
            foreach ($transport->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('transport/new');
        }

        $cascade = true;
        $this->flash->success("Перевозка успешно удалён");
        return $this->forward("transport/index");
    }

    /**
     * Edit the active user profile
     *
     */
    public function profileAction()
    {
        //Get session info
        $auth = $this->session->get('auth');

        //Query the active user
        $user = Users::findFirst(array(array("id" => $auth['id'])));
        if ($user == false) {
            return $this->forward('index/index');
        }

        if (!$this->request->isPost()) {
            $this->tag->setDefault('name', $user->username);
            $this->tag->setDefault('email', $user->email);
        } else {

            $name = $this->request->getPost('name', array('string', 'striptags'));
            $email = $this->request->getPost('email', 'email');

            $user->name = $name;
            $user->email = $email;
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $this->flash->success('Your profile information was updated successfully');
            }
        }
    }
}
