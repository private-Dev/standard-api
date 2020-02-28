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
use Ramsey\Uuid\Uuid;

class User extends Model
{

    protected $table = "user";


    public function Auth($email, $password)
    {

        $currentUser =  User::where('email' , $email)->first();

        if (!empty($currentUser)) {

            try {
                // on compare le password en base avec le post
                if (password_verify($password, $currentUser->password)) {

                    if ($currentUser->token !== NULL){

                        if (date('Y-m-d H:i:s') > $currentUser->token_expire){
                            $currentUser->token = NULL;
                        }
                    }
                    // get token
                    if ($currentUser->token == NULL) {
                        // generate Token
                        $uuid = Uuid::uuid4()  ;
                        $currentUser->token = $uuid->toString();
                        $currentUser->token_expire = date('Y-m-d H:i:s', strtotime( TOKEN_EXPIRATION_DELAY));
                        $currentUser->save();
                    }

                    return $currentUser;

                } else {
                    return 'password failed';
                }
            } catch (\Exception $e) {
                return $e;
            }
        }

    }
}