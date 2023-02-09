<?php
session_start();
require_once '../function.php';

if (!tokenSname()) {
    header('location:../../index.php?alert=votre connection n est pas valide');
}

$userInfo = exeSingleSelect('SELECT USER_NAME,EMAIL FROM `USER` WHERE USER_NAME = :user;',[':user' => $_SESSION['userName']]);

$errorUser = '';
$errorMail = '';
$errorExist = '';
$error = false;
$errorInput = 'Veuillez remplir ce champ corectement';
$errorUserExist = "Ce nom d'utilisateur exist déjà ";
$errorMailExist = "Un autre utilisateur utilise déjà cette E-mail ";
$errorToLong = "30 charactère max.";

$user = filter_input(INPUT_POST,'user',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST,'mail',FILTER_VALIDATE_EMAIL);

if ($mail === null ) {
    $error = true;
    $mail = $userInfo['EMAIL'];
}

if ($user === null) {
    $error = true;
    $user = $userInfo['USER_NAME'];
}

if ($mail === '' || $mail === false) {
    $errorMail = $errorInput;
    $error = true;
}

if(!$error){
    if (strlen($mail) > 30) {
        $errorMail = $errorToLong;
    }

    if ($user === '' || $user === false) {
        $errorUser = $errorInput;
        $error = true;
    }

    if (strlen($user) > 20) {
        $errorUser = $errorToLong;
    }
}

if (!$error) {

    $oldData = exeSingleSelect('SELECT EMAIL,`PASSWORD` FROM `USER` WHERE USER_NAME = :user;',[':user' => $_SESSION['userName']]);
    $verifMailExists = exeSingleSelect('SELECT EMAIL FROM `USER` WHERE EMAIL = :mail AND USER_NAME != :user ;',[':mail' => $mail, ':user' => $_SESSION['userName']]);
    $verifNameExists = exeSingleSelect('SELECT USER_NAME FROM `USER` WHERE USER_NAME = :userName AND USER_NAME != :user;',[':userName' => $user, ':user' => $_SESSION['userName']]);

    $sameUser = true;
    $sameMail = true;
    $stop = false;

    if($user != $_SESSION['userName']) $sameUser = false; 
    if($mail != $oldData['EMAIL']) $sameMail = false; 

    if (!$sameUser) {
        if ($verifNameExists != false) {
            $errorExist = $errorUserExist;
            $stop = true;
        }
    }
    
    if (!$sameMail) {
        if ($verifMailExists != false) {
            $errorExist = $errorMailExist;
            $stop = true;
        }
    }
    
    if(!$stop){
        modifyUser($user,$mail);
        $_SESSION['userName'] = '';
        $_SESSION['token'] = '';
        connect($user,$oldData['PASSWORD']);
        die();
    }
        
    
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>modifier compte</title>
</head>
<body>
    <header>
        <div id="back"><a href="../../index.php"><img src="../../img/flecheGriffeLong.png" alt="fleche de retour"></a></div>
        <h3>Modifier mon compte</h3>
    </header>

    <main>
        <form action="#" method="post" id="connectForm">
            
            <span><?= $errorExist ?></span>
        
            <div>
                <label for="user">Nouveaux nom d'utilisateur <small>20 max</small></label>
                <span class="error"><?= $errorUser ?></span>
                <input type="text" name="user" id="user" value="<?= $user ?>">
            </div>

            <div>
                <label for="mail">Nouvelle e-mail</label>
                <span class="error"><?= $errorMail ?></span>
                <input type="mail" name="mail" id="mail" value="<?= $mail ?>">
            </div>

            <input type="submit" value="Modifier">
        </form>
        <a href="modifyPassword.php">changer de mot de passe</a>
    </main>
</body>
</html>