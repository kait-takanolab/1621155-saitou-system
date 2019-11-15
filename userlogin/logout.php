<?php

require_once __DIR__.'/../db/get_db.php' ;

session_start();

if (isset($_SESSION["NAME"])) {
    
    // //ログアウトしたユーザのuid取得
    //     $e_db=get_new_sqlitedb();

    //     $username=$_SESSION["NAME"];

    //     $stmt=$e_db->prepare("Select user_id,user_name from Users where user_name='$username'");
    //     $stmt->execute();
    //     $result=$stmt->fetch(PDO::FETCH_ASSOC);
                    
    // //ログアウト時刻記録

    //     $stmt2=$e_db->prepare('INSERT INTO login_out(user_name,user_id,loginout_count) VALUES(:name,:uid,1)');
                    
    //     $stmt2->bindvalue(':name',$result['user_name']);
    //     $stmt2->bindvalue(':uid',$result['user_id']);
    //     $stmt2->execute();


    $errorMessage = "LOGOUT!";
} else {
    $errorMessage = "SESSION TIMEOUT!";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
         <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.css" rel="stylesheet">
        <title>LOGOUT</title>
    </head>
    <body>
     <div class="notification is-primary">
        <h1>LOGOUT</h1>
     </div>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div><br>
        <ul class="menu-list">
            <li><a href="login.php">BACK to Login Form</a></li>
        </ul>
    </body>
</html>
