<?php

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{

    private $_headerMenu = array(
        'navbar-left' => array(
            'index' => array(
                'caption' => 'Главная',
                'action' => 'index'
            ),
            'transport' => array(
                'caption' => 'Перевозки',
                'action' => 'index'
            ),
            'about' => array(
                'caption' => 'О компании',
                'action' => 'index'
            ),
            'contact' => array(
                'caption' => 'Связаться',
                'action' => 'index'
            ),
        ),
        'navbar-right' => array(
            'session' => array(
                'caption' => 'Войти',
                'action' => 'index'
            ),
        )
    );

    private $_tabs = array(
        'Перевозки' => array(
            'controller' => 'transport',
            'action' => 'index',
            'any' => false,
            'class' => 'transfer'
        ),
        'Авто' => array(
            'controller' => 'car',
            'action' => 'index',
            'any' => true,
        ),
        'Диллеры' => array(
            'controller' => 'dealer',
            'action' => 'index',
            'any' => true
        ),
        'Водители' => array(
            'controller' => 'driver',
            'action' => 'index',
            'any' => true
        ),
        'Организации' => array(
            'controller' => 'organization',
            'action' => 'index',
            'any' => true
        ),
        'Владельцы' => array(
            'controller' => 'owner',
            'action' => 'index',
            'any' => true
        ),
        'Товары' => array(
            'controller' => 'product',
            'action' => 'index',
            'any' => true
        ),
        'Типы товаров' => array(
            'controller' => 'producttype',
            'action' => 'index',
            'any' => true
        ),
        'Грузы' => array(
            'controller' => 'shipment',
            'action' => 'index',
            'any' => true
        ),
        'Склады' => array(
            'controller' => 'store',
            'action' => 'index',
            'any' => true
        ),
        '| Профиль' => array(
            'controller' => 'transport',
            'action' => 'profile',
            'any' => false
        )
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {
        // Получение переменной сессии
        $auth = $this->session->get('auth');
        
        if ($auth) {
            
            // Если авторизован, показывать кнопку 'Выйти'
            $this->_headerMenu['navbar-right']['session'] = array(
                'caption' => 'Выйти',
                'action' => 'end'
            );
        } else {
            // Если не авторизован, убрать кнопку 'Перевозки'
            unset($this->_headerMenu['navbar-left']['transport']);
        }
        
        // Имя контроллера
        $controllerName = $this->view->getControllerName();
        
        foreach ($this->_headerMenu as $position => $menu) {
            echo '<div class="nav-collapse">';
            echo '<ul class="nav navbar-nav ', $position, '">';
            foreach ($menu as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($controller . '/' . $option['action'], $option['caption']);
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }

    }

    /**
     * Returns menu tabs
     */
    public function getTabs()
    {
        $controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        
        echo '<ul class="nav nav-tabs">';
        foreach ($this->_tabs as $caption => $option) {
            if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            if ($option['class']) {
                echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption . ' <span class="glyphicon glyphicon-' . $option['class'] . '">');
            } else {
                echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}
