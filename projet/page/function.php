<?php

function cnn():PDO
{
    static $pdo = null;
    
    if($pdo === null){
        require_once 'const.php';
        $dsn = 'mysql:host='.HOST.';dbname='.NAME.';charset='.CHAR;
        $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, USER,PASSWORD , $options);
    }
    
    return $pdo;
}


// Quizz

//execute a SELECT and return the value 
function exeMultiSelect($querie,$param):array
{
    $statement = cnn()->prepare($querie);
    $statement->execute($param);
    $result = $statement->fetchAll();

    return $result; 
}

function exeSingleSelect($querie,$param):array|false
{
    $statement = cnn()->prepare($querie);
    $statement->execute($param);
    $result = $statement->fetch();

    return $result; 
}

// verifie all reponse of quzz
function verifieAllRep(array $rep):int{
    $score = 0;
    $allGoodRep = exeMultiSelect("SELECT GOODREPONSE FROM QUESTION WHERE TITLE_ID = :id",[':id' => $_SESSION['idQuizz']]);
    foreach ($allGoodRep as $i => $value) {
        $transition = str_replace(' ','',$value['GOODREPONSE']);
        if ($transition == $rep[$i]) {
            $score += 1;
        }
    }
    return $score;
}

// Connexion

//Create Acount

// verifie if a user already exist
function verifieUserExist($user):bool{
        $querie = 'SELECT USER_NAME FROM `USER` WHERE USER_NAME = :user;';
        $result = exeSingleSelect($querie,[':user' => $user]);

        if ($result != false) {
            return true;
        }
        return false;
}
// verifie if a mail already exist
function verifieMailExist($mail):bool{
    $querie = 'SELECT EMAIL FROM `USER` WHERE EMAIL = :mail;';
    $result = exeSingleSelect($querie,[':mail' => $mail]);

    if ($result != false) {
        return true;
    }
    return false;
}
//i think function's name is clear
function addUser($user,$mail,$password):void{
    $querie = 'INSERT INTO `USER`(USER_NAME, EMAIL,`PASSWORD`,TOKEN,`IMAGE`) VALUE(:user,:mail,:pass,:token,:img);';
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':user' => $user,
        ':mail' => $mail,
        ':pass' => $password,
        ':token' => uniqid(true),
        ':img' => 'aloween.png',
    ]);
}

// Connect
// connect a user if succes return true and add tokken and name on SESSION else return false 
function connect($user, $password):void{

    $token = exeSingleSelect('SELECT TOKEN FROM USER WHERE USER_NAME = :user;',[':user' => $user]);

    $_SESSION['token'] = $token['TOKEN'];
    $_SESSION['userName'] = $user;
    
    header('location: ../../index.php');
    die();
}

//modify user's data 
function modifyUser($user,$mail){
    $querie = 'UPDATE `USER` SET USER_NAME = "'.$user.'", EMAIL = "'.$mail.'" WHERE USER_NAME = "'.$_SESSION['userName'].'";';
    $statement = cnn()->prepare($querie);
    $statement->execute();
}

//modify user's data 
function modifyPassword($password){
    $querie = 'UPDATE `USER` SET `PASSWORD` = "'.$password.'" WHERE USER_NAME = "'.$_SESSION['userName'].'";';
    $statement = cnn()->prepare($querie);
    $statement->execute();
    header('location: profil.php');
    die();
}

// User Verfication
//verifie if it's the tokken that match with name
function tokenSname():bool{
    //echo 1;
    if (!array_key_exists('userName', $_SESSION)) {
        return false;
    }

    if ($_SESSION['userName'] == '') {
        return false;
    }

    //echo 2;
    $querie = 'SELECT TOKEN FROM USER WHERE USER_NAME = :user;';

    $result = exeMultiSelect($querie,[':user' => $_SESSION['userName']]);

    if ($result[0]['TOKEN'] != $_SESSION['token']) {
        return false;
    }
    //echo 3;

    return true;
}

//verifie if title already exists
function verifieTitle($title):bool{
    $result = exeMultiSelect('SELECT * FROM TITLE WHERE TITLE = :title ;',[':title' => $title]);

    if ($result != false) {
        return false;
    }

    return true;
}

function getUserImg() {
    if (tokenSname()) {
        $img = exeSingleSelect('SELECT IMG FROM `IMAGE` WHERE IMG = (SELECT `IMAGE` FROM `USER` WHERE USER_NAME = :user)',[':user' => $_SESSION['userName']]);
        return $img['IMG'];
    }
    return 'account.png';
}

function getUserAccount(){
    $result = exeSingleSelect('SELECT ACCOUNT FROM `USER` WHERE USER_NAME = :user; ',[':user' => $_SESSION['userName']]);
    return $result['ACCOUNT'];
}

function headerDiv(){
    if (tokenSname()) {
        return '<div class="accountDiv"> <a href="../../index.php"> <img src="../../img/flecheGriffeLong.png" alt="fleche de retour"> </a> <div> <p>'.getUserAccount().'</p></div></div>';
    }else{
        return '<div> <a href="../../index.php"> <img src="../../img/flecheGriffeLong.png" alt="fleche de retour"> </a></div>';
    }
}

function earnMoney($money){
    $querie = 'UPDATE `USER` SET `ACCOUNT` = `ACCOUNT` + :nb WHERE USER_NAME = :user;';
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':nb' => $money,
        ':user' => $_SESSION['userName'],
    ]);
}

function spendMoney($howMany){
    $querie = 'UPDATE `USER` SET `ACCOUNT` = `ACCOUNT` - :nb WHERE USER_NAME = :user;';
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':nb' => $howMany,
        ':user' => $_SESSION['userName'],
    ]);
}

function quizzDone($quizId){
    $querie = 'INSERT INTO QUIZZ_DONE(DONE_USER_NAME,DONE_QUIZ_ID) VALUE(:userName,:quizId);';
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':quizId' => $quizId,
        ':userName' => $_SESSION['userName'],
    ]);
}

function verifyImg($img){
    $result = exeSingleSelect('SELECT IMG FROM `IMAGE` WHERE IMG = :img;',[':img' => $img]);
    return $result;
}

function earnImage($img){
    $querie = 'INSERT INTO OWN_IMAGE(OWN_USER_NAME,OWN_IMAGE) VALUE(:userName,:img);';
    $statement = cnn()->prepare($querie);
    $statement->execute([
        ':userName' => $_SESSION['userName'] ,
        ':img' => $img,
    ]);
} 