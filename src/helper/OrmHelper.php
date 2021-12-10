<?php


namespace Src\helper;


use Src\model\OrmModel;

class OrmHelper
{
    //find all
    public function findAll($table)
    {
        $ormModel = new \Src\model\OrmModel();
        $result = $ormModel->findAll($table);
        return $result;
    }

    //find one
    public function findOne($table, $id)
    {
        $ormModel = new \Src\model\OrmModel();
        $result = $ormModel->findOne($id, $table);
        return $result;
    }

    //create
    public function create($table, $data)
    {
        $ormModel = new \Src\model\OrmModel();
        $result = $ormModel->create($table, $data);
        return $result;
    }

    public function getComments($id)
    {
        $ormModel = new \Src\model\OrmModel();
        $ticket = $ormModel->findOne($id, 'ticket');
        $comments = $ticket->comments;
        return $comments;
    }
}