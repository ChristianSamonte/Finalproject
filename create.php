<?php
include "db_conn.php";

/** @var Connection $connection */
$connection = require_once 'pdo.php';

// Validate note object;

$note_id = $_POST['note_id'] ?? '';
$iduser =$_POST['user_id'] ?? '';
if ($id){
    $connection->updateNote($note_id, $_POST);

} else {
    $connection->addNote($_POST);
    $connection->removeNote($note_id);
}

header('Location: index.php');
