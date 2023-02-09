<?php
session_start();

require_once '../function.php';

$arrayReponse = [];
$transitionString ='';
$message = '';
$score = 0;
$color = 'red';

foreach ($_POST as $i => $value) {
    $transitionString = str_replace(' ','',$value);
    array_push($arrayReponse, $transitionString);
}

$title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$score = verifieAllRep($arrayReponse);
$maxScore = exeSingleSelect('SELECT COUNT(GOODREPONSE)AS"max" FROM QUESTION WHERE TITLE_ID = :id ;',[':id' => $_SESSION['idQuizz']]);


if (tokenSname() && $score === $maxScore['max']) {

    $quizId = exeSingleSelect('SELECT ID FROM TITLE WHERE TITLE = :title;',[':title' => $title]);
    
    if (exeSingleSelect('SELECT * FROM QUIZZ_DONE WHERE DONE_USER_NAME = "'.$_SESSION['userName'].'" AND DONE_QUIZ_ID = '.$quizId['ID'].';') == false) {

        $earn = exeSingleSelect('SELECT `VALUE` FROM TITLE WHERE TITLE = "'.$title.'";');
        earnMoney($earn['VALUE']);
        $message = '+'.$earn['VALUE'];
        quizzDone($quizId['ID']);

    }
}

$diviseur = $maxScore['max'] / 3;

switch ($score) {

    case 0 :
        $color = 'red';
        break;

        case $score <= $diviseur:
            $color = 'red';
            break;
        
            case $score > $diviseur && $score <= $diviseur * 2 : 
                $color = 'orange';
                break;  

                case $score > $diviseur * 2:
                    $color = 'green';
                    break;  

    default:
        $color = 'purple';
        break;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Resultat</title>
</head>
<body id="bodyScore">
    <header>
    <?= headerDiv() ?>
    <h2><?= $title ?></h2>
    </header>

    <main>
	  <?=$message ?>
        <h1 id="score" style="background-color : <?= $color ?>;"><?= $score."/".$maxScore['max']?></h1>
        <div>
            <a href="quizzAll.php?id=<?= $_SESSION['idQuizz'] ?>" class="resultLink">Recommencer</a>
            <a href="theme.php" class="resultLink">Faire un autre quizz</a>
        </div>
</body>
</html>