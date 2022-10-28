<?php
//設定ファイルを読み込む
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    // try ~ catch 構文
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        // 接続がうまくいかない場合こちらの処理が実行される
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    // ENT_QUOTES: シングルクオートとダブルクオートを共に変換する。
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// ログイン時のバリデーション関数
function login_validate($user_id, $email, $password)
{
    // 初期化
    $errors = [];
    // エラーメッセージをconfig.phpで定義
    if (empty($user_id)) {
        $errors[] = MSG_USERID_REQUIRED;
    }
    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }
    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    return $errors;
}

// ユーザーが登録されているか確認する関数(emailをキーにする)
function find_user_by_email($email)
{
    $dbh = connect_db();
    $sql = <<<EOM
    SELECT
        *
    FROM
        users
    WHERE
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ログイン処理(セッションにデータを一次保存)するための関数
function user_login($user)
{
    $_SESSION['current_user']['id'] = $user['user_id'];
    $_SESSION['current_user']['email'] = $user['email'];
    header('Location: index.php');
    exit;
}

// 画像アップ時のバリデーション関数
function insert_validate($description, $upload_file)
{
    // 初期化
    $errors = [];
    // エラーメッセージをconfig.phpで定義
    if (empty($description)) {
        $errors[] = MSG_NO_DESCRIPTION;
    }
    if (empty($upload_file)) {
        $errors[] =
            MSG_NO_IMAGE;
        // ファイルの拡張子をチェック(関数呼び出す)
    } else {
        if (check_file_ext($upload_file)) {
            $errors[] = MSG_NOT_ABLE_EXT;
        }
    }
    return $errors;
}

// ファイルの拡張子を取得する関数
function check_file_ext($upload_file)
{
    $file_ext = pathinfo($upload_file, PATHINFO_EXTENSION);
    if (!in_array($file_ext, EXTENTION)) {
        return true;
    } else {
        return false;
    }
}

// ファイルの情報をデータベースに保存する
// function insert_file($user_id, $image_name, $description)
// {
//     try{
//         $dbh = connect_db();
//         $sql = <<<EOM
//         INSERT INTO
//         files(user_id,file,discription);
//         EOM;

//         $stmt = $dbh->prepare($sql);

//     }
// }
