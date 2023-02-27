<?php
require_once '../function.php';
session_start();

$color = '';

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
        <h2>THEME</h2>
    </header>
    <main class="nobkgr">
        <ul id="ulTheme">
            <?php
            
            $theme = exeMultiSelect('SELECT * FROM THEME;',[]);
            foreach ($theme as $i => $value) {
                
                switch ($theme[$i]['ID']) {
                    case '1':
                        $color = '#1e073e'; 
                        break;
                    
                    case '2':
                        $color = '#2d1787'; 
                        break;    
            
                    case '3':
                        $color = '#2a30e5'; 
                        break;

                    case '4':
                        $color = '#3a59f3'; 
                        break;
                    
                    case '5':
                        $color = '#0ba6bf'; 
                        break;  
                    default:
                        $color = 'grey';
                        break;
                }

                switch ($value['CATEGORY']) {
                    case 'manganime':
                        $value['CATEGORY'] = 'manga et anime';
                        break;

                        case 'other':
                            $value['CATEGORY'] = 'autre';
                            break;
                    
                    default:
                        # code...
                        break;
                }
              echo '<a href="allQuizz.php?id='.$value['ID'].'"><li style="background-color:'.$color.';"> <p class="idQuiz"> '.$value['ID'].'</p> <p class="titre_quizze">'. $value['CATEGORY'].'</p> </li></a>';
            }
        ?>
        </ul>
        
    </main> 
    
</body>
</html>