<?php
class DB
{
    //MySQLとやり取りをするクラス
    private $USER = "root";
    private $PW   = ""; //正しいパスワードを設定してください
    private $dns  = "mysql:dbname=todolist;host=localhost;charset=utf8";

    private function Connectdb()
    {
        try {
            $pdo = new PDO($this->dns, $this->USER, $this->PW);
            return $pdo;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function executeSQL($sql, $array)
    {
        //SQLを実行する関数
        try {
            if (!$pdo = $this->Connectdb()) {
                return false;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($array);
            return $stmt;   //戻り値はPDOStatementのインスタンス
        } catch (Exception $e) {
            return false;
        }
    }
}
