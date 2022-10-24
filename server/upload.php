<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// セッション開始
session_start();
// 初期化
$current_user = '';
$description = '';
$upload_file = '';
$upload_tmp_file = '';
$errors = [];

// ログイン状態の確認(ログイン時のみupload.phpにアクセス可)
if (empty($_SESSION['current_user'])) {
    header('Location: login.php');
    exit;
}
$current_user = $_SESSION['current_user'];

// アップロードしたファイルの情報を受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // 画像の説明文
    $description = filter_input(INPUT_POST, 'description');
         // アップロードした画像のファイル名
    $upload_file = $_FILES['image']['name'];
         // サーバー上で一時的に保存されるテンポラリファイル名
    $upload_tmp_file = $_FILES['image']['tmp_name'];

    $errors = insert_validate($description, $upload_file);
?>




<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="post">
        <h1>登録画面</h1>
        <section class="post_form form">
            <h2>RECORD</h2>
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
                    <p>タイトル</p>
                    <div class="item_box">
                        <div class="item text_item">
                            <input type="text" name="year" value=''>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upload_form form_contents">
                <div class="form_items">
                    <p>アップロード</p>
                    <div class="item_box">
                        <div class="item image_item">
                            <input type="file" name="upload_file" accept="image/jpeg, image/png">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="form_contents">
            <a href="done.php" class="post_btn form_btn">
                <span>登録</span>
            </a>
            </button>
        </div>
    </main>
</body>

</html>
