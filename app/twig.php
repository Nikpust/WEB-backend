<?php
    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');
    $twig = new \Twig\Environment($loader, [
        'cache' => false,
    ]);

    return $twig;
?>