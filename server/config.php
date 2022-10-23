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
define('MSG_EMAIL_PASSWORD_NOT_MATCH', 'メールアドレスかパスワードが間違っています')

?>
