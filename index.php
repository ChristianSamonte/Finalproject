<?php

/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();

$currentNote = [
    'id' => '',
    'note_id' => '',
    'title' => '',
    'note' => ''
];
if (isset($_GET['note_id'])) {
    $currentNote = $connection->getNoteById($_GET['note_id']);
}

?>

<?php 



if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

 ?>

    <title>HOME</title>
  
<body>
     <h1>Hello, <?php echo $_SESSION['name']; ?></h1>
 
     <a href="logout.php">Logout</a>
</body>
</html>

<?php 
}else{
     header("Location: home.php");
     exit();
}
 ?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Document</title>
    <link rel="stylesheet" href="index.css">

</head>
<body>
<div>
    <form class="new-note" action="create.php" method="post">
        <input type="hidden" name="note_id" value="<?php echo $currentNote['note_id'] ?>">
        <input type="text" name="title" placeholder="Note title" autocomplete="off"
               value="<?php echo $currentNote['title'] ?>">
        <textarea name="note" cols="30" rows="4"
                  placeholder="Note Description"><?php echo $currentNote['note'] ?></textarea>
        <button>
            <?php if ($currentNote['note_id']): ?>
                Update
            <?php else: ?>
                New note
            <?php endif ?>
        </button>
    </form>
    <div class="notes">
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <div class="title">
                    <a href="?note_id=<?php echo $note['note_id'] ?>">
                        <?php echo $note['title'] ?>
                    </a>
                </div>
                <div class="note">
                    <?php echo $note['note'] ?>
                </div>
                <small><?php echo date('d/m/Y H:i', strtotime($note['last_updated_at'])) ?></small>
                <form action="delete.php" method="post">
                    <input type="hidden" name="note_id" value="<?php echo $note['note_id'] ?>">
                    <button class="close">X</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
