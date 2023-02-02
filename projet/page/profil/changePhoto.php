<?php
session_start();
require_once '../function.php';

$image = filter_input(INPUT_GET,'img',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (tokenSname()) {
    
    $img = exeSingleSelect('SELECT * FROM `IMAGE` WHERE IMG = "'.$image.'";');

    if ($image != false && $img['TYPE'] == 'icone' ) {
        
        $statement = cnn()->prepare('UPDATE `USER` SET IMAGE = :img WHERE USER_NAME = :userName;');
        $statement->execute([
            ':img' => $image,
            ':userName' => $_SESSION['userName']
        ]);
        header('location:profil.php');
    }else {
        header('location:../../index.php?alert=une erreur viens de se produire essayer une autre image');
    }
}