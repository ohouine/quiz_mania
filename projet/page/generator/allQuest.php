<!-- indexDiv modoux
creation des question pour implementatation de celle ci dans labase de donnees
!!! permission de cree de question plus long que recommander volantaire -->
<?php   

        session_start();

        try {
            require '../function.php';
        } catch (\Throwable $th) {
            header('location: ../../index.php');
        }

        $error = 'veuillez remplire ce champ corretement';
        $questionErrtxt = '';
        $rep1Errtxt = '';
        $rep2Errtxt = '';
        $rep3Errtxt = '';
        $goodReponseErrtxt = '';

        $questionErr = false;
        $rep1Err = false;
        $rep2Err = false;
        $rep3Err = false;
        $goodReponseErr = false;
        $jsonQuest = false;

        $questionValue = '';
        $rep1Value = '';
        $rep2Value = '';
        $rep3Value = '';

        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $difficult = filter_input(INPUT_POST,'difficult',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $theme = filter_input(INPUT_POST,'theme',FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (empty($_SESSION['quizzGen'])) {
            
            if ($title === null || $title === '' || strlen($title) > 15){
            header("location: generator.php"); 
            die();
            }else {
			  if(verifieTitle($title)){
                $arrayTitle = ['title' => $title];
				array_push($_SESSION['quizzGen'],$arrayTitle);
			  }else{
			   header("location: generator.php?mess='Ce titre de quiz exist dejas'"); 
			  }
            }
        
           if ($difficult != 'easy' && $difficult != 'not_that_easy' && $difficult != 'feasible' && $difficult != 'hard' && $difficult != 'epique' ) {
               $diff = ['difficult' => 'strange'];
              array_push($_SESSION['quizzGen'],$diff);
           }else {
                $diff = ['difficult' => $difficult];
                array_push($_SESSION['quizzGen'],$diff);
            }

            if ($theme != 'manganime' && $theme != 'serie' && $theme != 'sport' && $theme != 'informatique' && $theme != 'other' ) {
                $arrayTheme = ['theme' => 'other'];
               array_push($_SESSION['quizzGen'],$arrayTheme);
            }else {
                 $arrayTheme = ['theme' => $theme];
                 array_push($_SESSION['quizzGen'],$arrayTheme);
             }

        }
        
        $question = filter_input(INPUT_POST,'quest',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reponse = [
        'rep1' => filter_input(INPUT_POST,'rep1',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'rep2' => filter_input(INPUT_POST,'rep2',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'rep3' => filter_input(INPUT_POST,'rep3',FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ];
        $goodRep = filter_input(INPUT_POST,'goodReponse',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $noQuest = filter_input(INPUT_GET,'mess',FILTER_SANITIZE_SPECIAL_CHARS);
        
        if ( isset($jsonArray[3])) $noQuest = '';
       
            if (isset($question) && (trim($question," ") === '' || $question === '' || $question === false)) { if($question != null && strlen($question) > 40){ $questionErrtxt = $error; $questionErr = true;}}
            

            foreach ($reponse as $i => $value) {
                if ($value === false || $value === '' || $value != null && strlen($value) > 15) {
                switch ($i) {
                    case 'rep1':
                        $rep1Errtxt = $error; $rep1Err = true;
                        break;
                    
                    case 'rep2':
                        $rep2Errtxt = $error; $rep2Err = true;
                        break;

                    case 'rep3':
                        $rep3Errtxt = $error; $rep3Err = true;
                        break;
                }}
            }

        switch ($goodRep) {
            case 'rep1':
                $goodRep = $reponse['rep1'];
                break;

            case 'rep2':
                $goodRep = $reponse['rep2'];
                break;
            
            case 'rep3':
                $goodRep = $reponse['rep3'];
                break;

            default:
                $goodReponseErr = true;
                break;
        }
        if (isset($goodRep) === true &&  ($goodRep === false || $goodReponseErr === true)) $goodReponseErrtxt = $error; 


        if ($questionErr == false && $rep1Err === false && $rep2Err == false && $rep3Err == false  && $goodReponseErr == false) {
            $jsonQuest = [
                'question'=>$question,
                'rep1' => $reponse['rep1'],
                'rep2' => $reponse['rep2'],
                'rep3' => $reponse['rep3'],
                'goodReponse' => $goodRep
            ];

            array_push($_SESSION['quizzGen'],$jsonQuest);
        }else {
            if(!$questionErr) $questionValue = $question;
            if(!$rep1Err) $rep1Value = $reponse['rep1'];
            if(!$rep2Err) $rep2Value = $reponse['rep2'];
            if(!$rep3Err) $rep3Value = $reponse['rep3'];
        }
    ?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Document</title>
</head>
<body id="body_allQ">
    <header id="gen_header">
        <div> <a href="canceling.php"> <img src="../../img/flecheGriffeLong.png" alt="fleche de retour"> </a> </div>
       <h1>Quizz generator</h1>
       
    </header>

    <main>
        <span class="error"><?= $noQuest; ?></span>
        <form action="#" method="post" id="all_quest">
        <ul>
                <li>
                    <label for="quest">Question <small>(35 max)</small></label>
                    <span  class="error"><?= $questionErrtxt ?></span>
                    <input type="text" name="quest" maxlength="35" value="<?= $questionValue ?>">
                </li>
                <li>
                    <label for="rep1">Reponse n°1 <small>(13 max)</small></label>
                    <span  class="error"><?= $rep1Errtxt ?></span>
                    <input type="text" name="rep1" id="rep1" maxlength="13" value="<?= $rep1Value ?>">
                </li>
                <li>                    
                    <label for="rep2">Reponse n°2 <small>(13 max)</small></label>
                    <span  class="error"><?= $rep2Errtxt ?></span>
                    <input type="text" name="rep2" id="rep2" maxlength="13" value="<?= $rep2Value ?>">
                </li>
                <li>
                        <label for="rep3">Reponse n°3 <small>(13 max)</small></label>
                        <span  class="error"><?= $rep3Errtxt ?></span>
                        <input type="text" name="rep3" id="rep3" maxlength="13" value="<?= $rep3Value ?>">
                        </li>
                <li>
                    <label for="goodReponse">Bonne reponse</label>
                    <span  class="error"><?= $goodReponseErrtxt ?></span>
                    <select name="goodReponse" id="goodReponse">
                        <option value="rep1">Reponse n°1</option>
                        <option value="rep2">Reponse n°2</option>
                        <option value="rep3">Reponse n°3</option>
                    </select>
                </li>
            </ul>
            <input type="submit" value="Enregistrer la question">
        </form>

        <a href="end.php" id="end">J'ai fini</a>
    </main>

</main>
</body>
</html>