
<?php
require_once '../function.php';
session_start();
$_SESSION['index'] = 0;
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

$allTitle = exeMultiSelect('SELECT * FROM TITLE  WHERE USER_NAME = :id;',[':id' => $id]);

if ($allTitle === false || $theme === false ) {
    header("location:../../index.php? alert= oops une erreur viens de se produire id potentiellement out of range");
    die();
}

$color = '';
$adminOnly =false;

if (TokenSname() && $_SESSION['userName'] == 'admin') {
    $adminOnly =true;  
} 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>choose one</title>
</head>
<body id='allQuizz_body' class="fixBackground">
    <header>
        <?= headerDiv() ?>
        <h2><?= strtoupper($theme['CATEGORY']) ?></h2>
    </header>
    <main class="nobkgr">
        <ul id="allQuizzUl">
            <?php
            $quizzValue =  '<img src="../../img/medaille1.png" alt="">';

            foreach ($allTitle as $i => $value) {
                $diff = exeMultiSelect('SELECT DIFFICULT FROM TITLE WHERE ID =:id ;',[':id' => $value['ID']]);
                switch ($diff[0]['DIFFICULT']) {
                    case 'easy':
                        $color = '#17bf0b'; 
                        break;
                    
                    case 'not_that_easy':
                        $color = '#1a381a'; 
                        break;    
            
                    case 'feasible':
                        $color = '#814e03'; 
                        break;

                    case 'hard':
                        $color = '#6b1f05'; 
                        break;
                    
                    case 'epique':
                        $color = '#4b0868'; 
                        break;    
                
                    case 'strange':
                        $color = '#940d67'; 
                        break;
                    default:
                        $color = 'grey';
                        break;
                }
                $i += 1;

                if (exeSingleSelect('SELECT * FROM QUIZZ_DONE WHERE DONE_USER_NAME = :user AND DONE_QUIZ_ID = :id;',[':user' => $_SESSION['userName'], ':id' => $id]) == false) {

                    $quizzValue = $value['VALUE'];
                }else { $quizzValue =  '<img src="../../img/medaille1.png" alt="">';}

                echo '<a href="presentation.php?id='.$value['ID'].'"><li style="background-color:'.$color.';"> <p class="idQuiz"> '.$i.'</p> <p class="titre_quizze">'. $value['TITLE'].'</p> <div>'.$quizzValue.'</div> </li></a>';
                
                if ($adminOnly){
                    $isIt = 'block';
                    
                    $certi = exeSingleSelect('SELECT CERTIFY FROM TITLE WHERE ID = :id;',[':id' => $value['ID']]);

                    if($certi['CERTIFY']) $isIt = 'none';

                    echo '<li><a href="../admin/certified.php?id='.$value["ID"].'&theme='.$id.'" style="display:'.$isIt.';">certified</a> <a href="../admin/deleteQuiz.php?id='.$value["ID"].'&theme='.$id.'">suprimer</a></li>';

                }
                    
            }
        ?>
        </ul>
        
    </main> 
    
</body>
</html>