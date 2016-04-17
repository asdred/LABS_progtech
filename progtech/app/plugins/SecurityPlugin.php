<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{
	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{
		if (!isset($this->persistent->acl)) {

            // Создаём ACL
			$acl = new AclList();

            // Действием по умолчанию будет запрет
			$acl->setDefaultAction(Acl::DENY);

			// Регистрируем две роли. Users - это зарегистрированные пользователи,
            // а Guests - неидентифицированные посетители.
			$roles = array(
				'users'  => new Role('Users'),
				'guests' => new Role('Guests')
			);
			foreach ($roles as $role) {
				$acl->addRole($role);
			}

			// Приватные ресурсы (бэкенд)
			$privateResources = array(
				'table'     => array('index')
			);
			foreach ($privateResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			// Публичные ресурсы (фронтенд)
			$publicResources = array(
				'index'      => array('index'),
				'session'    => array('index', 'start', 'end'),
			);
			foreach ($publicResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			// Предоставляем пользователям и гостям доступ к публичным ресурсам
			foreach ($roles as $role) {
				foreach ($publicResources as $resource => $actions) {
					foreach ($actions as $action){
						$acl->allow($role->getName(), $resource, $action);
					}
				}
			}

			// Доступ к приватным ресурсам предоставляем только пользователям
			foreach ($privateResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Users', $resource, $action);
				}
			}

			// The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
	}

    // Вызывается при каждом переходе в приложении
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
        // Проверяем, установлена ли в сессии переменная "auth" для определения активной роли.
		$auth = $this->session->get('auth');
		if (!$auth){
			$role = 'Guests';
		} else {
			$role = 'Users';
		}

        // Получаем активный контроллер/действие от диспетчера
		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();

        // Получаем список ACL
		$acl = $this->getAcl();

		if (!$acl->isResource($controller)) {
			$dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show404'
			]);

			return false;
		}

        // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
		$allowed = $acl->isAllowed($role, $controller, $action);
        
        // Если доступа нет, перенаправляем его на контроллер "index".
		if ($allowed != Acl::ALLOW) {
			$dispatcher->forward(array(
				'controller' => 'session',
				'action'     => 'index'
			));
            
            // Возвращая "false" мы приказываем диспетчеру прервать текущую операцию
            $this->session->destroy();
			return false;
		}
	}
}
