<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// セッション開始
session_start();
// 初期化
$current_user = '';
$upload_file = '';
$upload_tmp_file = '';
$category = '';
$season = '';
$year = '';
$file_name = '';
$description = '';
$errors = [];
$origin_name = '';

// ログイン状態の確認(user_idに紐づけ、ログイン時のみupload.phpにアクセス可)
if (empty($_SESSION['current_user'])) {
    header('Location: login.php');
    exit;
}
$current_user = $_SESSION['current_user'];


// アップロードしたファイルの情報を受け取る
// アップロードしたファイル(image)のファイル名($_FILES関数)
// サーバー上で一時的に保存されるテンポラリファイル名
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp_file = $_FILES['upload_file']['tmp_name'];

    // 各データを変数に格納
    $category = filter_input(INPUT_POST, 'category');
    $season = filter_input(INPUT_POST, 'season');
    $year = filter_input(INPUT_POST, 'year');
    $file_name = filter_input(INPUT_POST, 'file_name');
    $description = filter_input(INPUT_POST, 'description');

    $errors = insert_validate($upload_file, $category, $season, $year, $file_name, $description);
}
// ファイルの拡張子に問題なければファイル名変更(日付を入れる)
if (empty($errors)) {
    $origin_name = date('YmdHis') . '_' . $upload_file;
    //filesフォルダに保存
    $path = '../files/' . $origin_name;
}
//データベースに保存できたらindex.phpにリダイレクト
if ((move_uploaded_file($upload_tmp_file, $path)) &&
    insert_file($current_user['user_id'], $category, $season, $year, $file_name, $description, $origin_name)
) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="upload">
        <h1>登録画面</h1>

        <!--エラー時のエラーメッセージ出力-->
        <?php include_once __DIR__ . '/_errors.php' ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <section class=" upload_form form">
            <h2>RECORD</h2>
            <div class="upload_form form_contents">
                <div class="form_items">
                    <p>登録<br>ファイル</p>
                    <div class="item_box">
                        <input type="file" name="upload_file" accept="image/jpeg, image/png">
                    </div>
                </div>
            </div>
            <div class="category_form form_contents">
                <div class="form_items">
                    <p>カテゴリ</p>
                    <div class="item_box">
                        <div class="item">
                            <input type="checkbox" name="category[]" value='1'>
                            <span>生活習慣病</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='2'>
                            <span>高齢者</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='3'>
                            <span>感染症</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='4'>
                            <span>食事・口腔</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='5'>
                            <span>メンタル</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='6'>
                            <span>職域</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='7'>
                            <span>救急</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='8'>
                            <span>時事ニュース</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='9'>
                            <span>その他</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="category[]" value='0'>
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
                            <input type="checkbox" name="season[]" value='1'>
                            <span>春</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="season[]" value='2'>
                            <span>夏</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="season[]" value='3'>
                            <span>秋</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="season[]" value='4'>
                            <span>冬</span>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="season[]" value='0'>
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
                            <input type="number" name="year[]" value=''>
                        </div>
                        <div class="item">
                            <input type="checkbox" name="year[]" value='noseason'>
                            <span>指定なし</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="title_form form_contents">
                <div class="form_items">
                    <p>タイトル</p>
                    <div class="item_box">
                        <input type="text" name="file_name" value=''>
                    </div>
                </div>
            </div>
            <div class="description_form form_contents">
                <div class="form_items">
                    <p>詳細</p>
                    <div class="item_box">
                        <textarea name="description" value='' rows="4" cols="50" placeholder="ファイルの詳細を入力してください"></textarea>
                    </div>
                </div>
            </div>
            </section>
            <div class="form_contents">
                <input type="submit" value="登録" class="upload_btn form_btn">
            </div>
        </form>
    </main>
</body>

</html>
