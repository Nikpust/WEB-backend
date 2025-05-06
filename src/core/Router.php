<?php

    namespace App\core;

    use App\controllers\HomeController;
    use App\controllers\BookController;
    use App\controllers\UserController;
    use App\controllers\ReportController;

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

                case '/login':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new UserController();
                        $controller->index('sign-in');
                    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller = new UserController();
                        $controller->login();
                    }
                    break;

                case '/register':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new UserController();
                        $controller->index('sign-up');
                    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller = new UserController();
                        $controller->register();
                    }
                    break;

                case '/logout':
                    $controller = new UserController();
                    $controller->logout();
                    break;

                case '/report/exel':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new ReportController();
                        $controller->downloadExel();
                    }
                    break;

                case '/report/pdf':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $controller = new ReportController();
                        $controller->downloadPdf();
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