<?php

session_start();
require_once '../function.php';
if (!tokenSname()){header('location:../../index.php?alert=vous deez etre connectez pour accéder a cet page'); die();}

$imgName = filter_input(INPUT_GET,'img',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$imgName) { header("location:../../index.php?alert=une erreur c'est produite avec l'id");  die();}
if(verifyImg($imgName) == false) { echo "sdfds";/*header("location:../../index.php?alert=une erreur c est produite avec l id");  die();*/}

$userAccount = exeSingleSelect('SELECT ACCOUNT FROM `USER` WHERE USER_NAME = :user',[':user' => $_SESSION['userName']]);

$image = exeSingleSelect('SELECT IMG,`VALUE` FROM `IMAGE` WHERE IMG = :img ;',[':img' => $imgName]);

if ($image['VALUE'] > $userAccount['ACCOUNT']) {
    header('location:shop.php?alert=vous ne posseder pas assez de KriegerHands');
    die();
}

if (exeSingleSelect('SELECT * FROM OWN_IMAGE WHERE OWN_IMAGE =  :img AND OWN_USER_NAME = :user ;',[':img' => $image['IMG'], ':user' => $_SESSION['userName']]) != false) {
    header('location:shop.php');
    die();
}

$toBuy = filter_input(INPUT_POST,'toBuy');

if ($toBuy != null) {
    spendMoney($image['VALUE']);
    earnImage($imgName);
    header('location:shop.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Shop</title>
</head>
<body class="fixBackground">
    <header>
        <?= headerDiv()?>
        <h2>Acheter</h2>
    </header>

    <main>

    <h2><?= $image['VALUE'] ?></h2>

        <div id="toByDiv">
            
            <img src="../../img/<?= $image['IMG'] ?>" alt="image a acheter">

        </div>
        <form action="#" method="post">
            <input type="hidden" name="toBuy" value="kevin le plus gros bg de la tere">

        <input type="submit" value="acheter pour <?= $image['VALUE'] ?>">
        </form>
    </main>
</body>
</html>