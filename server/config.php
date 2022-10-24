<?php

// 接続に必要な情報を定数として定義
// hostにはコンテナ名を指定する
define('DSN', 'mysql:host=db;dbname=pg_camp;charset=utf8');
define('USER', 'testuser');
define('PASSWORD', '9999');

// エラーメッセージを定数として定義
define('MSG_USERID_REQUIRED', 'IDを入力してください');
define('MSG_EMAIL_REQUIRED', 'メールアドレスを入力してください');
define('MSG_PASSWORD_REQUIRED', 'パスワードを入力してください');
define('MSG_EMAIL_PASSWORD_NOT_MATCH', '入力した内容に誤りがあります');
// アップロード画像のエラーメッセージ
define('MSG_NO_DESCRIPTION', '詳細を入力してください');
define('MSG_NO_IMAGE', 'ファイルを選択してください');

// アップロード画像の拡張子のエラーメッセージ
define('EXTENTION', ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']);
define('MSG_NOT_ABLE_EXT', '選択したファイルの拡張子が有効ではありません');
?>
