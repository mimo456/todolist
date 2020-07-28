<?php
require_once('db.php');
class DBTodo extends DB
{
    //goodsテーブルのCRUD担当
    public function SelectTodoAll()
    {
        $sql = "SELECT * FROM tasks";
        $res = parent::executeSQL($sql, null);
        $data = "<table class='recordlist' id='goodsTable'>";
        $data .= "<tr><th>ID</th><th>やること</th><th>日付</th><th></th><th></th></tr>\n";
        foreach ($rows = $res->fetchAll(PDO::FETCH_NUM) as $row) {
            $data .= "<tr>";
            for ($i=0;$i<count($row);$i++) {
                $data .= "<td>{$row[$i]}</td>";
            }
            //修正ボタンのコード
            //修正ボタンを押すと$_POST['update']が送られて、受け取ったらindex.phpで更新表示をする
            //row[0]にはid,row[1]にはtext,row[2]にはdateが入っている
            $data .= <<<eof
                    <td><form method='post' action=''>
                    <input type='hidden' name='id' value='{$row[0]}'>
                    <input type='hidden' name='text' value='{$row[1]}'>
                    <input type='hidden' name='date' value='{$row[2]}'>
                    <input type='submit' name='update' value='修正'>
                    </form></td>
                eof;
            //削除ボタンのコード
            $data .= <<<eof
                    <td><form method='post' action=''>
                    <input type='hidden' name='id' id='Deleteid' value='{$row[0]}'>
                    <input type='submit' name='delete' id='delete' value='削除'
                    onClick='return CheckDelete()'>
                    </form></td>
                eof;
            $data .= "</tr>\n";
        }
        $data .= "</table>\n";
        return $data;
    }

    public function InsertTodo()
    {//追加
        $sql = "INSERT INTO tasks (text,date) VALUES(?,?)";
        $array = array(htmlspecialchars($_POST['todo'], ENT_QUOTES, 'UTF-8'),htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8'));
        parent::executeSQL($sql, $array);
    }

    public function UpdateTodo($id,$text,$date)
    {//修正
        $sql = "UPDATE tasks SET text=?,date=? WHERE id={$id}";
        //array関数の引数の順番に注意する
        $array = array($text,$date);
        parent::executeSQL($sql, $array);
    }

    public function TodoTextForUpdate($ID)
    {
        return $this->FieldValueForUpdate($ID, "text");
    }

    public function DateForUpdate($ID)
    {
        return $this->FieldValueForUpdate($ID, "date");
    }

    private function FieldValueForUpdate($ID, $field)
    {
        //private関数　上の2つの関数で使用している
        //"Price"を仮引数として受け取ると、$fieldにPriceが代入される
        $sql = "SELECT {$field} FROM tasks WHERE ID=?";
        $array = array($ID);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetch(PDO::FETCH_NUM);
        return $rows[0];//1レコードのみの取得なので$rows[0]
    }

    public function DeleteTodo($id)
    {//削除
        $sql = "DELETE FROM tasks WHERE id=?";
        $array = array($id);
        parent::executeSQL($sql, $array);
    }
}
