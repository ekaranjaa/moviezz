<?php

session_start();

function asset($folder, $file)
{
    $root = '/';

    switch ($folder) {
        case 'js':
            return $root . 'js/' . $file . '.js';
            break;
        case 'css':
            return $root . 'css/' . $file . '.css';
            break;
        case 'images':
            return $root . 'images/' . $file;
            break;
        case 'videos':
            return $root . 'videos/' . $file;
            break;
    }
}

require __DIR__ . '/core/Controller.php';

require __DIR__ . '/core/Model.php';

require __DIR__ . '/core/App.php';
