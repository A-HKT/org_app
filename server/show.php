<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// セッション開始
//セッション変数['current_user']に保存されている値でログイン判定
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

//index.phpで入力されたDB抽出の検索条件を受け取り、変数に代入
if (!empty($_POST["category_id"])) {
    $select_category = $_POST["category_id"];
} else {
    $select_category = [];
}
if (!empty($_POST["season_id"])) {
    $select_season = $_POST["season_id"];
} else {
    $select_season = [];
}
if (!empty($_POST["year_id"])) {
    $select_year = $_POST["year_id"];
} else {
    $select_year = '';
}

//DBからデータを抽出する
//$db = get_Db();
//DBから検索条件に該当するデータを抽出する
$db = get_Selected_Db($select_category, $select_season, $select_year);

?>

<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>


<body>
    <main class="show">
        <h1>検索結果</h1>
        <form action="" method="POST">
            <section class=" show_form form" action="" method="post">
                <h2>SHOW</h2>
                <div class="">
                    <p>ID, ユーザー,カテゴリ,時期,年,タイトル,詳細</p>
                    <?php foreach ($db as $line) : ?>
                        <table>
                            <td>
                                <span><?= $line["id"] ?></span><span>, </span>
                                <span><?= $line["category"] ?></span><span>,</span>
                                <span><?= $line["season"] ?></span><span>,</span>
                                <span><?= $line["year"] ?></span><span>,</span>
                                <span><?= $line["file_name"] ?></span><span>,</span>
                                <span><?= $line["description"] ?></span>
                            </td>
                        </table>
                    <?php endforeach; ?>
