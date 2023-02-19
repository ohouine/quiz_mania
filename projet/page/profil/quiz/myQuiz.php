<?php

session_start();

require_once '../../function.php';

$title = filter_input(INPUT_GET,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$querie = 'SELECT * FROM QUESTION WHERE TITLE_ID = (SELECT ID FROM TITLE WHERE TITLE = :title);';
$allQuest = exeMultiSelect($querie,[':title' => $title]);
?>
<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/style.css">
    <title>the choosen one</title>
</head>
<body id='choosenBody' class="fixBackground">
    <header>
    <div class="accountDiv"> <a href="../../../index.php"> <img src="../../../img/flecheGriffeLong.png" alt="fleche de retour"> </a> <div> <p><?= getUserAccount() ?></p></div></div>
    
    </header>
    <main id="choosenMain">
        <form action="modify.php" method="post" id="choosenForm">
            
        <span class="error"><?= filter_input(INPUT_GET,'errTitle',FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></span>
        <div class='questionDiv'><h2><input type='text' name='newTitle' value='<?= $title; ?>' </h2></div>
            <?php
            $color1;
            $color2;
            $color3;
            foreach ($allQuest as $i => $value) {
                $color1 = 'rgb(37, 37, 37)';
                $color2 = 'rgb(37, 37, 37)';
                $color3 = 'rgb(37, 37, 37)';
                
                $color1 = ($allQuest[$i]['REP1'] === $value['GOODREPONSE']) ? 'black' : 'rgb(37, 37, 37)' ;
                $color2 = ($allQuest[$i]['REP2'] === $value['GOODREPONSE']) ? 'black' : 'rgb(37, 37, 37)' ;
                $color3 = ($allQuest[$i]['REP3'] === $value['GOODREPONSE']) ? 'black' : 'rgb(37, 37, 37)' ;

                switch ($value['GOODREPONSE']) {
                    case $allQuest[$i]['REP1']:
                        $inptReponse = 'reponse1';
                        break;

                    case $allQuest[$i]['REP2']:
                        $inptReponse = 'reponse2';
                        break;

                    case $allQuest[$i]['REP3']:
                        $inptReponse = 'reponse3';
                            break;

                    default:
                        $inptReponse = 'reponse1';
                        break;
                }
                echo 
                "<div class='questionDiv'>

                    <input type='text' name='question".$i."' value='".$allQuest[$i]['QUESTION']."'>
                    <span class='error'></span>

                    <div classe='repDiv'>

                        <input type='text' name='reponse1".$i."' value='".$allQuest[$i]['REP1']."'>
                        <input type='text' name='reponse2".$i."' value='".$allQuest[$i]['REP2']."'>
                        <input type='text' name='reponse3".$i."' value='".$allQuest[$i]['REP3']."'>
                        
                        <div><p>bonne reponse : </p></div>

                        <div id='newRep' class='rep' style='background-color: ". $color1 ." ;'>reponse1</div>
                        <div id='newRep' class='rep' style='background-color: ". $color2 ." ;'>reponse2</div>
                        <div id='newRep' class='rep' style='background-color: ". $color3 ." ;'>reponse3</div>
                        

                        <input type='hidden' name='goodRp".$i."' class='inputReponse' value=".$inptReponse.">
                    </div>

                </div> ";
            }
            ?>
            <input type="hidden" name="oldTitle" value="<?= $title ?>">
        
        <div><button class="button-85" role="button" id="sub">Modifier</button></div>
        
        </form>
    </main>
</body>
<script type="" src="../../../js/quizzAll.js"></script>
</html>
<?php