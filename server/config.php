<?php

// 接続に必要な情報を定数として定義
// hostにはコンテナ名を指定する
define('DSN', 'mysql:host=db;dbname=pg_camp;charset=utf8');
define('USER', 'testuser');
define('PASSWORD', '9999');

// login.php エラーメッセージを定数として定義
define('MSG_USERID_REQUIRED', 'IDを入力してください');
define('MSG_EMAIL_REQUIRED', 'メールアドレスを入力してください');
define('MSG_PASSWORD_REQUIRED', 'パスワードを入力してください');
define('MSG_EMAIL_PASSWORD_NOT_MATCH', '登録内容と合致しません');

// upload.php アップロード時のエラーメッセージ
define('MSG_NO_FILE', 'ファイルを選択してください');
define('MSG_NO_CATEGORY', 'カテゴリを選択してください');
define('MSG_NO_SEASON', '発行時期を選択してください');
define('MSG_NO_YEAR', '発行年を入力してください');
define('MSG_NO_FILENAME', 'タイトルを入力してください');
define('MSG_NO_DESCRIPTION', '詳細を入力してください');

// upload.php アップロード画像の拡張子のエラーメッセージ
define('EXTENTION', ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']);
define('MSG_NOT_ABLE_EXT', '選択したファイルの拡張子が有効ではありません');

// index.php 入力時のエラーメッセージ
define('MSG_NO_KEYWORD', 'キーワードを入力してください');
?>
