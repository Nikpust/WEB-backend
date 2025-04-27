<?php

    namespace App\core;

    use App\controllers\HomeController;
    use App\controllers\BookController;

    class Router {
        public static function handle(string $uri): void {
            switch ($uri) {
                case '/':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new HomeController();
                        $controller->index();
                    } else {
                        echo 'Метод не разрешен';
                    }
                    break;

                case '/books':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new BookController();
                        $controller->index();
                    } else {
                        echo 'Метод не разрешен';
                    }
                    break;

                case '/book/save':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller = new BookController();
                        $controller->save();
                    } else {
                        echo 'Метод не разрешен';
                    }
                    break;
                
                case '/book/delete':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller = new BookController();
                        $controller->delete();
                    } else {
                        echo 'Метод не разрешен';
                    }
                    break;

                case '/book/get':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new BookController();
                        $controller->get();
                    }
                    break;
                    
                case '/book/update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller = new BookController();
                        $controller->update();
                    }
                    break;
                    
                default:
                    http_response_code(404);
                    echo "Страница не найдена";
                    break;
            }
        }
    }

?>