<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';

// セッション開始
session_start();
//セッション変数['current_user']に保存されている値でログイン判定
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

//index.phpで入力されたDB抽出の検索条件を受け取り変数に代入
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
if (!empty($_POST["keyword"])) {
    $select_keyword = $_POST["keyword"];
} else {
    $select_keyword = '';
}

//DBからデータを抽出する
//$db = get_Db();

//DBから検索条件に該当するデータを抽出する
$db = get_Selected_Db($select_category, $select_season, $select_year, $select_keyword);
?>

<!DOCTYPE html>
<html lang="ja">
<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="show">
        <h1>検索結果</h1>
        <form action="" method="POST">
            <section class="show_form form" action="" method="post">
                <h2>SHOW</h2>
                <div class="read">
                    <p>タイトルをクリックするとファイルがご覧いただけます。</p>
                    <?php foreach ($db as $line) : ?>
                        <span>《 検索内容 》
                            <?= h($line["category"]) ?>、
                            <?= h($line["season"]) ?>、
                            <?= h($line["year"]) ?>年
                            <!?= h($line["keyword"]) ?>
                            <?php endforeach; ?>
                        </span>
                </div>
                <table>
                    <tr>
                        <th class=id_td>ID</th>
                        <th class=file_name_td>タイトル</th>
                        <th class=category_td>カテゴリ</th>
                        <th class=season_td>時期</th>
                        <th class=year_td>発行年</th>
                        <th class=description_td>詳細</th>
                        <th class=edit_td>編集</th>
                    </tr>
                    <?php foreach ($db as $line) : ?>
                        <tr>
                            <td class=id_td>
                                <?= h($line["id"]) ?></td>
                            <td class=file_name_td>
                                <a href="/files/<?= h($line["image"]) ?>"> <?= h($line["file_name"]) ?></a>
                            </td>
                            <td class=category_td>
                                <?= h($line["category"]) ?></td>
                            <td class=season_td>
                                <?= h($line["season"]) ?></td>
                            <td class=year_td>
                                <?= h($line["year"]) ?></td>
                            <td class=description_td>
                                <?= h($line["description"]) ?></td>
                            <td class="edit_td">
                                <div class="pen_btn">
                                    <a href="edit.php"><i class=" fa-solid fa-pen"></i>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </section>
            <div class="information both_information">
                <a href="index.php"><i class="fa-solid fa-circle-arrow-left"></i> <span class=span_index>検索</span>する </a>
                <a href="upload.php"><span class=span_upload>登録</span>する <i class="fa-solid fa-circle-arrow-right"></i></a>
            </div>
        </form>
    </main>
</body>

</html>
