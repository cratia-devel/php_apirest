<?php
    Route::get('/', function($req, $res) {
        $db = new Database();
        if($db->hasError())
            $res->json(500,NULL,$db->getError());
        else {
            $db->query('SELECT * FROM person WHERE (firstname = :name1) OR (firstname = :name2)');
            $db->bindParams(array(
                ':name1' => 'Carlos',
                ':name2' => 'Paola',
            ));
            $res->json(200,$db->fetchAll(),NULL);
        }
    });
    Route::post('/', function($req, $res) {
        $res->json(200,$req, NULL);
        die();
        $db = new Database();
        if($db->hasError())
            $res->json(500,NULL,$db->getError());
        else {
            $db->query('SELECT * FROM person WHERE (firstname = :name1) OR (firstname = :name2)');
            $db->bindParams(array(
                ':name1' => 'Carlos',
                ':name2' => 'Paola',
            ));
            $res->json(200,$db->fetchAll(),NULL);
        }
    });

?>