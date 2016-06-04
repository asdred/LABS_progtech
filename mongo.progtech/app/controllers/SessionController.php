<?php

/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Вход');
        parent::initialize();
    }

    public function indexAction()
    {
        // Значения по умолчанию
        if (!$this->request->isPost()) {
            $this->tag->setDefault('email', 'smvber@gmail.com');
            $this->tag->setDefault('password', '12345678');
        }
    }

    // Регистрация в сессии
    private function _registerSession(Users $user)
    {
        $this->session->set('auth', array(
            'id' => $user->id,
            'name' => $user->name
        ));
    }

    // Аутентификация
    public function startAction()
    {
        if ($this->request->isPost()) {

            // Получение данных из формы
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Поиск пользователя по базе
            $user = Users::findFirst(array(
                "conditions" => array(
                    "email" => $email,
                    "password" => sha1($password)
                )
            ));
            
            /*
            $user = Users::findFirst(array(
                "(email = :email: OR username = :email:) AND password = :password:",
                'bind' => array(
                    'email' => $email, 
                    'password' => sha1($password)
                )
            ));
            */
            
            // Пользователь найден
            
            if ($user == true) {
                
                // Регистрация в сессии
                $this->_registerSession($user);
                
                // Вывод сообщения об успехе
                $this->flash->success('Добро пожаловать ' . $user->username);
                
                // Продвижение в transport/index
                return $this->forward('transport/index');
            }

            // Вывод сообщения об ошибке
            $this->flash->error('Неверные email\пароль');
        }

        // Продвижение в session/index (Ввод поновой)
        return $this->forward('session/index');
    }

    // Выход
    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('До встречи!');
        return $this->forward('index/index');
    }
}
