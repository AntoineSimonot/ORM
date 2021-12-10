<?php


namespace Src\model;

class OrmModel
{
    protected $db;
    protected $dbi;

    public function __construct()
    {
        $this->dbi = parse_ini_file("src/config/config.ini");
       
        $this->db = new \PDO('mysql:' . $this->dbi["type"] .'=' .$this->dbi["host"] . ';dbname=' . $this->dbi["name"], $this->dbi["user"], $this->dbi["pass"]);
    }

    //find by id
    public function findOne($id, $table)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM $table WHERE id = :id");
            $query->setFetchMode(\PDO::FETCH_CLASS, 'Src\model\OrmModel');
            $query->execute(['id' => $id]);
            $result = $query->fetch();
            if ($table == 'ticket') {
                $result->comments = $this->findAllComments($id);
            }
            return $result;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }


    //find all 
    public function findAll($table)
    {
        
        try {
            $query = $this->db->prepare("SELECT * FROM $table");
            $query->setFetchMode(\PDO::FETCH_CLASS, 'Src\model\OrmModel');
            $query->execute();
            $result = $query->fetchAll();
            if ($table == 'ticket') {
                foreach ($result as $ticket) {
                    $ticket->comments = $this->findAllComments($ticket->id);
                }
            }
            return $result;
        } catch (\Exception $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    // find all comments
    public function findAllComments($id)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM comment WHERE ticket_id = :id");
            $query->setFetchMode(\PDO::FETCH_CLASS, 'Src\model\OrmModel');
            $query->execute(['id' => $id]);
            $result = $query->fetchAll();
            return $result;
        } catch (\Exception $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function create($table, $data)
    {

        try {
            $columns = implode(',', array_keys($data)); // ['title', 'content']
            $values = ':' . implode(', :', array_keys($data)); // :title, :content
            $query = $this->db->prepare("INSERT INTO $table ($columns) VALUES ($values)"); // INSERT INTO ticket (title, content) VALUES (:title, :content) 
            $query->execute($data); // [ 'title' => 'title', 'content' => 'content' ]
            return $this->findOne($this->db->lastInsertId(), $table);
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

}