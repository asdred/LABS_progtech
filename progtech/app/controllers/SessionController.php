<?php

class SessionController extends ControllerBase
{

    private function _registerSession(User $user)
    {
        
        $this->session->set('auth', array(
            'id' => $user->id,
            'name' => $user->email
        ));
    }
    
    public function indexAction()
    {

    }
    
    public function startAction()
    {
        if ($this->request->isPost()) {

            // Получаем данные от пользователя
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Производим поиск в базе данных
            $user = User::findFirst(
                array(
                    "(email = :email:) AND password = :password:",
                    'bind' => array(
                        'email'    => $email,
                        'password' => sha1($password)
                    )
                )
            );

            if ($user != false) {

                // Регистрируем пользователя в сессии
                $this->_registerSession($user);

                $this->flash->success('Добро пожаловать ' . $user->email);

                // Перенаправляем на контроллер 'table', если пользователь существует
                return $this->dispatcher->forward(
                    array(
                        'controller' => 'table',
                        'action'     => 'index'
                    )
                );
                
                //header('Location: /table/index');
            }
            
            $this->flash->error('Неверный email/пароль');
        }
        
        // Снова показываем форму авторизации
        return $this->dispatcher->forward(
                    array(
                        'controller' => 'session',
                        'action'     => 'index'
                    )
                );
    }
    
    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        return $this->forward('index/index');
    }
}

