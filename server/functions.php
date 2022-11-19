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

// login.php ログイン時のバリデーション関数
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

// upload.php アップロード時のバリデーション関数
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
            (user_id, image, category_id ,season_id, year_id, file_name, description) 
        VALUES 
            (:user_id, :image, :category_id, :season_id, :year_id, :file_name, :description);
        EOM;

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category, PDO::PARAM_INT);
        $stmt->bindValue(':season_id', $season, PDO::PARAM_INT);
        $stmt->bindValue(':year_id', $year, PDO::PARAM_INT);
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

// show.php DBからデータを参照する関数
// function get_Db()
// {
//     $dbh = connect_db();
//     $sql = <<<EOM
//     SELECT
//         *
//     FROM
//         files
//     WHERE 
//         id >= 0
//     EOM;

//     $stmt = $dbh->query($sql);
//     return $stmt->fetchAll();
// }

// show.php 検索(選択)されたデータを抽出する関数
function get_Selected_Db($select_category, $select_season, $select_year)
{
    $where = "";
    $dbh = connect_db();
    //implode関数で要素を結合して文字列にし、変数IDsに代入
    if (!empty($select_category)) {
        $where = "WHERE f.category_id IN ('" . implode("', '", $select_category) . "')";
    }
    if (!empty($select_season)) {
        if (empty($where)) {
            $where = "WHERE ";
        } else {
            $where .= " AND ";
        }
        //変数に文字列を連結し再代入する場合の省略形 
        $where .= "f.season_id IN ('" . implode("', '", $select_season) . "')";
        // $where = $where . "season_id IN ('" . implode("', '", $select_season) . "')";
    }
    if (!empty($select_year)) {
        if (empty($where)) {
            $where = "WHERE ";
        } else {
            $where .= " AND ";
        }
        $where .= "f.year_id = " . $select_year;
        // $where = $where . "year_id IN ('" . implode("', '", $select_year) . "')";
    }

    $sql = <<<EOM
    SELECT
        f.id,
        f.image,
        f.file_name,
        f.description,
        c.category,
        y.year,
        s.season
    FROM
        files AS f
    LEFT JOIN
        categories AS c
    ON
        f.category_id = c.category_id
    LEFT JOIN
        years AS y
    ON
        f.year_id = y.year_id
    LEFT JOIN
        seasons AS s
    ON
        f.season_id = s.season_id
    {$where}
    EOM;
    $stmt = $dbh->query($sql);
    return $stmt->fetchAll();
}


// //データベース(files）の情報を更新する関数
function
update_file($category, $season, $year, $file_name, $description)
{
    
    try {
        $dbh = connect_db();

        $sql = <<<EOM
        UPDATE
            files
            (category_id ,season_id, year_id, file_name, description) 
        SET 
            (:category_id, :season_id, :year_id, :file_name, :description);
        EOM;

        if (!empty($image_name)) {
            $sql .= ', image = :image ';
        }
        $sql .= ' WHERE user_id = :user_id';

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_id', $category, PDO::PARAM_INT);
        $stmt->bindValue(':season_id', $season, PDO::PARAM_INT);
        $stmt->bindValue(':year_id', $year, PDO::PARAM_INT);
        $stmt->bindValue(':file_name', $file_name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        if (!empty($image_name)) {
            $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
        }
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

//データベース(files）のファイルを削除する関数
function delete_file_by_user_id($user_id)
{
    try {
        $dbh = connect_db();

        $sql = <<<EOM
        DELETE 
            FROM 
        files 
            WHERE 
        user_id = :user_id;
        EOM;

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        return false;
    }
}





