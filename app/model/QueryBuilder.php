<?php

class QueryBuilder
{

    public static function Builder($type_query, $table, $values_object, $row = NULL, $conditional = NULL){

        $query = '';
        $sub_query1 = '';
        $sub_query2 = '';
        $parameters = array();
        $i = 1;

        switch ($type_query) {
            case 'INSERT':
                $query = 'INSERT INTO ' . $table . '';
                $sub_query1 = '( ';
                $sub_query2 = '( ';
                break;
            case 'UPDATE':
                $query = 'UPDATE ' . $table . ' SET ';
                $sub_query1 = '';
                break;
            default:
                # code...
                break;
        }

        if(is_array($values_object)) {
            foreach ($values_object as $key => $value) {
                switch ($type_query) {
                    case 'INSERT':
                        $sub_query1 .= $key;
                        $sub_query2 .= ':value' . $i;
                        break;
                    case 'UPDATE':
                        $sub_query1 .= $key.' = '.':value' .$i;
                        break;
                    default:
                        # code...
                        break;
                }
                if ($i < count($values_object)) {
                    $sub_query1 .= ' , ';
                    $sub_query2 .= ' , ';
                }
                $parameters = array_merge($parameters, array(':value' . $i => $values_object[$key]));
                $i++;
            }
        }
        switch ($type_query) {
            case 'INSERT':
                $sub_query1 .= ' )';
                $sub_query2 .= ' )';
                $query = $query . ' ' . $sub_query1 . ' VALUES ' . $sub_query2;            
                break;
            case 'UPDATE':
                $parameters = array_merge($parameters, array(':id' => $values_object['id']));
                $query = $query .' '. $sub_query1 .' WHERE id = :id';        
                break;
            case 'WHERE':
                $query = 'SELECT * FROM ' . $table . ' WHERE ' . $row . ' ' . $conditional . ' :value';
                $parameters = array(':value' => $values_object);
                break;

            default:
                # code...
                break;
        }
        return array($query, $parameters);
    }
}


?>