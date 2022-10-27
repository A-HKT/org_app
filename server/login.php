<?php
//設定ファイルを読み込む
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// セッション（データの一時保存）開始
session_start();

//変数の初期化
$user_id = '';
$email = '';
$password = '';
$errors = [];

// ログイン判定(ログイン済ならリダイレクト)
if (isset($_SESSION['current_user'])) {
    header('Location: index.php');
    exit;
}

// 各データを変数に格納
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = filter_input(INPUT_POST, 'user_id');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $errors = login_validate($user_id, $email, $password);

    // エラーがなかったらユーザー情報を抽出
    if (empty($errors)) {
        $user = find_user_by_email($email);
        if (!empty($user) && password_verify($password, $user['password'])) {
            user_login($user);
        } else {
            $errors[] = MSG_EMAIL_PASSWORD_NOT_MATCH;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<!--ヘッダーの設定ファイルを読み込む-->
<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <main class="login">
        <h1>ログイン画面</h1>

        <!--エラー時のエラーメッセージ出力-->
        <?php include_once __DIR__ . '/_errors.php' ?>

        <form action="login.php" method="POST">
            <section class="login_form form" action="" method="post">
                <h2>LOGIN</h2>
                <div class="user_item item_box">
                    <p>社員番号</p>
                    <div class="user_item item">
                        <input type="number" name="user_id" id="user_id" placeholder="ID">
                    </div>
                </div>
                <div class="user_item item_box">
                    <p>メール</p>
                    <div class="user_item item">
                        <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
                    </div>
                </div>
                <div class="user_item item_box">
                    <p>パスワード</p>
                    <div class="user_item item">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                </div>
            </section>
            <div class="form_contents">
                <input type="submit" value="ログイン" class="login_btn form_btn">
            </div>
        </form>
    </main>
</body>

</html>
