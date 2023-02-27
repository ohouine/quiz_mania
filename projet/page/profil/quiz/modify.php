<?php
session_start();
require_once '../../function.php';

if (!tokenSname()) {
    die();
}

//filter input batard
    $oldTitle = $_SESSION['modifyOldTitle'];
    $newTitle = filter_input(INPUT_POST,'newTitle',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$isMine = exeSingleSelect('SELECT ID FROM TITLE WHERE TITLE = :title AND USER_NAME = :userName',[':title' => $_SESSION['modifyOldTitle'], ':userName' => $_SESSION['userName']]);
if (!$isMine) {
    header('location:../../../index.php?alert=ohh mon dieux vous etes degoutant cela ne se fait pas de toucher aux quiz d un autre homme');
    die();
}
$alreadyExists = exeSingleSelect('SELECT ID FROM TITLE WHERE TITLE = :title AND ID != :id',[':title' => $_SESSION['modifyOldTitle'], ':id' => $_SESSION['modifyId']]);
if($alreadyExists != false){
        header('location:myQuiz.php?title='.$_SESSION['modifyOldTitle'].'&errTitle=ce titre exists dejas');
        die();
}
try {

    
    $questionId = exeMultiSelect("SELECT ID FROM QUESTION WHERE TITLE_ID = (SELECT ID FROM TITLE WHERE TITLE = :title)",[':title' => $oldTitle]);
    
    $querie = "UPDATE TITLE SET TITLE = :newTitle WHERE TITLE = :oldTitle ";
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':newTitle' => $newTitle,
        ':oldTitle' => $oldTitle,
    ]);

} catch (\Throwable $th) {
    header('location:myQuiz.php?title='.$newTitle.'&errTitle=une erruer c&acuteest produite avec le titre');
    die();
}

unset($_POST['oldTitle']);
unset($_POST['newTitle']);

$dividedArray = array_chunk($_POST,5);

$newGoodRep;
foreach ($dividedArray as $i => $value) {

   try {
        switch ($value[4]) {
            case 'reponse1':
                $newGoodRep = $value[1];
                break;
            
            case 'reponse2':
                $newGoodRep = $value[2];
                break;
            
            case 'reponse3':
                $newGoodRep = $value[3];
                break;

            default:
            $newGoodRep = $value[1];
                break;
        }

        $querie = "UPDATE QUESTION SET QUESTION = :newQuestion,
        REP1 = :newRep1,
        REP2 = :newRep2,
        REP3 = :newRep3,
        GOODREPONSE = :newGoodRep
        WHERE ID = :id ";
        $statement = cnn()->prepare($querie);
        $statement->execute([
            ':newQuestion' => $value[0],
            'newRep1' => $value[1],
            'newRep2' => $value[2],
            'newRep3' => $value[3],
            ':newGoodRep' => $newGoodRep,
            ':id' => $questionId[$i]['ID'],
        ]);
    } catch (\Throwable $th) {
    header('location:myQuiz.php?title='.$newTitle.'&errTitle=une erruer c&acuteest produite');
    die();
   }

    
    
}

header('location:allMyQuiz.php');
die();