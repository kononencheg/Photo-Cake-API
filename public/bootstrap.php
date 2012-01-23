<?php

define('FILE_URL', 'http://files.' . $_SERVER['SERVER_NAME'] . '/');
define('FILE_FOLDER', '/var/db/www/files/');
define('TEMP_FILE_FOLDER', FILE_FOLDER . 'temp/');

date_default_timezone_set('Europe/Moscow');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath($_SERVER["DOCUMENT_ROOT"] . '/../application'),
    realpath($_SERVER["DOCUMENT_ROOT"] . '/../library'),
    realpath($_SERVER["DOCUMENT_ROOT"] . '/../templates'),
    get_include_path(),
)));

function load_class($className) {
    $classPath = str_replace(array('\\', '_'), \DIRECTORY_SEPARATOR, $className) . '.php';

    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    foreach($includePaths as $path) {
        if(file_exists($path . DIRECTORY_SEPARATOR . $classPath)) {
            require_once($classPath);
            break;
        }
    }

    return class_exists($className, false);
}

spl_autoload_register('load_class');

// For IE iframe
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

