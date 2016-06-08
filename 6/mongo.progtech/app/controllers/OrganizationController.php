<?php

use Phalcon\Flash;
use Phalcon\Session;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class OrganizationController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Организации');
        parent::initialize();
    }

    public function indexAction($numberPage = 1)
    {
        $organizations = Organization::find(array(array("del" => 0)));
        
        $paginator = new Paginator(array(
            "data"  => $organizations,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $organization = Organization::findFirst(array(array("id" => (int)$id)));
            if (!$organization) {
                $this->flash->error("Организация не найдена");
                return $this->forward("organization/index");
            }

            $this->view->form = new OrganizationForm($organization, array('edit' => true));
        }
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("organization/index");
        }

        $id = $this->request->getPost("id");
        $organization = Organization::findById($id);
        
        if (!$organization) {
            $this->flash->error("Организация не найдена");
            return $this->forward("organization/index");
        }

        $form = new OrganizationForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $organization)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('organization/new');
        }

        if ($organization->save() == false) {
            foreach ($organization->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('organization/new');
        }

        $form->clear();

        $this->flash->success("Организация успешно изменёна");
        return $this->forward("organization/index");
    }
    
    public function newAction()
    {
        $this->view->form = new OrganizationForm(null, array('edit' => true, 'create' => true));
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("organization/index");
        }

        $form = new OrganizationForm;
        $organization = new Organization();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $organization)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('organization/new');
        }
        
        $count = count(Organization::find());
        $organization->id = $count + 1;
        $organization->del = 0;

        if ($organization->save() == false) {
            foreach ($organization->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('organization/new');
        }

        $form->clear();

        $this->flash->success("Организация успешно создана");
        return $this->forward("organization/index");
    }
    
    public function deleteAction($id)
    {
        $organization = Organization::findFirst(array(array("id" => (int)$id)));
        
        if (!$organization) {
            $this->flash->error("Организация не найдена");
            return $this->forward("organization/index");
        }
        
        $organization->del = 1;

        if ($organization->save() == false) {
            foreach ($organization->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('organization/new');
        }

        $this->flash->success("Организация успешно удалёна");
        return $this->forward("organization/index");
    }
}
