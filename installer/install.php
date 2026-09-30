<?php
// Aktifkan semua laporan kesalahan selama pengembangan, ubah ke 0 dalam produksi
error_reporting(E_ALL);
//error_reporting(0);
$db_config_path = '../application/config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {

    require_once('includes/taskCoreClass.php');
    require_once('includes/databaseLibrary.php');

    $core = new Core();
    $database = new Database();

    $message = 'success';
    if ($core->checkEmpty($_POST)) {
        if (!$database->create_database($_POST)) {
            $message = $core->show_message('error', "ERROR#001<br>Gagal membuat database, pastikan semua parameter diisi dengan benar.");
        } else if (!$database->create_tables($_POST)) {
            $message = $core->show_message('error', "ERROR#002<br>Gagal membuat database, pastikan semua parameter diisi dengan benar.");
        } else if (!$core->checkFile()) {
            $message = $core->show_message('error', "ERROR#003<br>File application/config/database.php tidak ditemukan");
        } else if (!$core->write_db_config($_POST)) {
            $message = $core->show_message('error', "ERROR#004<br>Tidak bisa membuat database, silakan ganti permission chmod application/config/database.php menjadi 777");
        }
    } else {
        $message = $core->show_message('error', "ERROR#005<br>Gagal membuat database, pastikan semua parameter diisi dengan benar.");
    }
    echo $message;
}
