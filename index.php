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
    <h1>World wide chat</h1>
    <div>
        <div>
            <?php
            if (isset($_POST['logout'])) {
                session_unset();
                session_destroy();
            }

            /* LOGIN  */
            if (isset($_POST['login'])) {
                header("location: login.php");
            }

            /* inserting into message table */

            if (isset($_POST['submitTxt'])) {
                $inputMessage = $_POST['message'];

                $insertInputs = $connection->prepare('insert into message(txt, sentByUserID) values (?,(select userID from users where username = ?))');
                $insertInputs->bind_param('ss', $inputMessage, $_SESSION['username']);
                $insertInputs->execute();
            }
            if ($_SESSION["userLogin"] == true) {

                $bringMessages = $connection->prepare('select * from message order by messageID');
                $bringMessages->execute();
                $messageResult  = $bringMessages->get_result();
                while ($row = $messageResult->fetch_assoc()) {
                    $senderID = $row['sentByUserID'];
                    $findUsername = $connection->prepare('select username from users where userID = ?');
                    $findUsername->bind_param('s', $senderID);
                    $findUsername->execute();
                    $resultOfquery = $findUsername->get_result();
                    $senderRow = $resultOfquery->fetch_assoc();
                    $senderName = $senderRow['username'];

                    $message = $row['txt'];
            ?>
                    <?= $senderName ?> : <?= $message ?> <br>
            <?php
                }
            } else {
                header("location: login.php");
            }
            ?>
        </div>
        <div>
            <h2>Welcome <?= $_SESSION['username'] ?></h2>
            <form method="post">
                <input type="text" name="message" placeholder="text here">
                <input type="submit" name="submitTxt" value="submit">
                <input type="submit" name="login" value="login">
            </form>
        </div>
        <form method="post">
            <input type="submit" name="logout" value="logout">
        </form>
    </div>
</body>

</html>