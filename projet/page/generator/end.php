<!--indexDiv modoux
     envoie les donnees a la base de donnees -->

<?php

session_start();

include_once '../function.php';
require_once '../const.php';

if (!tokenSname()) {
    header('location: canceling.php');
   die();
}
    
    $statement = '';

    if (!array_key_exists('quizzGen',$_SESSION)) {
        header('location:../../index.php?alert=une c est produite durant la generation de votre quizz');
        die();
    }

if(!verifieTitle($_SESSION['quizzGen'][0]['title'])){
  header('location: canceling.php');
  die();
}

if ( !is_null($_SESSION['quizzGen'][3]) && !is_null($_SESSION['quizzGen'][2]) && !is_null($_SESSION['quizzGen'][1]) && !is_null($_SESSION['quizzGen'][0])) {
    
    $nbQuest = count($_SESSION["quizzGen"]) - 3;
    $value = ceil($nbQuest * ($nbQuest * 0.5) * 10);
    if ($value > 300) $value = 300;

    $arrayTitleId = '';
    $querrytitle = 'INSERT INTO TITLE(TITLE, DIFFICULT,ID_THEME,USER_NAME,`VALUE`) VALUE(:title,:dif,(SELECT ID FROM `THEME` WHERE CATEGORY = :cat),:userName,:account);';
    $querieTitleId = 'SELECT MAX(ID) AS"ID_MAX" FROM TITLE';

    $statement = cnn()->prepare($querrytitle);
    $statement->execute([
        ':title' => $_SESSION['quizzGen'][0]['title'],
        ':dif' => $_SESSION['quizzGen'][1]['difficult'],
        ':cat' => $_SESSION['quizzGen'][2]['theme'],
        ':userName' => $_SESSION['userName'],
        ':account' => $value,
    ]);

    $arrayTitleId = exeMultiSelect($querieTitleId,[]);
    $titleID = $arrayTitleId[0]['ID_MAX'];

    array_shift($_SESSION['quizzGen']);
    array_shift($_SESSION['quizzGen']);
    array_shift($_SESSION['quizzGen']);
    
    foreach ($_SESSION['quizzGen'] as $i => $value) {
        $question_querry = 'INSERT INTO QUESTION(QUESTION,REP1,REP2,REP3,GOODREPONSE,TITLE_ID) VALUE("'.$value['question'].'","'.$value['rep1'].'","'.$value['rep2'].'","'.$value['rep3'].'","'.$value['goodReponse'].'","'.$titleID.'")' ;
        $statement = cnn()->prepare($question_querry);
       $statement->execute();
    } 
  header('location: canceling.php');
  die();
}else {
    header('location: allQuest.php?mess=Veuillez créer au moins une question');
}
