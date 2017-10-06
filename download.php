<?php
ini_set('memory_limit', '-1');
$filename = isset($_GET['file']) ? $_GET['file'] : '';
$file_path = 'uploads/'.$filename;
if (file_exists($file_path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit;
} else {
    echo 'Sorry! Tập tin không tồn tại.';
}
?>
