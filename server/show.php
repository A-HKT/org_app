<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';
?>
<?php

// セッション開始
session_start();

$current_user = '';
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

if (!empty($_POST["season_id"])) {
    $select_season = $_POST["season_id"];
} else {
    $select_season = [];
}
if (!empty($_POST["category_id"])) {
    $select_category = $_POST["category_id"];
} else {
    $select_category = [];
}

//$select_category = $_POST["category_id"];

//$db = getDb();
$db = getSelectedDb($select_season, $select_category);

?>



<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="show">
        <h1>検索結果</h1>
        <section class="show_form form">
            <h2>SHOW</h2>
            <?php foreach ($db as $line) : ?>
                <li>
                    <span><?= $line["id"] ?></span>
                    <span><?= $line["user_id"] ?></span>
                    <span><?= $line["season_id"] ?></span>
                    <span><?= $line["description"] ?></span>
                </li>
            <?php endforeach; ?>
