<?php
/**
 * Created by PhpStorm.
 * UserTest: root-home
 * Date: 28/02/2020
 * Time: 06:47
 */

namespace api\controllers\Controller;


class Controller
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


    // lazy Loading on container
    public function __get($property){

        if ($this->container->{$property}){
            return$this->container->{$property};
        }
        //var_dump($property);
    }

}