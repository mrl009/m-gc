<?php

class WaterMask{
	public function render($file){
		$s = json_decode(file_get_contents('../../../../uploads/file/setting.json'),true);
		if($s['maskFont']) WaterMask::fontMask($file,$s['maskFont'],intval($s['xFont']),intval($s['yFont']));
		if($s['maskImg'])  WaterMask::imgMask($file,'../../../../'.$s['maskImg'],$s['xImg'],intval($s['yImg']),intval($s['opacityImg']));
	}
	public function fontMask($dst_path,$text,$x=10,$y=30){
		$dst = imagecreatefromstring(file_get_contents($dst_path));
		$font = '../../fonts/STXIHEI.TTF';
		$red = imagecolorallocate($dst, 255, 0, 0);
		imagefttext($dst, 18,0,$x, $y, $red, $font, $text);
		list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
		if($dst_type==1){
			imagegif($dst,realpath($dst_path));
		}else if($dst_type==2){
			imagejpeg($dst,realpath($dst_path));
		}else if($dst_type==3){
			imagepng($dst,realpath($dst_path));
		}
		imagedestroy($dst);
	}
	public function imgMask($dst_path,$src_path,$x=10,$y=10,$opacity=50){
		$dst = imagecreatefromstring(file_get_contents($dst_path));
		$src = imagecreatefromstring(file_get_contents($src_path));
		list($src_w, $src_h) = getimagesize($src_path);
		imagecopymerge($dst, $src, $x, $y, 0, 0, $src_w, $src_h, $opacity);
		list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
		if($dst_type==1){
			imagegif($dst,realpath($dst_path));
		}else if($dst_type==2){
			imagejpeg($dst,realpath($dst_path));
		}else if($dst_type==3){
			imagepng($dst,realpath($dst_path));
		}
		imagedestroy($dst);
		imagedestroy($src);
	}
}

/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

#!! IMPORTANT: 
#!! this file is just an example, it doesn't incorporate any security checks and 
#!! is not recommended to be used in production environment as it is. Be sure to 
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* 
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$rootDir = '../../../../uploads/image/'.date('Y');
if(!file_exists($rootDir)) @mkdir($rootDir);
$targetDir = $rootDir.'/'.date('md');
//file_put_contents('file.txt', $rootDir);
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
	@mkdir($targetDir);
}

// Get a file name
if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files	
if ($cleanupTargetDir) {
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory.'.$targetDir.'"}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// If temp file is current file proceed to the next
		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}	


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
} else {	
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
}

while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
	//$fileName = uniqid().array_pop(explode('.',$filename));
	$newFile = $targetDir.DIRECTORY_SEPARATOR.md5(uniqid()).'.'.array_pop(explode('.',$_FILES["file"]["name"]));
	rename("{$filePath}.part", $newFile);
	WaterMask::render($newFile);
}

// Return Success JSON-RPC response
ob_clean();
die('{"jsonrpc" : "2.0", "result" : "'.str_replace('../','',$newFile).'", "id" : "id"}');