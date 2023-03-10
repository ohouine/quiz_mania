<?php
session_start();

require_once '../function.php';

if (!tokenSname()){
    header('location:../../index.php?alert=vous devez etre connecter');
    die();
}
$img = exeSingleSelect('SELECT IMG FROM `IMAGE` WHERE IMG = (SELECT `IMAGE` FROM `USER` WHERE USER_NAME = :user);',[':user' => $_SESSION['userName']]);

$ownedImage = exeMultiSelect('SELECT OWN_IMAGE FROM OWN_IMAGE WHERE OWN_USER_NAME = :own;',[':own' => $_SESSION['userName']]);

if ($_SESSION['userName'] == 'admin') {
    echo '<a href="../admin/addImage.php">add image</a>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Profile</title>
</head>
<body>
    <header>
    <div> <a href="../../index.php"> <img src="../../img/flecheGriffeLong.png" alt="fleche de retour"> </a> </div>
    <h1 style="margin-top: 0px;">Profile</h1>
    </header>
    
    <main id="userImage_main">
        <h2><?= $_SESSION['userName'] ?></h2>

        <div id="userImage_div">
            <div id="clickable">
                <img src="../../img/<?= $img['IMG']?>" alt="image de profil" id="profilPhoto">      
                <img src="../../img/addPhoto.png" alt="modifier image de profil" id="addPhoto">
            </div>
            
            <div id="hiddenImageDiv" class="divImg">
                <div id="crossDiv"><div id='cross'></div></div> 
                <?php
                    foreach ($ownedImage as $i => $value) {
                        $imgType = exeSingleSelect('SELECT `TYPE` FROM  `IMAGE` WHERE IMG = :img',[':img' => $value['OWN_IMAGE']]);

                        if ($imgType['TYPE'] == 'icone') {
                            
                            echo '<a href="changePhoto.php?img='.$value['OWN_IMAGE'].'"><img src="../../img/'.$value['OWN_IMAGE'].'" alt="image de profil"></a>';
                        }
                    }
                ?>
            </div>
        </div>
        <a href="modifyProfile.php" id="changeProfile">Modifier profil</a>
        <a href="../connexion/deconexion.php" class="profileLink">se deconnecter</a>
        <a href="quiz/allMyQuiz.php" class="profileLink">tous mes quizzes</a>
    </main>
    <script src="../../js/hiddenImage.js"></script>
</body>
</html>