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
    <header>
        <div class="page_header wrapper">
            <a href="index.php">記事検索データベース</a>
            <nav class="top_menu">
                <ul class="menu_nav">
                    <li><a href="index.php">Top</a></li>
                    <li><a href="logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main_content wrapper">
        <div class="main_title">
            <h2>
                <span>Article</span><br>
                <span>Search</span><br>
                <span>Database</span>
            </h2>
            <h3>見たい記事がすぐに見つかる！</h3>
        </div>
        <img class="main_image" src="images\main_image.png" alt="main">
    </div>

    <form>
        <div class="dashboard wrapper">
            <h2>記事検索</h2>
            <div class="categories contents_form">
                <p>カテゴリ</p>
                <input type="checkbox" name="category" value='life'>
                <span>生活習慣病</span>
                <input type="checkbox" name="category" value='old'>
                <span>高齢者</span>
            </div>
            <div class='seasons'>
                <p>時期</p>
                <input type="checkbox" name="category" value='spring'>
                <span>春</span>
                <input type="checkbox" name="category" value='summer'>
                <span>夏</span>
            </div>
            <input type="submit" value="検索">
        </div>
        <!--エラー時のエラーメッセージ出力-->
        <! ?php include_once __DIR__ . '_errors.php' ?>
    </form>


</body>

</html>
