<?php

namespace App\Controller;



use Firebase\JWT\JWT;



class AuthenticationController extends AppController
{

    private $key  = "teste";
    public $payload = [];
    public $auth;

    public function __construct()
    {
        $this->auth = $this->getAuthType();
    }

    
    public function encode($uid){
        $this->payload =  array(
            "uid" => $uid,
            "create" => time(),
            "expire" => time() + 3600);
         return ["token" => JWT::encode($this->payload, $this->key), "uid" => $uid, "expire" => time() + 3600];
        
    }


    public function getAuthType(){
        list($type, $data) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);

        return ["type" => $type, "data" => $data];
    }

    public function decode($token){

        try {
            return JWT::decode($token, $this->key, array('HS256'));
        } catch (\Throwable $th) {
            return false;
        }
        
    }
    

}