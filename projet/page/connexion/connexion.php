<?php

session_start();

require_once '../function.php';
$errorUser = '';
$errorPassword = '';
$errortxt = 'Veuillez remplir ce champ corectement';
$error = false;
$errorConnexion = '';

$user = filter_input(INPUT_POST,'user',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($user === '' || $user === false ) {
    $errorUser = $errortxt;
    $error = true;
}

if ($password === '' || $password === false) {
    $errorPassword = $errortxt;
    $error = true;
}

if ($user != null && $password != null && $error == false) {
    
        $quereie = 'SELECT USER_NAME, `PASSWORD` FROM USER WHERE USER_NAME = "'.$user.'"';
        
        $result = exeMultiSelect($quereie);

        if (empty($result)) {
            $error = true;
            $errorConnexion = "mot de passe ou nom d'utilisateur  erroné";
        }elseif ($password != $result[0]['PASSWORD']) {
            $error = true;
            $errorConnexion = "mot de passe ou nom d'utilisateur  erroné";
        }

        if (!$error) {
            connect($user, $password);
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
    <title>Connexion</title>
</head>
<body>
    <header>
        <div id="back"><a href="../../index.php"><img src="../../img/flecheGriffeLong.png" alt="fleche de retour"></a></div>
        <h1>Connexion</h1>
    </header>
    <main>
        <span class="error"><small><?= $errorConnexion ?></small></span>
        <form action="#" method="post" id="connectForm">
            <div>
                <label for="user">Nom d'utilisateur</label>
                <span class="error"><?= $errorUser ?></span>
                <input type="text" name="user" id="user" value="<?= $user ?>">
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <span class="error"><?= $errorPassword ?></span>
                <input type="password" name="password" id="password">
            </div>


            <input type="submit" value="Se connecter">
        </form>
        <a href="createAcount.php?first=true">Crée un compte</a>
    </main>
</body>
</html>