<?php


namespace Src\controller;

use Src\helper\OrmHelper;

class OrmController
{
    public function getAll($table) {
    
        if ($table == 'tickets') {
            $ormHelper = new OrmHelper();
            $tickets = $ormHelper->findAll("ticket");
            return $tickets;
        }
        else if ($table == 'comments') {
            $ormHelper = new OrmHelper();
            $comments = $ormHelper->findAll("comment");
            return $comments;
        }
    }


    public function getOne($table, $id) {
       if ($table == 'tickets') {
            $ormHelper = new OrmHelper();
            $ticket = $ormHelper->findOne("ticket", $id);
            return $ticket;
        }
        else if ($table == 'comments') {
            $ormHelper = new OrmHelper();
            $comment = $ormHelper->findOne("comment", $id);
            return $comment;
        }
    }

    //create
    public function create($table, $data) {
        if ($table == 'tickets') {
            $ormHelper = new OrmHelper();
            $ticket = $ormHelper->create("ticket", $data);
            return $ticket;
        }
        else if ($table == 'comments') {
            $ormHelper = new OrmHelper();
            $comment = $ormHelper->create("comment", $data);
            return $comment;
        }
    }

    public function getComments($id) {
        $ormHelper = new OrmHelper();
        $comments = $ormHelper->getComments($id);
        return $comments;
    }

    public function exportTicket($id) {
        $ormHelper = new OrmHelper();
        $ticket = $ormHelper->findOne("ticket", $id);
        $file = fopen("src/tickets/".$ticket->id.".csv", "w");
        fwrite($file,json_encode($ticket));
        return "Ticket ". $ticket->id . " exported to CSV!";
    }

}
     
   