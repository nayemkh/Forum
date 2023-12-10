<?php

$url = substr($_SERVER['REQUEST_URI'], 1);
$viewsPath = __DIR__ . '/views';

$views = ['registration'];

require_once __DIR__ . '/elements/forum_functions.php';

if (in_array($url, $views)) {
    $pageTitle = ucfirst($url);
    include __DIR__ . '/elements/header.php';
    require $viewsPath . '/' . $url . '.php';
} else if ($url === '' || $url === '/') {
    $pageTitle = 'Home';
    include __DIR__ . '/elements/header.php';
    require $viewsPath . '/home.php';
} else {
    $pageTitle = 'Page not found';
    include __DIR__ . '/elements/header.php';
    require $viewsPath . '/404.php';
}

include __DIR__ . '/elements/footer.php';
