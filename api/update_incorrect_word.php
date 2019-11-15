<?php

require_once __DIR__.'/../../php/get_sqlite_db.php' ;
require_once __DIR__ . '/../../../../e-listening/public/api/get_e-listening.php';


function update_incorrect_word($user_name){
try{
    
    $pdo=get_e_speakingdb();

    $stmt = $pdo->prepare('SELECT user_id FROM User WHERE user_name=:username ;');
    $stmt->bindvalue(':username', $user_name);
    $stmt->execute();
    $user_id = $stmt->fetch();

    $pdo2=get_new_sqlitedb();

    $stmt = $pdo2->prepare('SELECT mi.word 
    FROM Mistakes as mi
    INNER JOIN Log as lo ON lo.log_id=mi.log_id
    INNER JOIN Users as us ON us.user_id=lo.user_id
    Where us.user_name = :user_name');
    $stmt->bindvalue(':user_name', $user_name);
    $stmt->execute();
    $incorrect_word=$stmt->fetchall();

    
    $count= count($incorrect_word);

    $incorrect=[];
    for($i=0; $i<$count; $i++){
        array_push($incorrect,$incorrect_word[$i]['word']);
    }
     $comma_separated = implode(",", $incorrect);

     $stmt = $pdo->prepare("UPDATE Question SET  word =:word  WHERE user_id=:user_id;");

     $stmt->bindvalue(":word", $comma_separated);
     $stmt->bindvalue(":user_id", $user_id['user_id']);
     $stmt->execute();

} catch (PDOException $e) {
    $errorMessage = 'Database error';
    //$errorMessage = $sql;
    // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
     echo $e->getMessage();
}

}
 