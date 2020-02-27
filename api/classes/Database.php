<?php
namespace api\classes\database;

use PDO;
use PDOException;

/**
 * Class Database
 * gère la connexion à la base de donnée
 *
 */
class Database {
    private $_instance = null;


    /**
     * Database constructor.
     */
    public function __construct() {


        $this->createConnexion();
    }
    private function createConnexion(){
        $pDSN      =  DNS;
        $pUserName = USERNAME_DB;
        $pPassword = PASSWORD_DB;

        try {
            $this->_instance = new PDO($pDSN, $pUserName, $pPassword);
            $this->_instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->_instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->_instance->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $this->_instance->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

        }  catch (PDOException $e) {
            echo 'Base de Donnée Non Accessible ... veuillez reéessayer.';
        }
    }
    public function getInstance(){
        return $this->_instance;
    }

    public function stateObj(){
        var_dump("Obj Database Créé avec succès.");
        print_r("Obj Database Créé avec succès.");
    }
}