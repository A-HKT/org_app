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

// ログイン時、ユーザーが登録されているか確認する関数(emailをキーにする)
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

    // プリペアドステートメント(可変部分を変数に)準備
    // パラメータのバインド(パラメータと値を紐づけ)
    // プリペアドステートメントの実行
    //取得結果を配列で受け取る
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ログイン処理(セッションにデータを一次保存)するための関数
function user_login($user)
{
    $_SESSION['current_user']['user_id'] = $user['user_id'];
    $_SESSION['current_user']['email'] = $user['email'];
    header('Location: index.php');
    exit;
}

// ファイルアップロード時のバリデーション関数
function insert_validate($upload_file, $category, $season, $year, $file_name, $description)
{
    // 初期化
    $errors = [];
    // エラーメッセージをconfig.phpで定義
    if (empty($upload_file)) {
        $errors[] = MSG_NO_FILE;
        // ファイルの拡張子をチェック(関数呼び出す)
    } else {
        if (check_file_ext($upload_file)) {
            $errors[] = MSG_NOT_ABLE_EXT;
        }
    }
    if (empty($category)) {
        $errors[] = MSG_NO_CATEGORY;
    }
    if (empty($season)) {
        $errors[] = MSG_NO_SEASON;
    }
    if (empty($year)) {
        $errors[] = MSG_NO_YEAR;
    }
    if (empty($file_name)) {
        $errors[] = MSG_NO_FILENAME;
    }
    if (empty($description)) {
        $errors[] = MSG_NO_DESCRIPTION;
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
//入力情報をデータベース(files）に登録
function insert_file($user_id, $image_name, $category, $season, $year, $file_name, $description)
{
    try {
        $dbh = connect_db();
        $sql = <<<EOM
        INSERT INTO 
            files
            (user_id, image, category_id ,season_id, year_data, file_name, description) 
        VALUES 
            (:user_id, :image, :category_id, :season_id, :year_data, :file_name, :description);
        EOM;

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category, PDO::PARAM_INT);
        $stmt->bindValue(':season_id', $season, PDO::PARAM_INT);
        $stmt->bindValue(':year_data', $year, PDO::PARAM_INT);
        $stmt->bindValue(':file_name', $file_name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
