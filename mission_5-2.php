<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset=utf-8>
    <title>mission_5-2</title>
</head>
    
<body>
    
    
  <?php
    //データベース接続設定
    $dsn='データベース名';
    $user='ユーザー名';
    $password='パスワード';
    $pdo= new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
	
	
	//テーブル削除
	/*
	
	$sql = 'DROP TABLE mission5';
		$stmt = $pdo->query($sql); 
	*/	
	
	
	
    //テキストテーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS mission5"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date DATETIME,"
	. "password char(32)"
	.");";
	$stmt = $pdo->query($sql);
	
	//コメント入力設定
	
	 //新規投稿のとき
	if(isset($_POST["submit"]) && empty($_POST["check"])){
	 $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment,date,password) VALUES (:name, :comment, NOW(),:password)");
	  $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	  $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	  $sql -> bindParam(':password', $password, PDO::PARAM_STR);
	   $name = $_POST["name"];
	   $comment =$_POST["comment"];
	   $password=$_POST["password"];
	 $sql -> execute();
	}
	
	
	//削除機能
	if(isset($_POST["del_submit"]) && !empty($_POST["del_password"])){
	  $dnum=$_POST["del_num"];
	  $del_pass=$_POST["del_password"];
	//テキストの抽出
	 $sql = 'SELECT * FROM mission5';
	 $stmt = $pdo->query($sql);
	 $results = $stmt->fetchAll();
	 foreach ($results as $row){
	  if($row['password']==$del_pass){
	   $sql='delete from mission5 where id=:id';
	   $stmt=$pdo->prepare($sql);
	    $stmt->bindParam(':id',$dnum,PDO::PARAM_INT);
	  $stmt->execute();
	}
	}
	}
	
	
	//編集処理
	 $edit_name="";
	 $edit_com="";
	 $edit_num="";
	 $edit_pass="";
	
	if(isset($_POST["edit_submit"]) && !empty($_POST["edit_password"])){
	  $edit_pass=$_POST["edit_password"];
	  $edit_num=$_POST["edit_num"];
	//テキストの抽出
	$sql = 'SELECT * FROM mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
	 if($row["password"]==$edit_pass){
	  if($row['id']==$edit_num){
	     $edit_name=$row["name"];
	     $edit_com=$row["comment"];
	     $edit_pass=$row["password"];
	  }
	 }
	}
	}
	//編集機能
	if(!empty($_POST["check"]) && isset($_POST["submit"])){
	  $enum=$_POST["check"];
	  $ename=$_POST["name"];
	  $ecom=$_POST["comment"];
	  $epass=$_POST["password"];
	 //編集実行
	 $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=NOW(),password=:password WHERE id=:id';
	 $stmt = $pdo->prepare($sql);
	  $stmt->bindParam(':name', $ename, PDO::PARAM_STR);
	  $stmt->bindParam(':comment', $ecom, PDO::PARAM_STR);
	  $stmt->bindParam(':password', $epass, PDO::PARAM_STR);
	  $stmt->bindParam(':id', $enum, PDO::PARAM_INT);
	 $stmt->execute();
	}

	?>
	<br>
    <hi><font size="7">あなたのおすすめの映画は？</font></hi><br>
    <br>
    <font size="4">おすすめの映画を書いてください<br>
    【記入方法：名前＋コメント＋好きなパスワード】<br>
    
    </font>
    <br>
    <hr>
	<!--フォーム設定-->
    <form action="" method="post">
        <!--投稿フォーム-->
        お名前：<input type="text" name="name" 
                      value="<?php if(isset($_POST["edit_num"])){echo $edit_name;
                                }else{$edit_name=""; echo $edit_name;}?>"><br>
        コメント：<input type="text" name="comment" 
                      value="<?php if(isset($_POST["edit_num"])){echo $edit_com;
                                }else{$edit_com=""; echo $edit_com; }?>"><br>
        <!--のちhidden-->
        <input type="hidden" name="check" 
                      value="<?php if(isset($_POST["edit_num"])){echo $edit_num;
                                }else{$edit_num=""; echo $edit_num;}?>">
        パスワード：<input type="password" name="password"
                       value="<?php if(isset($_POST["edit_num"])){echo $edit_pass;
                                }else{$edit_pass=""; echo $edit_pass;}?>"><br>
        <input type="submit" name="submit">
        <br>
        <br>
        <!--削除フォーム-->
        削除：<input type="number" name="del_num"><br>
        パスワード：<input type="password" name="del_password"><br>
        <input type="submit" name="del_submit">
        <br>
        <br>
         <!--編集フォーム-->
        編集:<input type="number" name="edit_num"><br>
        パスワード：<input type="password" name="edit_password"><br>
        <input type="submit" name="edit_submit">
    </form>
    
    <?php
    
    //データベース接続設定
    $dsn='データベース名';
    $user='ユーザー名';
    $password='パスワード';
    $pdo= new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
   
    
    /*
    
    //テーブル表示
    $sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
	
	*/
	
	
	
	//表示機能
	$sql = 'SELECT * FROM mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	}
	?>
</body>
</html>