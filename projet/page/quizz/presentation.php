<?php

session_start();

require_once '../function.php';

$title = '';
$userQuiz = '';

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$_SESSION['idQuizz'] = $id;

$title = exeSingleSelect('SELECT TITLE,USER_NAME FROM TITLE  WHERE ID = '.$id.';');

$querie = 'SELECT USER_NAME,`IMAGE` FROM `USER` WHERE USER_NAME = "'.$title['USER_NAME'].'";' ;
$userQuiz = exeSingleSelect($querie);

$img = exeSingleSelect('SELECT IMG FROM `IMAGE` WHERE IMG = "'.$userQuiz['IMAGE'].'";');
?>
<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>the choosen one</title>
</head>
<body id='choosenBody' class="fixBackground">
    <header>
    <?= headerDiv() ?>
    <h1 style="margin-top: 0px;"><?= $title['TITLE']; ?></h1>
    </header>
    <main id="presentation">
        <h1>By <?= $userQuiz['USER_NAME'] ?></h1>
        <img src="../../img/<?= $img['IMG'] ?>" alt="image de profiles">
         <a href="quizzAll.php?id=<?=$id?>&title=<?= $title['TITLE'] ?>"><button>Commencer le quizz</button></a>
    </main>
</body>
</html>
<?php