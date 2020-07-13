<?php
    function db_connect(){
        try{//PDOクラスでデータベースに正しく接続できなかった場合エラーが表示される
            $dsn='mysql:dbname=todolist;host=localhost;caraset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);//PDOクラスをインスタンス化、PDOクラスはデータベースサーバーを接続するクラス
            // var_dump($dbh);
            
            
            $dbh->query('SET NAMES utf8');//queryメソッドを呼び出す、SQL文を発行するメソッド、文字化けを防ぐ
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);//セキュリティ対策のためのコード
            
            return $dbh;//変数に受け渡すためにリターン
        }catch(PDOException $e){
            print "エラー:".$e->getMessage()."<br/>";
            die();
        }
    }