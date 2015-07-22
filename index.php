<?php
/**
 * Created by Svyatoslav Svitlychnyi.
 * Date: 21.07.2015
 * Time: 11:34
 */


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Records.php';


$klein = new \Klein\Klein();
//$app = new \Models\Records();


// lazy services
$klein->respond(function ($request, $response, $service, $app) {
    $app->register('db', function() {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=kievdevel_zam", 'kievdevel_zam', 'zaq12wsx');
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $connection;
    });

    // todo: register validators
});

// index
$klein->respond('GET', '/', function($request, $response, $service, $app) {


    /**@var \PDO $db  PDO Object */
    $db = $app->db;

    $query = "SELECT * FROM notes";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    $html = '';
    if ($num > 0) {
        $html = '';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            //creating new table row per record
            $html .= "<tr>";
            $html .= "<td>{$id}</td>";
            $html .= "<td>{$name}</td>";
            $html .= "<td>{$email}</td>";
            $html .= "<td>{$address}</td>";
            $html .= "<td>{$number}</td>";
            $html .= "<td>{$comment}</td>";
            $html .= "<td><a href=\"delete/{$id}\">Delete post</a></td>";
            $html .= "<td><a href=\"update/{$id}\">Update post</a></td>";
            $html .= "</tr>";
        }
    }

    $service->render('view/index.php', ['html' => $html]);
});

// delete action
$klein->respond('GET', '/delete/[:id]', function ($request, $response, $service, $app) {

    /**@var \PDO $db  PDO Object */
    $db = $app->db;

    $query = "DELETE FROM notes WHERE id = ".(int)$request->id;
    $stmt = $db->prepare($query);
    $stmt->execute();

    $response->redirect('/');


});

$klein->respond('GET', '/create', function ($request, $response, $service, $app) {

    $service->render('view/create.php');

});

$klein->respond('POST', '/create', function ($request, $response, $service, $app) {

    /**@var \PDO $db  PDO Object */
    $db = $app->db;

    try {
        $service->validateParam('name', 'Please enter a valid username')
            ->isLen(1, 64)
            ->isChars('a-zA-Z0-9-')
        ;
        $service->validateParam('email', 'Please enter a valid email')
            ->isLen(1, 64)
            ->isEmail()
        ;
        $service->validateParam('phone', 'Please enter a valid number')
            ->isLen(1, 32)
            ->isInt()
        ;
        $service->validateParam('address', 'Please enter a valid address')
            ->notNull()
        ;
        /* todo:: create custom validator
         $service->validateParam('comment', 'Please enter a valid comment')
            ->isAlnum()
        ;
         */

    } catch(Exception $e) {
        echo $e->getMessage();
        die();
    }

    $name = $request->paramsPost()->name;
    $email = $request->paramsPost()->email;
    $phone = $request->paramsPost()->phone;
    $address = $request->paramsPost()->address;
    $comment = isset($request->paramsPost()->address) ? $request->paramsPost()->address : '';

    $query = "INSERT INTO `testzam`.`notes` (`id`, `name`, `email`, `address`, `number`, `comment`)
              VALUES (NULL, '{$name}', '{$email}', '{$address}', {$phone}, '{$comment}');
    ";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $response->redirect('/');

});

$klein->respond('GET', '/update/[:id]', function ($request, $response, $service, $app) {

    /**@var \PDO $db  PDO Object */
    $db = $app->db;

    $query = "SELECT * FROM notes WHERE id = ".(int)$request->id;
    $stmt = $db->prepare($query);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $service->render('view/update.php', ['data' => $data]);

});

$klein->respond('POST', '/update', function ($request, $response, $service, $app) {

    /**@var \PDO $db  PDO Object */
    $db = $app->db;

    try {
        $service->validateParam('id', 'Wow, such injection')
            ->isInt()
        ;
        $service->validateParam('name', 'Please enter a valid username')
            ->isLen(1, 64)
            ->isChars('a-zA-Z0-9-')
        ;
        $service->validateParam('email', 'Please enter a valid email')
            ->isLen(1, 64)
            ->isEmail()
        ;
        $service->validateParam('phone', 'Please enter a valid number')
            ->isLen(1, 32)
            ->isInt()
        ;
        $service->validateParam('address', 'Please enter a valid address')
            ->notNull()
        ;
        /* todo:: create custom validator
         $service->validateParam('comment', 'Please enter a valid comment')
            ->isAlnum()
        ;
         */

    } catch(Exception $e) {
        echo $e->getMessage();
        die();
    }

    $id = $request->paramsPost()->id;
    $name = $request->paramsPost()->name;
    $email = $request->paramsPost()->email;
    $phone = $request->paramsPost()->phone;
    $address = $request->paramsPost()->address;
    $comment = $request->paramsPost()->comment;

    /*
     $query = "UPDATE notes
            SET name = :name,
                id = :id,
                email = :email,
                number = :number,
                address = :address,
                comment = :comment,
            WHERE id = :id
    ";
     */
    $query = "UPDATE `notes`
                  SET `name`='{$name}',
                      `email`='{$email}',
                      `address`='{$address}',
                      `number`={$phone},
                      `comment`='{$comment}'
                  WHERE `id`=$id
    ";

    try {
        $stmt = $db->prepare($query);
        /*
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":number", $phone);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":comment", $comment);
            $stmt->bindParam(":id", $id);
         */

        if ($stmt->execute()) {
            $response->redirect('/');
            echo "Record was updated.";
        } else {
            die('Unable to update record.');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }

    $response->redirect('/');

});

$klein->dispatch();