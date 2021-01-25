<?php

include "db_conn.php";

session_start();    
    
    if(!isset($_SESSION['user_id'])){
     
        header('Location: index.php');
    }

    
    $user_id=$_SESSION['user_id'];

  
    




class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:server=localhost;dbname=notes', 'root', '');
         //   $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }

    public function getNotes()
    {
        $user_id=$_SESSION['user_id'];
        include "db_conn.php";
        $statement = $this->pdo->prepare("SELECT note_id,title,note, created_at, last_updated_at FROM notes WHERE 
            user_id =\"$user_id\" ORDER BY last_updated_at DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote($note)
    {
        $user_id=$_SESSION['user_id'];
        $statement = $this->pdo->prepare("INSERT INTO notes (user_id,title, note, created_at, last_updated_at)
                                    VALUES ( \"$user_id\", :title, :note, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");

       
        
        
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('note', $note['note']);
        
      
        
        return $statement->execute();
    }

    public function updateNote($iduser, $note)
    {
         $user_id=$_SESSION['user_id'];
        $statement = $this->pdo->prepare("UPDATE notes SET user_id=\"$user_id\",title = :title, note = :note, last_updated_at=:date  WHERE note_id = :note_id");

        $statement->bindValue('note_id', $id);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('note', $note['note']);
        $statement->bindValue('last_updated_at', date('Y-m-d H:i:s'));
        return $statement->execute();
    }

    public function removeNote($note_id)
    {
        $statement = $this->pdo->prepare("DELETE FROM notes WHERE note_id = :note_id");
        $statement->bindValue('note_id', $note_id);
        return $statement->execute();
    }

    public function getNoteById($note_id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE note_id = :note_id");
        $statement->bindValue('note_id', $note_id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

return new Connection();

