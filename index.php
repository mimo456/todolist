<?php
    require_once('functions.php');//外部ファイルの読み込み

    // echo "<pre>";
    // echo var_dump($_POST);
    // echo "<pre>";

    if(isset($_POST['submit'])){//送信されたデータをテーブルに格納

        $name=$_POST['name'];
        $name=htmlspecialchars($name,ENT_QUOTES);

        $dbh=db_connect();//try-catch呼び出し

        $sql='INSERT INTO tasks(name,done) VALUES(?,0)';//?はプレースホルダ、直接値を入力しないようにしている

        $stmt=$dbh->prepare($sql);//SQL文を準備するメソッド

        $stmt->bindValue(1,$name,PDO::PARAM_STR);//変数の値とプレースホルダを結びつける

        $stmt->execute();//ここでSQLが実行されて、dbのテーブルにデータが格納される。

        $dbh=null;

        unset($name);
    }
    //原因特定のためのテスト
    echo "test";
    if(isset($_POST['method'])){
        echo "成功";
    }
    if(isset($_POST['method'])&&($_POST['method']==='put')){//済んだを押したものを更新して非表示にする
        echo "test2";
        $id=$_POST["id"];
        $id=htmlspecialchars($id,ENT_QUOTES);
        $id=(int)$id;
        $dbh=db_connect();
        $sql='UPDATE tasks SET done=1 WHERE id=?';
        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(1,$id,PDO::PARAM_INT);//doneを0から1に変えて0のものだけを表示する
        $stmt->execute();

        $dbh=null;
    }

    
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todoリスト</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <h1>Todoリスト</h1>
    <form action="index.php" method="post">
        <ul>
            <li><span><input type="text" name="name"></span></li>
            <li><input type="submit" name="submit"></li>
        </ul>
    </form>
    <ul>
    <?php
        $dbh=db_connect();


        $sql='SELECT id,name FROM tasks WHERE done=0 ORDER BY id DESC';//idカラムから降順に引っ張ってくる
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        $dbh=null;

        while($task=$stmt->fetch(PDO::FETCH_ASSOC)){//結果セットから一行取得します。$taskは配列
            // echo "<pre>";
            // echo var_dump($task);
            // echo "<pre>";
            print '<li>';
            print $task["name"];
            print '<br>';
            print   '
                    <from action="index.php" method="post">
                        <input type="hidden" name="method" value="put">
                        <input type="hidden" name="id" value="'.$task['id'].'">
                        
                        <input type="submit" value="済んだ">
                    </form>
                    ';
            print '</li>';
        }
    ?>
    </ul>
</body>
</html>