<?php
session_start();
require_once '../function.php';

$errorUser = '';
$errorMail = '';
$errorPassword = '';
$errorSecPassword ='';
$errorExist = '';
$error = false;
$errorInput = 'Veuillez remplir ce champ corectement';
$errorNotSame = 'Les mots de passe ne correspondent pas';
$errorUserExist = "Ce nom d'utilisateur exist déjà ";
$errorMailExist = "Un autre utilisateur utilise déjà cette E-mail ";
$errorToLong = "30 charactère max.";

$user = filter_input(INPUT_POST,'user',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$secPassword = filter_input(INPUT_POST,'secPassword',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST,'mail',FILTER_VALIDATE_EMAIL);

if ($mail === null ) $error = true;

if ($user === null) $error = true;

if ($password === null) $error = true;

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

if ($password === '' || $password === false) {
    $errorPassword = $errorInput;
    $error = true;
}

if (strlen($password) > 30) {
    $errorPassword = $errorToLong;
}

if ($password != $secPassword) {
    $errorSecPassword = $errorNotSame;
    $error = true;
}
}

if (!$error) {
    if(verifieUserExist($user)){
        $errorExist = $errorUserExist;
    }elseif (verifieMailExist($mail)) {
        $errorExist = $errorMailExist;
    } else {
        addUser($user,$mail,$password);
        connect($user,$password);
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
    <title>Crée un compte</title>
</head>
<body>
    <header>
        <div id="back"><a href="../../index.php"><img src="../../img/flecheGriffeLong.png" alt="fleche de retour"></a></div>
        <h1>Crée un commpte</h1>
    </header>
    <main>
        <form action="#" method="post" id="connectForm">
            
            <span><?= $errorExist ?></span>
        
            <div>
                <label for="user">Nom d'utilisateur <small>20 max</small></label>
                <span class="error"><?= $errorUser ?></span>
                <input type="text" name="user" id="user" value="<?= $user ?>">
            </div>

            <div>
                <label for="mail">E-mail</label>
                <span class="error"><?= $errorMail ?></span>
                <input type="mail" name="mail" id="mail" value="<?= $mail ?>">
            </div>


            <div>
                <label for="password">Mot de passe</label>
                <span class="error"><?= $errorPassword ?></span>
                <input type="password" name="password" id="password">
            </div>

            <div>
                <label for="secPassword">confirmé votre mot de passe</label>
                <span class="error"><?= $errorSecPassword ?></span>
                <input type="password" name="secPassword" id="secPassword">
            </div>


            <input type="submit" value="Se connecter">
        </form>
    </main>
</body>
</html>