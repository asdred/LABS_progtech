<?php

header('Content-Type: application/json; charset=utf-8');

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Http\Response;

// Используем Loader() для автозагрузки нашей модели
$loader = new Loader();

$loader->registerDirs(
    array(
        __DIR__ . '/models/'
    )
)->register();

$di = new FactoryDefault();

// Настраиваем сервис базы данных
$di->set('db', function () {
    return new PdoMysql(
        array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "admin",
            "dbname"   => "progtech",
            'charset' => 'utf8'
        )
    );
});

// Создаем и привязываем DI к приложению
$app = new Micro($di);

// Тут определяются маршруты

// Получение всех владельцев
$app->get('/owner', function () use ($app) {

    $phql = "SELECT * FROM Owner WHERE del = 0 ORDER BY name";
    $owners = $app->modelsManager->executeQuery($phql);

    $data = array();
    foreach ($owners as $owner) {
        $data[] = array(
            'id'   => $owner->id,
            'name' => $owner->name
        );
    } 
    
    if ($owner == false) {
        echo json_encode(
            array(
                'status' => 'Не_найдено',
                'data'   => $data
            ), 
            JSON_UNESCAPED_UNICODE
        );
    } else {
        echo json_encode(
            array(
                'status' => 'Найдено',
                'data'   => $data
            ), 
            JSON_UNESCAPED_UNICODE
        );
    }
});

// Поиск владельцев с $name в названии
$app->get('/owner/search/{name}', function ($name) use ($app) {

    $phql = "SELECT * FROM Owner WHERE name LIKE :name: and del = 0 ORDER BY name";
    $owners = $app->modelsManager->executeQuery(
        $phql,
        array(
            'name' => '%' . $name . '%'
        )
    );

    $data = array();
    foreach ($owners as $owner) {
        $data[] = array(
            'id'   => $owner->id,
            'name' => $owner->name
        );
    }

    if ($owner == false) {
        echo json_encode(
            array(
                'status' => 'Не_найдено',
                'data'   => $data
            ), 
            JSON_UNESCAPED_UNICODE
        );
    } else {
        echo json_encode(
            array(
                'status' => 'Найдено',
                'data'   => $data
            ), 
            JSON_UNESCAPED_UNICODE
        );
    }
});

// Получение владельца по первичному ключу
$app->get('/owner/{id:[0-9]+}', function ($id) use ($app) {

    $phql = "SELECT * FROM Owner WHERE id = :id: and del = 0";
    $owner = $app->modelsManager->executeQuery($phql, array(
        'id' => $id
    ))->getFirst();
    
    if ($owner == false) {
        echo json_encode(
            array(
                'status' => 'Не_найдено',
                'data'   => $data
            ), 
            JSON_UNESCAPED_UNICODE
        );
    } else {
        echo json_encode(
            array(
                'status' => 'Найдено',
                'data'   => array(
                    'id'   => $owner->id,
                    'name' => $owner->name
                )
            ), 
            JSON_UNESCAPED_UNICODE
        );
    }
});

// Добавление нового владельца
$app->post('/owner', function () use ($app) {
    
    $owner = $app->request->getJsonRawBody();

    $phql = "INSERT INTO Owner (name) VALUES (:name:)";

    $status = $app->modelsManager->executeQuery($phql, array(
        'name' => $owner->name
    ));

    // Формируем ответ
    $response = new Response();

    // Проверяем, что вставка произведена успешно
    if ($status->success() == true) {

        // Меняем HTTP статус
        $response->setStatusCode(201, "Created");

        $owner->id = $status->getModel()->id;

        $response->setJsonContent(
            array(
                'status' => 'CREATED'
            )
        );

    } else {

        // Меняем HTTP статус
        $response->setStatusCode(409, "Conflict");

        // Отправляем сообщение об ошибке клиенту
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    $response->setContentType('application/json', 'UTF-8');
    return $response;
    
});

// Обновление владельца по первичному ключу
$app->put('/owner/{id:[0-9]+}', function ($id) use ($app) {

    $owner = $app->request->getJsonRawBody();

    $phql = "UPDATE Owner SET name = :name: WHERE id = :id: and del = 0";
    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $id,
        'name' => $owner->name
    ));

    // Формируем ответ
    $response = new Response();

    // Проверяем, что обновление произведено успешно
    if ($status->success() == true) {
        $response->setJsonContent(
            array(
                'status' => 'UPDATED'
            )
        );
    } else {

        // Меняем HTTP статус
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    $response->setContentType('application/json', 'UTF-8');
    return $response;
});

// Удаление владельца по первичному ключу
$app->delete('/owner/{id:[0-9]+}', function ($id) use ($app) {

    $phql = "UPDATE Owner SET del = 1 WHERE id = :id: and del = 0";
    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $id
    ));

    // Формируем ответ
    $response = new Response();

    if ($status->success() == true) {
        $response->setJsonContent(
            array(
                'status' => 'DELETED'
            )
        );
    } else {

        // Меняем HTTP статус
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    $response->setContentType('application/json', 'UTF-8');
    return $response;
});

// Несуществующий маршрут
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'Неверный адрес!';
});

$app->handle();