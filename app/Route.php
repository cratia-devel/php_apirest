<?php

    Route::get('/php/php_apirest/', function($req, $res) {
        $p = new Person();
        //$res->status()->json($p->all()->get(),NULL);
        /*
        $p->load(2);
        $p->firstname = 'Carlos Alberto';
        $p->lastname = 'Ratia Viloria';
        $p->age = 32;
        */
        
        //$res->status()->json($p->save(),NULL);
        //$res->status()->json($p->find(1),NULL);
        //$res->status()->json($p->find(array(1,3,5,10)),NULL);

        //$res->status()->json($p->where('lastname','<>','Ratia')->get(),NULL);
        $res->status(200)
            ->type('json');
        //var_dump($res->get());
        $res->redirect('/php/php_apirest/person');
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2)->get(),NULL);
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2,3)->get(),NULL);
        //$res->status()->json($p->where(array('lastname','<>','Ratia Viloria'))->get(),NULL);
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2,3)->order_by('age')->get(),NULL);
        //$res->status()->json($p->where(array('lastname','<>','Ratia Viloria'))->order_by('age', 'DESC')->get(),NULL);
        //$res->status()->json($p->where(array('lastname','<>','Ratia Viloria'))->order_by('age', 'ASC')->get(),NULL);
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2,3)->group_by('age')->get(),NULL);
/*
        $res->status()->json($p
                        ->where(array('lastname','<>','Ratia Viloria'))
                        ->group_by('age')
                        ->get(),
                    NULL);
*/
        // $res->status()->json($p->save(),NULL);
    });

    Route::get('/php/php_apirest/person', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->all()->get(),NULL);
    });

    Route::post('/php/php_apirest/person/new', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->save(),NULL);
    });
    
?>