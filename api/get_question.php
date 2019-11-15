<?php


require_once( __DIR__."/get_phoneme.php"); 
require_once( __DIR__."/phonetic_data.php"); 
require_once( __DIR__."/get_db.php"); 


    //DBに単語と音素（発音記号）のセットを挿入
    try{
        $pdo=get_sqlitedb();
        $stmt=$pdo->prepare("SELECT word FROM question");
        $stmt->execute();
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);

        

      } catch (Exception $e) {
        echo $e->getMessage().PHP_EOL;
    }


header("Content-Type: application/json; charset=UTF-8");
echo json_encode($row);