<?php

namespace App\Controller;


class ChipsController extends AppController
{

    public function view(){
        echo $this->response($this->conn->view("chips"));
    }
    public function add(){       
        echo $this->response($this->conn->add("chips", $this->data()));
    }

    public function find($id)
    {
        echo $this->response($this->conn->find("chips", $id));
    }
}
