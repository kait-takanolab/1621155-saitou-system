<?php

//api直下のDB接続apiを呼び出し
require_once __DIR__.'/../db/get_db.php' ;

session_start();

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    //  ユーザIDの入力チェック
    // if (empty($_POST["username"])) {  // emptyは値が空のとき
    //     $errorMessage = 'Please input username!';
    // } else if (empty($_POST["password"])) {
    //     $errorMessage = 'Please input passward!';
    // }

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $username = $_POST["username"];
        

        //  エラー処理
        try {
           
            $db=get_sqlitedb();

            $stmt = $db->prepare('SELECT * FROM user WHERE user_name=?');
            $stmt->execute(array($username));

            $password = $_POST["password"];
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id= $row['id'];
                    $get_username_sql = "SELECT * FROM user WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $db->query($get_username_sql);
                    foreach ($stmt as $row) {
                        $row['user_name'];  // ユーザー名
                    }
                    $_SESSION["NAME"] = $row['user_name'];
                    $_SESSION["ID"] = $id;

                    // //ログイン時刻記録
                    // $stmt2=$db->prepare('INSERT INTO login_out(user_name,user_id,loginout_count) VALUES(:name,:uid,0)');
                    
                    // $stmt2->bindvalue(':name',$row['user_name']);
                    // $stmt2->bindvalue(':uid',$id);
                    // $stmt2->execute();
                
                    header("Location: ../selcet.html");  // メイン画面へ遷移
                    exit();  // 処理終了
                    
                } else {
                    // 認証失敗
                    $errorMessage = 'Misstype Username or passward';
                    
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'Misstype Username or passward';
            }
        } catch (PDOException $e) {
            $errorMessage = 'Database error';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
             echo $e->getMessage();
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>E-speaking-Login-</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.css" rel="stylesheet">
</head>
<body>
    <div class="notification is-primary">
        <h1>E-speaking-saito -LOGIN-</h1>
    </div>
    <div class="container">
       
        <form id="loginForm" name="loginForm" action="" method="POST">
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            
            <label class="label">Username</label>

            <div class="columns">
                    <div class="column is-4">
            <div class="control">
                <input  required class="input" type="text" id="username" name="username" placeholder="Please input username!" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
            </div> 

            <label class="label">Passward</label>
            
            <div class="control">
                <input required class="input" type="password" id="password" name="password" value="" placeholder="Please input passward!">
            </div><br>

            <input class="button is-primary"  type="submit" id="login" name="login" value="Login">
        </form><br>

        <form action="signup.php"><br>
            <div class="content">
                <h3>Sign up</h3> 
            </div>

            <input class="button is-primary"  type="submit" value="Sign up"> 
        </form>
    </div>
</body>
</html>

