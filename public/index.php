<?php

    require_once __DIR__ . '/../vendor/autoload.php';   # Подключает автозагрузку Composer, чтобы автоматически загружать классы

    use App\core\Router;

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    Router::handle($uri);

?>