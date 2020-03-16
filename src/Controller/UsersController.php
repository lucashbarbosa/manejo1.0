<?php

declare(strict_types=1);

namespace App\Controller;


use App\Controller\DatabaseController;
use App\Controller\JwtController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{



    public $conn;
    protected $password;
    public $username;


    public function authenticate()
    {


        $auth = new AuthenticationController();


        if ($auth->auth["type"] == 'Basic') {
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {


                $this->password = $_SERVER['PHP_AUTH_PW'];
                $this->username = $_SERVER['PHP_AUTH_USER'];

                $identity = $this->identify();
                //TODO: Try Catch Here for database connection
                if (!$identity) {
                    echo $this->response(false, 401,  "User Or password are incorrect");
                    die();
                } else {

                    echo $this->response($auth->encode($identity[0]['id']));
                    die();
                }
            } else {
                echo $this->response("User or Password is missing");
                die();
            }
        } else if ($auth->auth["type"] == "Bearer") {

            if (!$auth->decode($auth->auth["data"])) {
                echo $this->response(false, 401,  "Invalid Token");
                die();
            }
        }
    }

    public function identify()
    {


        $this->conn = new DatabaseController();
        if (isset($this->username) && isset($this->password)) {

            $query = "SELECT * FROM  users WHERE username = '$this->username' AND password ='$this->password'";

            return $this->conn->execute($query);
        }
    }



    public function index()
    {
        echo $this->response($this->conn->view("users"));
    }
    public function add()
    {
        echo $this->response($this->conn->add("users", $this->data()));
    }

    public function find($id)
    {
        echo $this->response($this->conn->find("users", $id));
    }
}
