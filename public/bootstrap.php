<?php

define('INI_FILE', realpath($_SERVER["DOCUMENT_ROOT"] . '/../config/application.ini'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath($_SERVER["DOCUMENT_ROOT"] . '/../application'),
    realpath($_SERVER["DOCUMENT_ROOT"] . '/../library'),
    get_include_path(),
)));

function load_class($className) {
    $classPath = str_replace('\\', \DIRECTORY_SEPARATOR, $className) . '.php';

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

// Header for saving cookies in IE iframe
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

