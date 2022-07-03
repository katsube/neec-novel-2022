<?php
/**
 * セーブする
 *
 * リクエスト
 *     POST /api/save.php
 *     id=G999A9999&value=xxxxxxxxxxx
 * レスポンス
 *     {"status": true}
 */

//-----------------------------------------------------
// 定数
//-----------------------------------------------------
define('DATAFILE', 'data.txt');

//-----------------------------------------------------
// 引数を受け取る
//-----------------------------------------------------
$id    = $_POST['id'];
$value = $_POST['value'];

//-----------------------------------------------------
// サーバに保存する
//-----------------------------------------------------
// フラグ
$flag = false;

// 書き込む
$fp = fopen(DATAFILE, 'a');
if( $fp !== null ){
	flock($fp, LOCK_EX);		// ロック
	ftruncate($fp, 0);			// ファイルを真っ白にする
	fseek($fp, 0);					// ファイルポインタを先頭に戻す
	fwrite($fp, $value);			// 書き込む
	flock($fp, LOCK_UN);		// ロック解除
	fclose($fp);

	$flag = true;
}

//-----------------------------------------------------
// レスポンス
//-----------------------------------------------------
echo json_encode([
	'status' => $flag
]);
