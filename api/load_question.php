<?php

require_once __DIR__.'/../../php/get_sqlite_db.php' ;


$user_name=$_POST['user_name'];

try{

    $pdo=get_e_speakingdb();

    $stmt = $pdo->prepare('SELECT user_id FROM User WHERE user_name=:username ;');
    $stmt->bindvalue(':username', $user_name);
    $stmt->execute();
    $user_id = $stmt->fetch();


    $stmt = $pdo->prepare('SELECT word FROM Question WHERE user_id=:user_id');
    $stmt->bindvalue(":user_id", $user_id['user_id']);
    $stmt->execute();
    $question = $stmt->fetch();

    header('Content-type: application/json');
    echo json_encode($question, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    $errorMessage = 'Database error';
    //$errorMessage = $sql;
    // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
     echo $e->getMessage();
}