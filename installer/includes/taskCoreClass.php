<?php

class Core {

    function checkEmpty($data) {
        return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']);
    }


    function show_message($type, $message) {
        return $message;
    }

    function getAllData($data) {
        return $data;
    }

    function write_db_config($data) {
        $template_path = '../assets/app/db/database.php';
        $output_path = '../application/config/database.php';

        $database_file = file_get_contents($template_path);
        if ($database_file === false) {
            return false;
        }

        $new = str_replace(
            ["%HOSTNAME%", "%USERNAME%", "%PASSWORD%", "%DATABASE%"],
            [$data['hostname'], $data['username'], $data['password'], $data['database']],
            $database_file
        );

        @chmod($output_path, 0777);
        if (is_writable(dirname($output_path))) {
            $handle = fopen($output_path, 'w+');
            if ($handle === false) {
                return false;
            }

            if (fwrite($handle, $new) === false) {
                fclose($handle);
                return false;
            }

            fclose($handle);
            return true;
        } else {
            return false;
        }
    }

    function checkFile() {
        return file_exists('../application/config/database.php');
    }
}
