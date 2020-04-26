<?php
/**
 * Created by PhpStorm.
 * UserTest: root-home
 * Date: 28/02/2020
 * Time: 19:05
 */

namespace api\models\userModel;

ini_set('display_errors','on');
error_reporting(E_ALL);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class User extends Model
{

    protected $table = "user";


    /**
     * @param $email
     * @param $password
     * @return \Exception|string
     */
    public function Auth($email, $password)
    {
        $currentUser =  User::where('email' , $email)->first();

        if (!empty($currentUser)) {
            try {
                // on compare le password en base avec le post
                if (password_verify($password, $currentUser->password)) {

                    if ($currentUser->token == NULL) {
                        $this->setToken($currentUser);
                    }
                    if (date('Y-m-d H:i:s') > $currentUser->token_expire){
                            $this->setToken($currentUser);
                    }
                    $currentUser->save();
                    return $currentUser;

                } else {
                    return 'login failed';
                }
            } catch (\Exception $e) {
                return $e;
            }
        }

    }

    /**
     * create a new token  for active connexion
     * @param User $user
     * @throws \Exception
     */
    public function setToken(User &$user){

        $uuid = Uuid::uuid4()  ;
        $user->token = $uuid->toString();
        $user->token_expire = date('Y-m-d H:i:s', strtotime( TOKEN_EXPIRATION_DELAY));
    }

    /**
     *
     */
    public function checkToken(){

           // var_dump('method checkToken');
    }

    public  function checkByToken($token,$mail){

        $u  = User::where('token' , $token)
            ->where('email', $mail)
            ->where('token_expire' , '>' , date('Y-m-d H:i:s'))
            ->first();

        return $u ? true : false ;

    }
}