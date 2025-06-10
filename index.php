<?php
include_once("library.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>chat</h1>
    <div>
        <div>
            <?php
/* inserting into message table */

if(isset($_POST['submitTxt'])){
    $inputMessage = $_POST['message'];

    /*$findUserID = $connection->prepare('select userID from users where username = ?');
    $findUserID->bind_param('s' , $_SESSION['username']);
    $findUserID->execute();
    $result = $findUserID->get_result();
    $userID = $result->fetch_assoc();
*/
    
    $insertInputs = $connection->prepare('insert into message(txt, sentByUserID) values (?,(select userID from users where username = ?))');
    $insertInputs->bind_param('ss', $inputMessage, $_SESSION['username']);
    $insertInputs->execute();
}

            $bringMessages = $connection->prepare('select * from message');
            $bringMessages->execute();
            $result = $bringMessages->get_result();
            while($row=$result->fetch_assoc()){
                $senderID = $row['sentByUserID'];
                $findUsername = $connection->prepare('select username from users where userID = ? ');
                $findUsername->bind_param('s' , $senderID);
                $findUsername->execute();
                $result = $findUsername->get_result();
                $senderName = $result->fetch_assoc();
                
                $message = $row['txt'];
                ?>
<?=$senderName?> : <?=$message?> 
                <?php
            }
            ?>
        </div>
        <div>
            <form method="post">
                <input type="text" name="message" placeholder = "text here">
                <input type="submit" name="submitTxt">
            </form>
        </div>
    </div>
</body>
</html>