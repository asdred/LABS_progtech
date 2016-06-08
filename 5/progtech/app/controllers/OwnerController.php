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
}
