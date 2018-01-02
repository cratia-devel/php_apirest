<?php

    Route::get('/php/php_apirest/', function($req, $res) {
        $p = new Person();
        //$res->status()->json($p->all()->get(),null);
        /*
        $p->load(2);
        $p->firstname = 'Carlos Alberto';
        $p->lastname = 'Ratia Viloria';
        $p->age = 32;
        */
        
        //$res->status()->json($p->save(),null);
        //$res->status()->json($p->find(1),null);
        //$res->status()->json($p->find(array(1,3,5,10)),null);

        //$res->status()->json($p->where('lastname','<>','Ratia')->get(),null);
        $res->status(200)
            ->type('json');
        //var_dump($res->get());
        $res->redirect('/php/php_apirest/person');
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2)->get(),null);
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2,3)->get(),null);
        //$res->status()->json($p->where(array('lastname','<>','Ratia Viloria'))->get(),null);
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2,3)->order_by('age')->get(),null);
        //$res->status()->json($p->where(array('lastname','<>','Ratia Viloria'))->order_by('age', 'DESC')->get(),null);
        //$res->status()->json($p->where(array('lastname','<>','Ratia Viloria'))->order_by('age', 'ASC')->get(),null);
        //$res->status()->json($p->where('lastname','<>','Ratia')->limit(2,3)->group_by('age')->get(),null);
/*
        $res->status()->json($p
                        ->where(array('lastname','<>','Ratia Viloria'))
                        ->group_by('age')
                        ->get(),
                    null);
*/
        // $res->status()->json($p->save(),null);
    });

    Route::get('/php/php_apirest/person', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->all()->get(),null);
    });

    Route::post('/php/php_apirest/person/new', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->save(),null);
    });

    Route::post('/php/php_apirest/person/delete', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->delete(array(32,33,34)), null);
    });
 
    Route::get('/php/php_apirest/person/trash', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->trash()->get(), null);
    });

    Route::post('/php/php_apirest/person/delete_hard', function($req, $res) {
        $p = new Person();
        $res
            ->status(200)
            ->type('json')
            ->json($p->hardDelete(25), null);
    });
?>