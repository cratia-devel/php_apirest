<?php

    Route::get('/', function($req, $res) {
        $p = new Person();
        $p->load(2);
        $p->firstname = 'Carlos Alberto'; 
        $res->json(200,$p->save(),NULL);
        //$res->json(200,$p->find(1),NULL);
        //$res->json(200,$p->find(array(1,3,5,10)),NULL);
        /*
        $res->json(200,$p->where(
                array(
                    array('firstname','LIKE','CARLOS'),
                    array('id','<>','3'),
                )
            ),NULL);
        */
        //$res->json(200,$p->where('lastname','=','Ratia'),NULL);
        //$res->json(200,$p->where(array('lastname','=','Ratia')),NULL);
        //$res->json(200,$p->save(),NULL);
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