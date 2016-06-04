<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        // Заголовок вкладки
        $this->tag->setTitle('Главная страница');
        
        // Инициализация у родителя
        parent::initialize();
    }

    public function indexAction()
    {

    }
}
