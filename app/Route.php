<?php

    Route::get('/php/php_apirest/', function($req, $res) {
        $p = new Person();
        //$res->json(200,$p->all()->get(),NULL);
        /*
        $p->load(2);
        $p->firstname = 'Carlos Alberto';
        $p->lastname = 'Ratia Viloria';
        $p->age = 32;
        */
        
        $res->json(200,$p->save(),NULL);
        //$res->json(200,$p->find(1),NULL);
        //$res->json(200,$p->find(array(1,3,5,10)),NULL);

        //$res->json(200,$p->where('lastname','<>','Ratia')->get(),NULL);
        //$res->json(200,$p->where('lastname','<>','Ratia')->limit(2)->get(),NULL);
        //$res->json(200,$p->where('lastname','<>','Ratia')->limit(2,3)->get(),NULL);
        //$res->json(200,$p->where(array('lastname','<>','Ratia Viloria'))->get(),NULL);
        //$res->json(200,$p->where('lastname','<>','Ratia')->limit(2,3)->order_by('age')->get(),NULL);
        //$res->json(200,$p->where(array('lastname','<>','Ratia Viloria'))->order_by('age', 'DESC')->get(),NULL);
        //$res->json(200,$p->where(array('lastname','<>','Ratia Viloria'))->order_by('age', 'ASC')->get(),NULL);
        //$res->json(200,$p->where('lastname','<>','Ratia')->limit(2,3)->group_by('age')->get(),NULL);
/*
        $res->json(200,$p
                        ->where(array('lastname','<>','Ratia Viloria'))
                        ->group_by('age')
                        ->group_by('firstname')
                        ->get(),
                    NULL);
*/
                    // $res->json(200,$p->save(),NULL);
    });

?>