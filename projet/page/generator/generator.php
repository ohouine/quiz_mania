<!-- 
    Dayan modoux
    genere dinamiquement un quizz en fonction du formulaire saisie
 -->
 <!DOCTYPE html>

<?php

session_start();

$_SESSION['quizzGen'] = [];


require_once '../function.php';



$dont_show_error = filter_input(INPUT_GET,'dse',FILTER_VALIDATE_BOOLEAN);
$error = 'veuillez remplire ce champ corretement';
$title = filter_input(INPUT_GET,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mess = filter_input(INPUT_GET,'mess',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$titleError;
$titleErrorTxt = '';
if ($title === null || $title === '') {$titleError = false;} else {$titleError = true;}


if ($titleError == false && $dont_show_error == false && $mess == null) $titleErrorTxt = $error;
if($mess != null) $titleErrorTxt = $mess;
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Document</title>
</head>
<body id="body_title">
    <header id="gen_header">
        <div> <a href="../../index.php"> <img src="../../img/flecheGriffeLong.png" alt="fleche de retour"> </a> </div>
       <h1>Quizz generator</h1>
    </header>

    <main>
        <form action="allQuest.php" method="post" id="title">
           <div> <h3>Quel est le titre de votre quizz ? </h3> <p>30 max</p> </div>
           <span  class="error"><?= $titleErrorTxt ?></span>
            <input type="text" name="title" id="title" maxlength="30">
            
            <label for="difficult">difficulté</label>
            <select name="difficult" id="difficult">
                <option value="easy">easy</option>
                <option value="not_that_easy">pas tros easy</option>
                <option value="feasible">faisable</option>
                <option value="hard">hard</option>
                <option value="epique">epique</option>
            </select>

            <label for="theme">théme</label>
            <select name="theme" id="theme">
                <option value="manganime">manga et anime</option>
                <option value="serie">series</option>
                <option value="sport">sport</option>
                <option value="informatique">informatique</option>
                <option value="other">autre</option>
            </select>

            <input type="submit" value="Commencer la creeation" id="start">
        </form>
    </main>
</body>
</html>