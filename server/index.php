<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// セッション開始
session_start();
$current_user = '';
//セッション変数['current_user']に保存されている値でログイン判定
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーのファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="main_content wrapper">
        <div class="main_title">
            <h3>見たい記事がすぐに見つかる！</h3>
            <h2>
                <span>Article</span><br>
                <span>Search</span><br>
                <span>Database</span>
            </h2>
        </div>
        <img class="main_image" src="images\main_image.png" alt="main">
    </main>

    <!--エラー時のエラーメッセージ出力-->
    <!?php include_once __DIR__ . '_errors.php' ?>

        <form action="index.php" method="POST">
            <section class="seach_form form">
                <h2>SEARCH</h2>
                <div class="category_form form_contents">
                    <div class="form_items">
                        <p>カテゴリ</p>
                        <div class="item_box">
                            <div class="item">
                                <input type="checkbox" name="category_id" value='1'>
                                <span>生活習慣病</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='2'>
                                <span>高齢者</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='3'>
                                <span>感染症</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='4'>
                                <span>食事・口腔</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='5'>
                                <span>メンタル</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='6'>
                                <span>職域</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='7'>
                                <span>救急</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='8'>
                                <span>時事ニュース</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='9'>
                                <span>その他</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="category_id" value='0'>
                                <span>指定なし</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="season_form form_contents">
                    <div class="form_items">
                        <p>時期</p>
                        <div class="item_box">
                            <div class="item">
                                <input type="checkbox" name="season_id" value='1'>
                                <span>春</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="season_id" value='2'>
                                <span>夏</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="season_id" value='3'>
                                <span>秋</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="season_id" value='4'>
                                <span>冬</span>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="season_id" value='0'>
                                <span>指定なし</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="year_form form_contents">
                    <div class="form_items">
                        <p>発行年</p>
                        <div class="item_box">
                            <div class="item">
                                <input type="number" name="year_data" value=''>
                            </div>
                            <div class="item">
                                <input type="checkbox" name="year_data" value='noseason'>
                                <span>指定なし</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="keyword_form form_contents">
                    <div class="form_items">
                        <p>キーワード</p>
                        <div class="item_box">
                            <input type="text" name="keyword" value=''>
                        </div>
                    </div>
                </div>
            </section>
            <div class="information">
                <a href="upload.php"><span>登録 </span>はこちら →</a>
            </div>
            <div class="form_contents">
                <input type="submit" value="検索" class="index_btn form_btn">
            </div>
        </form>
</body>

</html>
