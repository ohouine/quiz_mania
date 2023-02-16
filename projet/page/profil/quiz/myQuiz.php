<?php

session_start();

require_once '../../function.php';

$title = filter_input(INPUT_GET,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

$querie = 'SELECT QUESTION,REP1,REP2,REP3,TITLE_ID FROM QUESTION WHERE TITLE_ID = :id;';
$allQuest = exeMultiSelect($querie,[':id' => $id]);
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
    <div class="accountDiv"> <a href="../../index.php"> <img src="../../../img/flecheGriffeLong.png" alt="fleche de retour"> </a> <div> <p><?= getUserAccount() ?></p></div></div>
    
    </header>
    <main id="choosenMain">
        <form action="modify.php" method="post" id="choosenForm">
            
        <h2><?= "<input type='text' name='newTitle' value=".$title." "; ?></h2>
            <?php

            foreach ($allQuest as $i => $value) {

                echo 
                "<div class='questionDiv'>
                <input type='text' name='question".$i."' value=".$allQuest[$i]['QUESTION'].">
                    <span class='error'></span>
                    <div classe='repDiv'>
                        <input type='text' name='reponse1".$i."' value=".$allQuest[$i]['REP1'].">
                        <input type='text' name='reponse2".$i."' value=".$allQuest[$i]['REP2'].">
                        <input type='text' name='reponse3".$i."' value=".$allQuest[$i]['REP3'].">
                    </div>
                </div> ";
            }
            ?>
            <input type="hidden" name="title" value="<?= $title ?>">
        
        <button class="button-85" role="button" id="sub">Modifier</button>
        
        </form>
    </main>
</body>
<script type="" src="../../js/quizzAll.js"></script>
</html>
<?php