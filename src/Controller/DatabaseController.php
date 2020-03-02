<?php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;


//TODO: Finish the basic methods


class DatabaseController extends AppController
{
    protected $connection;

    public function __construct()
    {
        $this->connection = ConnectionManager::get('default');
    }

    public function query($query)
    {
        try {
            return $this->connection
                ->execute($query)
                ->fetchAll('assoc');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function find($id, $table)
    {
        try {
            return $this->connection
                ->execute("SELECT * FROM $table WHERE id = $id")
                ->fetch('assoc');
        } catch (\Throwable $th) {
            return $th;
        }
    }


    public function insert($data, $table)
    {

        try {
            $this->connection->insert($table, $data);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
