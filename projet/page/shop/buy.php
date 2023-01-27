<?php

session_start();
require_once '../function.php';
if (!tokenSname()){header('location:../../index.php?alert=vous deez etre connectez pour accéder a cet page'); die();}

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

if (!$id) { header("location:../../index.php?alert=une erreur c'est produite avec l'id");  die();}
if(verifyImgId($id) == false) {header("location:../../index.php?alert=une erreur c'est produite avec l'id");  die();}

$userId = exeSingleSelect('SELECT ID,ACCOUNT FROM `USER` WHERE USER_NAME = "'.$_SESSION['userName'].'"');

$image = exeSingleSelect('SELECT ID,IMG,`VALUE` FROM `IMAGE` WHERE ID = '.$id.';');

if ($image['VALUE'] > $userId['ACCOUNT']) {
    header('location:shop.php?alert=vous ne posseder pas assez de KriegerHands');
    die();
}

if (exeSingleSelect('SELECT * FROM OWN_IMAGE WHERE OWN_IMAGE_ID	=  '.$image['ID'].' AND OWN_USER_ID = '.$userId['ID'].';') != false) {
    header('location:shop.php');
    die();
}

$toBuy = filter_input(INPUT_POST,'toBuy');

var_dump($toBuy);
if ($toBuy != null) {
    spendMoney($image['VALUE']);
    earnImage($userId['ID'],$id);
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
            <input type="hidden" name="toBuy" value="kevin le bg">

        <input type="submit" value="acheter pour <?= $image['VALUE'] ?>">
        </form>
    </main>
</body>
</html>