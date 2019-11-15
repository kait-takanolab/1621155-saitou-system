<?php

 $file=$_FILES['blobdata']['tmp_name'];
 $word=$_POST['word'];
 $user_name=$_POST['user_name'];

$perm_num=777;

$perm=sprintf("%04d",$perm_num);

//存在を確認したいディレクトリ（ファイルでもOK）
$dir_pass="../record/".$user_name; //この場合、一つ上の階層に「hoge」というディレクトリが存在するか確認
 
//「$directory_path」で指定されたディレクトリが存在するか確認
if(file_exists($dir_pass)){
    //存在したときの処理
    // echo "存在します";
}else{
    //存在しないときの処理
    // echo "存在しません";
    mkdir($dir_pass, 0777);
    
}

for($i=0; $i<99; $i++){
    $file_pass=$dir_pass."/".$word."_".$i.".wav";
    if(file_exists($file_pass)){
        //存在したときの処理
        // echo "存在します";
    }else{
        //存在しないときの処理
        // echo "存在しません";
        rename($file,$file_pass);
        chmod($file_pass, octdec($perm));
        $filename=$word."_".$i.".wav";
        break;
    }
}

echo $filename;
?>