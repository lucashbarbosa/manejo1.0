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

    public function execute($query)
    {
        try {
            $data = $this->connection
                ->execute($query)
                ->fetchAll('assoc');

            if (is_array($data) && count($data) > 0) {
                return $data;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return $th->getCode() . " - " . $th->getMessage();
        }
    }


    public function view($table)
    {
        try {
            return $this->connection
                ->execute("SELECT * FROM $table")
                ->fetchAll('assoc');
        } catch (\Throwable $th) {
            return $th->getCode() . " - " . $th->getMessage();
        }
    }

    public function find($table, $id)
    {
        try {
            return $this->connection
                ->execute("SELECT * FROM $table WHERE id = $id")
                ->fetch('assoc');
        } catch (\Throwable $th) {
            return $th->getCode() . " - " . $th->getMessage();
        }
    }


    public function add($table, $data)
    {

        try {
            return $this->connection->insert($table, $data);
        } catch (\Throwable $th) {
            return $th->getCode() . " - " . $th->getMessage();
        }
    }
}
