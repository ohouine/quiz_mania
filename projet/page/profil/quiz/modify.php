<?php
session_start();
require_once '../../function.php';

if (!tokenSname()) {
    die();
}

$querie = "UPDATE TITLE SET TITLE = :newTitle WHERE TITLE = :oldTitle ";
$statement = cnn()->prepare($querie);
$statement->execute([
    ':newTitle' => $_POST['title'],
    ':oldTitle' => $_POST['newTitle'],
]);

unset($_POST['title']);
unset($_POST['newTitle']);

$dividedArray = array_chunk($_POST,4);

var_dump($dividedArray);

foreach ($dividedArray as $i => $value) {
    $querie = "UPDATE QUESTION SET QUESTION = :newTitle WHERE TITLE = :oldTitle ";
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':newTitle' => $_POST['title'],
        ':oldTitle' => $_POST['newTitle'],
    ]);
}