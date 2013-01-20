<?php
// Change this path to where the files are stored
chdir('Desktop/ajax/ajax-2.0/');

spl_autoload_register('autoload');

function autoload($className) {
    $fileName = 'classes/' . strtr($className, '_', '/') . '.php';
    if (file_exists($fileName)) {
        include $fileName;
    }
}