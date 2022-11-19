<?php
    // 関数ファイを読み込む
    require_once __DIR__ . '/../common/functions.php';

    // セッション開始
    session_start();

    $id = 0;
    $file = '';
    $old_image = '';

    $user_id = filter_input(INPUT_GET, 'user_id');


    if (delete_file_by_user_id($user_id)) {
    // fileフォルダに存在する画像の削除
    unlink($old_image);

    header('Location: index.php');
    exit;
} else {
    header('Location: show.php?user_id=' . $user_id);
    exit;
}
