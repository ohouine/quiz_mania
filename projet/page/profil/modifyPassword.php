<?php 

session_start();
require_once '../function.php';

if (!tokenSname()) {
    header('location:../../index.php?alert=votre connection n est pas valide');
}

$errorPassword = '';
$errorSecPassword ='';
$error = false;
$errorInput = 'Veuillez remplir ce champ corectement';
$errorNotSame = 'Les mots de passe ne correspondent pas';
$errorToLong = "30 charactère max.";

$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$secPassword = filter_input(INPUT_POST,'secPassword',FILTER_SANITIZE_FULL_SPECIAL_CHARS);


if ($password === null) $error = true;

if ($password === '' || $password === false) {
    $errorPassword = $errorInput;
    $error = true;
}
if(!$error){
if (strlen($password) > 30) {
    $errorPassword = $errorToLong;
}

if ($password != $secPassword) {
    $errorSecPassword = $errorNotSame;
    $error = true;
}

if (!$error) {
    modifyPassword($password);
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
    <title>Modifier le mot de passe</title>
</head>
<body>
    
<header>
    <div id="back"><a href="../../index.php"><img src="../../img/flecheGriffeLong.png" alt="fleche de retour"></a></div>
    <h3>changer de mot-de-passe</h3>
</header>

<main>
    <form action="#" method="post" id="connectForm">

        <div>
            <label for="password">Nouveax mot de passe</label>
            <span class="error"><?= $errorPassword ?></span>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="secPassword">Confirmé mot de passe</label>
            <span class="error"><?= $errorSecPassword ?></span>
            <input type="password" name="secPassword" id="secPassword">
        </div>

        <input type="submit" value="Changer">

    </form>
</main>

</body>
</html>