<?php
session_start();
require_once '../function.php';

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

if (tokenSname()) {
    
    $img = exeSingleSelect('SELECT * FROM `IMAGE` WHERE ID = '.$id.';');

    if ($img != false && $img['TYPE'] == 'icone' ) {
        
        $statement = cnn()->prepare('UPDATE `USER` SET ID_IMAGE = :id WHERE USER_NAME = :userName;');
        $statement->execute([
            ':id' => $id,
            ':userName' => $_SESSION['userName']
        ]);
        header('location:profil.php');
    }else {
        header('location:../../index.php?alert=une erreur viens de se produire essayer une autre image');
    }
}