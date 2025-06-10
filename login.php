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

<?php
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginCheck = $connection->prepare('select * from users where username = ?');
    $loginCheck->bind_param('s' , $username);
    if($loginCheck->execute()){
    $result = $loginCheck->get_result();
    if($row = $result->fetch_assoc()){
        $userID = $row['userID'];
        $username = $row['username'];
        $userPass = $row['password'];

        if($password == $userPass){
            $_SESSION["userLogin"] = true;
            $_SESSION["username"] = $username;
            header("location: index.php");
        }
    }
}else{
    echo "user not found";
}
}

if(isset($_POST['submitCreation'])){
    $newUsername = $_POST['usernameCreation'];
    $newPass = $_POST['passwordCreation'];
    $newPassConfir = $_POST['passwordCreationConfirm'];

    if($newPass == $newPassConfir){
        $signup = $connection->prepare('insert into users(username,password ) values(?,?)');
        $signup->bind_param('ss', $newUsername,$newPassConfir);
       if($signup->execute()){
        echo "user created successfully.";
       } ;

    }
}
?>

    <div>
        <div>
            <h1>sign in</h1>
            <form method="post">
                <input type="text" name="username" placeholder = "username">
                <input type="password" name="password" placeholder = "password">
                <input type="submit" name = "submit">
            </form>
        </div>
        <h2>OR</h2>
        <div>
            <h1>sign up</h1>
            <form method="post">
            <input type="text" name="usernameCreation" placeholder = "username">
                <input type="password" name="passwordCreation" placeholder = "password">
                <input type="password" name="passwordCreationConfirm" placeholder = "password confirmation">
                <input type="submit" name = "submitCreation">
            </form>
        </div>
    </div>
</body>
</html>