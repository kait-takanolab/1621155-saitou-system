<?php
set_time_limit(120);

 require_once( __DIR__."/phonetic_data.php"); 
 require_once( __DIR__."/phpQuery-onefile.php");   
//  mb_convert_variables('UTF-8','ASCII',$phonetic_reration);

 $keys=array_keys($phonetic_reration);
 // var_dump($keys);
//  foreach($keys as $key){

//  mb_convert_variables('UTF-8','ASCII',$phonetic_reration[$key]);
//  // echo mb_detect_encoding($phonetic_reration[$key]);
//  // echo mb_detect_encoding($key);
//  // mb_convert_variables('UTF-8','ASCII',$phonetic_reration);
//  // echo $key.":".$phonetic_reration[$key];
// }

    function get_phonetic($word,$phonetic_reration){
 
    $url='https://ejje.weblio.jp/content/'.$word;
    $html=file_get_contents($url);
    $text=phpQuery::newDocument($html)->find('.summaryM')->text();
    
    if($p=mb_strrpos($text,"発音記号・読み方")){
      $p1=mb_strpos($text,"/");
      $p2=mb_strrpos($text,"(米国英語)");
      $sign=mb_substr($text,$p1,$p2-$p1)."/";
      $text=mb_substr($text,0,$p1-9);

    //   if($p1=mb_strpos($sign,"(弱形)")){
    //     $p2=mb_strpos($sign,"(強形)");
    //     $array["w_sign"]="/".mb_substr($sign,6,$p2-$p1-7)."/";
    //     $array["s_sign"]="/".mb_substr($sign,$p2+5,-1)."/";
    //   }
      $replace = explode("/",$sign);
      $replace = explode("'\'",$replace[1]);
      $array["s_sign"]=$replace[0];
      $array["w_sign"]=-1;

      if(strpos($array["s_sign"],'形)') !== false){
        $replace = explode(") ",$array["s_sign"]);
        $array["s_sign"]=$replace[1];
        //'abcd'のなかに'bc'が含まれている場合
        // echo "含む";
      }

      if(strpos($array["s_sign"],'《') !== false){
        $replace = explode(" 《",$array["s_sign"]);
        $array["s_sign"]=$replace[0];
        //'abcd'のなかに'bc'が含まれている場合
        // echo "含む";
      }

      if(strpos($array["s_sign"],'(強') !== false){
        $replace = explode(" (強",$array["s_sign"]);
        $array["s_sign"]=$replace[0];
        //'abcd'のなかに'bc'が含まれている場合
        // echo "含む";
      }

      if(strpos($array["s_sign"],';') !== false){
        $replace = explode(";",$array["s_sign"]);
        $array["s_sign"]=$replace[0];
        //'abcd'のなかに'bc'が含まれている場合
        // echo "含む";
      }

      if(strpos($array["s_sign"],'(') !== false){
        $bef_replace = explode("(",$array["s_sign"]);
        if(strpos($array["s_sign"],')') !== false){
            $aft_replace = explode(")",$array["s_sign"]);
        //'abcd'のなかに'bc'が含まれている場合}
        }
        $array["s_sign"]=$bef_replace[0].$aft_replace[1];
      }

      if(strpos($array["s_sign"],'\n') !== false){
        $bef_replace = explode('\n',$array["s_sign"]);
        if(strpos($array["s_sign"],'\n') !== false){
            $aft_replace = explode('\n',$array["s_sign"]);
        //'abcd'のなかに'bc'が含まれている場合}
        }
        $array["s_sign"]=$bef_replace[0].$aft_replace[1];
      }

      $keys=array_keys($phonetic_reration);
      foreach($keys as $key){
        if(strpos($array["s_sign"],$key) !== false){
            $array["s_sign"] = str_replace($key,$phonetic_reration[$key], $array["s_sign"]);    
        }
      }

    }else{
      $array["s_sign"]=-1;
      $array["w_sign"]=-1;
    }
    
    // if($p=mb_strrpos($text,"音節")){
    //   $t=mb_substr($text,$p);
    //   if(preg_match("/[a-zA-Z]/", $t)){
    //     $array["syllable"]=mb_substr($text,$p+2,-1);
    //     $text=mb_substr($text,0,$p);
    //   }
    //   $array["cnt_syllable"]=mb_substr_count($array["syllable"],"・")+1;
    // }else{
    //   $array["syllable"]=-1;
    //   $array["cnt_syllable"]=-1;
    // }
    
    // $text=mb_substr($text,4);   //echo $text."<br />";
    // $text=str_replace("。","、",$text);
    // $text=str_replace("; ","、",$text);
    // $m=explode("、",$text);
    // for($i=0;$i<3;$i++){
    //   if(!empty($m[$i])){
    //     $means[$i]=$m[$i];
    //   }else{
    //     $means[$i]=-1;
    //   }
    // }
    // $array["mean1"]=$means[0];
    // $array["mean2"]=$means[1];
    // $array["mean3"]=$means[2];
  
    // var_dump(json_encode($array,JSON_UNESCAPED_UNICODE));

    // return json_encode($array,JSON_UNESCAPED_UNICODE);

    //DBに単語と音素（発音記号）のセットを挿入
//     try{
//     $pdo=get_sqlitedb();
//     $stmt=$pdo->prepare("INSERT INTO word_phonetic(word,phonetic) VALUES(:word,:phonetic)");

//     $stmt->bindvalue(':word',$word);
//     $stmt->bindvalue(':phonetic',$array['s_sign']);
 
//     $stmt->execute();

//   } catch (Exception $e) {
//     echo $e->getMessage().PHP_EOL;
// }

    return $array;
    }

    // $S=get_phonetic("progresses",$phonetic_reration);
    // var_dump($S);
    // echo $S["s_sign"];

    // $str = $S["s_sign"];
    // echo mb_detect_encoding($str); //サンプル文字列
    // $arr = str_split($str); //1バイトずつ配列に分解
    // foreach ($arr as $ch){
    //     echo dechex(ord($ch));
    //     echo $ch;
    //     echo "\n" ;//16進コードで表示
    // }
  
