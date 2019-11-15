<?php

require_once __DIR__.'/../db/get_db.php' ;

// セッション開始
session_start();

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    // if (empty($_POST["username"])) {  // 値が空のとき
    //     $errorMessage = 'NOT TYPE USERNAME';
    // } else if (empty($_POST["password"])) {
    //     $errorMessage = 'NOT TYPE PASSWARD';
    // } else if (empty($_POST["password2"])) {
    //     $errorMessage = 'NOT TYPE PASSWARD';
    // }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $db=get_sqlitedb();
        $stmt = $db->prepare("SELECT * FROM user WHERE user_name='$username'");
        // $stmt->execute(array($username));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
        // $check = $db->;  // 登録した(DB側でauto_incrementした)IDを$useridに入れる
        $stmt->execute();
        $check = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty($check)){
            $errorMessage = 'This user name already used ';
        }

        else {
        // 3. エラー処理
        try {

            //ユーザー登録
            
            $stmt = $db->prepare("INSERT INTO user(user_name, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $db->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $signUpMessage = 'Complete!! Your user_name is '.$username;  // ログイン時に使用するIDとパスワード
            

        } catch (PDOException $e) {
            $errorMessage = 'Database errar';
            // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
             echo $e->getMessage();
        }
    }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'Mistype Passward';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>Sign up</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.css" rel="stylesheet">
    </head>

    <body>
        
        <div class="notification is-primary">
        <h1>Sign up</h1>
        </div>

           <div class="container">

          <form id="loginForm" name="loginForm" action="" method="POST">
            

                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                
                <div class="columns">
                 <div class="column is-4">

                <label class="label" for="username">Username</label><input required class="input" type="text" id="username" name="username" placeholder="Please type username!" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <label  class="label" for="password">Passward</label><input required class="input" type="password" id="password" name="password" value="" placeholder="Please type passward!">
                <br>
                <label  class="label" for="password2">Passward(again)</label><input required class="input"  type="password" id="password2" name="password2" value="" placeholder="Please type passward again!">
                <br><br>
                <input class="button is-primary" type="submit" id="signUp" name="signUp" value="Sign up">
                 </div></div>
        </form>
        <br><br>
        <form action="login.php">
            <input  class="button is-primary" type="submit" value="Back">
            </div>
        </form>
    </body>
</html>