<!-- Dayan Modoux
projet personnel de presentation de sois même
 -->

<?php
require_once 'page/function.php';
$generatorLink = '#';
$generatorLinkShop = '#';
session_start();

$cadenas = 'block';
$user = '<a href="page/connexion/connexion.php" id="connect">Se connecter</a>';

$alert = filter_input(INPUT_GET,'alert',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (tokenSname()) {
    $cadenas = 'none';
    $generatorLink = 'page/generator/generator.php?dse=true';
    $generatorLinkShop  = 'page/shop/shop.php';
    $user = '<a href="page/profil/profil.php"> <img src="img/'.getUserImg().'" alt="image de compte" id="userimg"> </a>';
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Quizzes mania</title>
</head>

<body id="indexBody" class="fixBackground">

<header id="indexheader">
    <div><?= $user ?></div>
    <h1>Quizzes mania</h1>
</header>   
<!-- 
    La ssession est changer quand on cree un compte mais pas mise a jour dans l'index
-->
<main class="nobkgr" >
    <div id="indexDiv"> 
            
        <a href="page/quizz/theme.php" class="btnQuizz"><div><h2>Faire un quiz</h2></div></a> 
        <a href="<?= $generatorLink ?>" class="btnQuizz"><div id="genQuiz"><h2>Générer un quiz</h2> <img src="img/cadenas.png" alt="image de cadenas" style="display : <?= $cadenas?> " id="cadenas"></div> </a>
        <a href="<?= $generatorLinkShop ?>" class="btnQuizz"><div id="shop"><h2>Boutique</h2> <img src="img/cadenas.png" alt="image de cadenas" style="display : <?= $cadenas?> " id="cadenas"> </div></a>

     <div class="ddiv">
            <h2>Régle du jeux</h2>
            <img src="img/vers-le-bas.png" alt="fleche de : &quot Anas Mannaa &quot" class="imgFleche">
        </div>
            <section class="ddivContent">                
                <p>Ce bouton n'auras de scence qu'une fois le systéme d'argent implémeté</p>
            </section>

    </div> 
    
</main>

<footer id="indexFoot">
    <p>By Houine Kyouma from collectif merguez &#169;</p>
    <a href="page/citation.html">Références</a>
</footer>


<script src="js/script.js"></script>

<?php

if ($alert != null) {
    echo'<script>
    alert("'.$alert.'")
    </script>';
}
?>
</body>

</html>