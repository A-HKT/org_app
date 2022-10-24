<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// セッション開始
session_start();
$current_user = '';

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
            <h2>
                <span>Article</span><br>
                <span>Search</span><br>
                <span>Database</span>
            </h2>
            <h3>見たい記事がすぐに見つかる！</h3>
        </div>
        <img class="main_image" src="images\main_image.png" alt="main">
    </main>

    <section class="seach_form form">
        <h2>SEARCH</h2>
        <div class="category_form form_contents">
            <div class="form_items">
                <p>カテゴリ</p>
                <div class="item_box">
                    <div class="item">
                        <input type="checkbox" name="category" value='life'>
                        <span>生活習慣病</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='old'>
                        <span>高齢者</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='infection'>
                        <span>感染症</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='meal_dental'>
                        <span>食事・口腔</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='mental'>
                        <span>メンタル</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='work'>
                        <span>職域</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='firstaid'>
                        <span>救急</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='news'>
                        <span>時事ニュース</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='various'>
                        <span>その他</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='nocategory'>
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
                        <input type="checkbox" name="category" value='spring'>
                        <span>春</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='summer'>
                        <span>夏</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='autumn'>
                        <span>秋</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='winter'>
                        <span>冬</span>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='noseason'>
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
                        <input type="number" name="year" value=''>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="category" value='noseason'>
                        <span>指定なし</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="keyword_form form_contents">
            <div class="form_items">
                <p>キーワード</p>
                <div class="item_box">
                    <div class="item text_item">
                        <input type="text" name="year" value=''>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="form_contents">
        <a href="show.php" class="search_btn form_btn">
            <span>検索</span>
        </a>
        </button>
    </div>

    <!--エラー時のエラーメッセージ出力-->
    <?php include_once __DIR__ . '_errors.php' ?>
</body>

</html>
