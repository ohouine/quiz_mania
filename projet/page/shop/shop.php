<?php

session_start();
require_once '../function.php';

if (!tokenSname()) header('location:../../index.php?alert=vous deez etre connectez pour accéder a cet page');
$icone = exeMultiSelect('SELECT IMG,`VALUE` FROM `IMAGE` WHERE `TYPE` = "icone" ORDER BY `VALUE`');

$userAccount = exeSingleSelect('SELECT ACCOUNT FROM `USER` WHERE USER_NAME = "'.$_SESSION['userName'].'"');
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
        <h1>Magasin</h1>
    </header>

    <main id="shopMain">
        <h1>icone</h1>

        <div id="icone" class="divImg">
            <?php

                foreach ($icone as $i => $value) {
                    $price = $value['VALUE'];
                    $color = 'white';
                    

                    
                    if (exeSingleSelect('SELECT * FROM OWN_IMAGE WHERE OWN_IMAGE="'.$value['IMG'].'" AND OWN_USER_NAME = "'.$_SESSION['userName'].'";') != false) $price = 'acheté';
                    elseif ($price > $userAccount['ACCOUNT']) {
                         $color = 'red';
                    }

                    echo '<a href="buy.php?img='.$value['IMG'].'"><img src="../../img/'.$value['IMG'].'" alt="image de profil"> <p class="price" style="color:'.$color.';">'.$price.'</p></a>';
                }

            ?>
        </div>

        <h1>image de quizz</h1>
    </main>
</body>
</html>