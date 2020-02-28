<?php
/**
 * Created by PhpStorm.
 * User: root-home
 * Date: 26/02/2020
 * Time: 19:07
 */
namespace api\models\user;

use api\classes\database\Database;

class User
{
    private $_db;


    public function __construct(){
        $this->_db = new Database();
    }

    public function Auth($email,$password){
        $req = $this->_db->getInstance()->prepare('SELECT * FROM user WHERE email = ?');

        $req->execute([$email]);
        $user = $req->fetch();
        if (!empty($user)){
            return $user;
            try {

                // on compare le password en base avec le post
                if (password_verify($password,$user->password)){
                    $_SESSION['auth'] = $user;
                    /*
                      // mise en session des accès Nodes
                        $this->AuthAccessNode($user);
                      //GESTION Droit ---------
                        $this->AuthDroit($user);
                      // LOG CONNEXION
                        $this->AuthLog($user);
                    */
                }else{

                }
            }catch (\Exception $e) {

            }
        }
    }
}