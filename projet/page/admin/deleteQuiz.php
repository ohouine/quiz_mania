<?php

session_start();
require_once '../function.php';

if (tokenSname() && $_SESSION['userName'] === 'admin') {
    
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $theme = filter_input(INPUT_GET,'theme',FILTER_SANITIZE_NUMBER_INT);

    $querie = 'DELETE FROM `TITLE` WHERE ID = :id;';
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':id' => $id,
    ]);

    header('location:../quizz/allQuizz.php?id='.$theme);

}else {
    header('location:../../index.php?alert=lol tu te prend pour qui');
}