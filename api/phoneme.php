<?php

require_once( __DIR__."/get_phoneme.php"); 
require_once( __DIR__."/phonetic_data.php"); 
require_once( __DIR__."/get_db.php"); 

$output_word  = $_POST["output_word"];
$correct_word  = $_POST["correct_word"];
$user_id=$_POST["user_id"];
$user_id=intval($user_id);
$filename=$_POST["filename"];

// var_dump($filename);
if ($filename==""){
  $check_word=array("");
  // echo $check_word;
}
else{
  $check_word=explode("_",$filename);
  // echo $check_word;
}
$output_phoneme=get_phonetic($output_word,$phonetic_reration);
$correct_phoneme=get_phonetic($correct_word ,$phonetic_reration);

if($correct_word==$check_word[0]){
      //DBに単語と音素（発音記号）のセットを挿入
      try{
          $pdo=get_sqlitedb();
          $stmt=$pdo->prepare("INSERT INTO phoneme_all(correct_word,output_word,correct_phoneme,output_phoneme,user_id,wav_filename) VALUES(:correct_word,:output_word,:correct_phoneme,:output_phoneme,:user_id,:filename)");
      
          $stmt->bindvalue(':correct_word',$correct_word);
          $stmt->bindvalue(':output_word',$output_word);
          $stmt->bindvalue(':correct_phoneme',$correct_phoneme["s_sign"]);
          $stmt->bindvalue(':output_phoneme',$output_phoneme["s_sign"]);
          $stmt->bindvalue(':user_id',$user_id);
          $stmt->bindvalue(':filename',$filename);
          $stmt->execute();
      
        } catch (Exception $e) {
          echo $e->getMessage().PHP_EOL;
      }
      $bool="success";
    }

  else {
    $bool="faild";
}
$result=array("output_phoneme"=>$output_phoneme,
"correct_phoneme"=>$correct_phoneme,
"check"=>$bool);
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($result);