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

// ユーザーが登録されていないか確認する関数
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
    $_SESSION['current_user']['id'] = $user['id'];
    $_SESSION['current_user']['name'] = $user['name'];
    header('Location: /index.php');
    exit;
}




// タスク登録
function insert_task($title)
{
    // データベースに接続
    $dbh = connect_db();

    // レコードを追加
    $sql = <<<EOM
    INSERT INTO
        tasks
        (title)
    VALUES
        (:title)
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);

    // プリペアドステートメントの実行
    $stmt->execute();
}

// タスク完了
function update_done_by_id($id, $status)
{
    // データベースに接続
    $dbh = connect_db();

    // $id を使用してデータを更新
    $sql = <<<EOM
    UPDATE
        tasks
    SET
        done = :status
    WHERE
        id = :id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':status', $status, PDO::PARAM_INT);

    // プリペアドステートメントの実行
    $stmt->execute();
}

function find_task_by_done($status)
{
    $dbh = connect_db();

    /* タスク照会
---------------------------------------------*/
    // done を抽出条件に指定してデータを取得
    $sql = <<<EOM
    SELECT
        *
    FROM
        tasks
    WHERE
        done = :status;
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindValue(':status', $status, PDO::PARAM_INT);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 受け取った id のレコードを取得
function find_task_by_id($id)
{
    // データベースに接続
    $dbh = connect_db();

    // $id を使用してデータを取得
    $sql = <<<EOM
    SELECT
        *
    FROM
        tasks
    WHERE
        id = :id;
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の取得
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// タスク更新時のバリデーション
function update_validate($title, $task)
{
    // 初期化
    $errors = [];

    if (empty($title)) {
        $errors[] = MSG_TITLE_REQUIRED;
    }

    if ($title == $task['title']) {
        $errors[] = MSG_TITLE_NO_CHANGE;
    }

    return $errors;
}

// タスク更新
function update_task($id, $title)
{
    // データベースに接続
    $dbh = connect_db();

    // $id を使用してデータを更新
    $sql = <<<EOM
    UPDATE
        tasks
    SET
        title = :title
    WHERE
        id = :id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // プリペアドステートメントの実行
    $stmt->execute();
}

// タスク削除
function delete_task($id)
{
    // データベースに接続
    $dbh = connect_db();

    // $id を使用してデータを削除
    $sql = <<<EOM
    DELETE FROM
        tasks
    WHERE
        id = :id
    EOM;

    // プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    // パラメータのバインド
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // プリペアドステートメントの実行
    $stmt->execute();
}
