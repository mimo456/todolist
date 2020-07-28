<?php
// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";

require_once('DBTodo.php');
$dbTodo = new DBTodo();
//更新処理
if (isset($_POST['submitUpdate'])) {
    $dbTodoId=htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $dbTodoText=htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    $dbDate=htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
    $dbTodo->UpdateTodo($dbTodoId,$dbTodoText,$dbDate);
}

//修正用フォーム要素の表示
//echo $data;で出力したHTMLはgoods.phpにあるので$_POST['id']などはgoods.phpで受け取れる
if (isset($_POST['update'])) {
    $dbTodoId=htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $dbTodoText=htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    $dbDate=htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
    //修正対象の値を取得
    $dbTodo->UpdateTodo($dbTodoId, $dbTodoText,$dbDate);
    //クラスを記述することで表示/非表示を設定
    $entryCss = "class='hideArea'";
    $updateCss = "";
} else {
    $entryCss = "";
    $updateCss = "class='hideArea'";
}

//削除処理
if (isset($_POST['delete'])) {
    $dbTodo->DeleteTodo($_POST['id']);
}
//新規登録処理
if (isset($_POST['submitEntry'])) {
    $dbTodo->InsertTodo();
}
//テーブルデータの一覧表示
$data = $dbTodo->selectTodoAll();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todoリスト</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    <div id="entry" <?php echo $entryCss;?>><!--入力画面-->
        <h1>Todoリスト</h1>
        <form action="" method="post">
            やること<input type="text" name="todo" value="<?php if (isset($_POST['update'])){echo $_POST['text'];} ?>">
            <input type="date" name="date" value="<?php if (isset($_POST['update'])){echo $_POST['date'];} ?>">
            <input type="submit" value="追加" name="submitEntry">
        </form><br>
    </div>
    <div id="update" <?php echo $updateCss;?>>
        <form action="" method="post">
            <h2>修正</h2>
            <p>ID: <?php echo $dbTodoId;?>
            </p>
            <input type="hidden" name="id" value="<?php echo $dbTodoId;?>" />
            <!--IDを変更できない形で先に出力する-->
            <label><span class="entrylabel">Todo</span><input type='text' name='text' size="30"
            value="<?php echo $dbTodoText;?>"required></label>
            <label><span class="entrylabel">日付</span><input type='text' name='date' size="10"
            value="<?php echo $dbDate;?>" required></label>
            <input type='submit' name='submitUpdate' value=' 　送信　 '>
        </form>
    </div>
    <?php echo $data ?>
</body>

</html>