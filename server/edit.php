<?php

//セッション開始
session_start();
// 初期化
$current_user = '';
$user_id = 0;
$file = '';
$description = '';
$upload_file = '';
$upload_tmp_file = '';
$errors = [];

$user_id = filter_input(INPUT_GET, 'user_id');

//セッション変数['current_user']に保存された値でログイン判定(user_idに紐づけ、ログイン時のみupload.phpへ)
if (empty($_SESSION['current_user'])) {
    header('Location: login.php');
    exit;
}
$current_user = $_SESSION['current_user'];

// user_idを基にデータを取得
$file = find_file_by_user_id($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = filter_input(INPUT_POST, 'description');
    // アップロードした画像のファイル名
    // 変更がない場合は画像は更新しない
    if (
        !empty($_FILES['image']['name']) &&
        $_FILES['image']['name'] != $file['image']
    ) {
        $upload_file = $_FILES['image']['name'];
        // サーバー上で一時的に保存されるテンポラリファイル名
        $upload_tmp_file = $_FILES['image']['tmp_name'];
        $old_image = './files/' . $file['image'];
        $image_name = date('YmdHis') . '_' . $_FILES['image']['name'];
        $path = './files/' . $image_name;
    }
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

        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <section class=" upload_form form">
                <h2>RECORD</h2>
                <div class="upload_form form_contents">
                    <div class="form_items">
                        <p>登録<br>ファイル</p>
                        <div class="item_box">
                            <input type="file" name="image" accept="image/jpeg, image/png">
                        </div>
                    </div>
                </div>
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
                                <select name="year_id">
                                    <option value="1">2022年</option>
                                    <option value="2">2021年</option>
                                    <option value="3">2020年</option>
                                    <option value="4">2019年</option>
                                    <option value="5">2018年</option>
                                    <option value="0">指定なし</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title_form form_contents">
                    <div class="form_items">
                        <p>タイトル</p>
                        <div class="item_box">
                            <input type="text" name="file_name">
                        </div>
                    </div>
                </div>
                <div class="description_form form_contents">
                    <div class="form_items">
                        <p>詳細</p>
                        <div class="item_box">
                            <textarea name="description" rows="4" cols="50" placeholder="ファイルの詳細を入力してください"></textarea>
                        </div>
                    </div>
                </div>
            </section>
            <div class="information">
                <a href="index.php"><span>検索 </span>へもどる →</a>
            </div>
            <?php if (!empty($current_user) && $current_user['id'] == $file['user_id']) : ?>
                <div class="form_contents">
                    <div class="form_contents">
                        <input type="submit" value="編集" class="edit_btn form_btn"><a href="edit.php?id=<?= h($file['user_id']) ?>">
                            <input type="submit" value="削除" class="edit_btn form_btn"><a href="edit.php?id=<?= h($file['user_id']) ?>">
                            <?php endif; ?>
                    </div>
        </form>
    </main>
</body>

</html>
