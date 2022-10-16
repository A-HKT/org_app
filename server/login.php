<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';
?>



<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="login">
        <h1>ログイン画面</h1>
        <section class="login_form form">
            <h2>LOGIN</h2>
            <div class="user_item item_box">
                <p>社員番号</p>
                <div class="user_item item">
                    <input type="number" name="id_number" value=''>
                </div>
            </div>
            <div class="user_item item_box">
                <p>メール</p>
                <div class="user_item item">
                    <input type="email" name="id_number" value=''>
                </div>
            </div>
            <div class="user_item item_box">
                <p>パスワード</p>
                <div class="user_item item">
                    <input type="password" name="pass_number" value=''>
                </div>
            </div>
        </section>
    </main>
</body>
