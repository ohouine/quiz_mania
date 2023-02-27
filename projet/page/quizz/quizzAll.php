<?php

session_start();

require_once '../function.php';

$reponse = '';
$title = '';

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$title = filter_input(INPUT_GET,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$_SESSION['idQuizz'] = $id;

$querie = 'SELECT QUESTION,REP1,REP2,REP3,TITLE_ID FROM QUESTION WHERE TITLE_ID = :id;';
$allQuest = exeMultiSelect($querie,[':id' => $id]);
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
    <header  class="fullHeader">
    <?= headerDiv() ?>
    <h2><?= $title; ?></h2>
    </header>
    <main id="choosenMain">
        <form action="score.php" method="post" id="choosenForm">
            <?php

            foreach ($allQuest as $i => $value) {

                echo 
                "<div class='questionDiv'>
                    <h3> ".$allQuest[$i]['QUESTION']."</h3>
                    <span class='error'></span>
                    <div classe='repDiv'>
                        <div class='rep'> ".$allQuest[$i]['REP1']." </div>
                        <div class='rep'> ".$allQuest[$i]['REP2']." </div>
                        <div class='rep'> ".$allQuest[$i]['REP3']." </div>
                    </div>
                    <input type='hidden' name='reponse".$i."' class='inputReponse' value=''>
                </div> ";
            }
            ?>
            <input type="hidden" name="title" value="<?= $title ?>">
        
        <button class="button-85" role="button" id="sub">Verifier</button>
        
        </form>
        
    </main>
</body>
<script type="" src="../../js/quizzAll.js"></script>
</html>
<?php