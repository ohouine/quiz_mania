<?php

session_start();

require_once '../function.php';

$img = filter_input(INPUT_POST,'img',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$type = filter_input(INPUT_POST,'type',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$value = filter_input(INPUT_POST,'value',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (tokenSname() && $_SESSION['userName'] == 'admin') {

    $statement = cnn()->prepare('SELECT IMG FROM `IMAGE` WHERE IMG = "'.$img.'"');
    $statement->execute();
    $image = $statement -> fetch();

    if ($image === false) {
        $statement = cnn()->prepare('INSERT INTO `IMAGE`(IMG,`TYPE`,`VALUE`) VALUE(:img,:type,:value)');
        $statement->execute([
            ':img' => $img,
            ':type' => $type,
            ':value' => $value,
        ]);
    }else {
        echo 'ya dejas une image de se nom';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>addImage</title>
</head>
<body>
    <main>
        <form action="#" method="post">
            <input type="file" name="img" id="toAddimg" accept="image/png, image/gif, image/jpeg" >
            <select name="type" >
                <option value="profile">icon</option>
                <option value="question">quest</option>
            </select>
            <input type="number" name="value" id="value">
            <input type="submit" value="Enregistrer">
        </form>
    </main>
</body>
</html>

