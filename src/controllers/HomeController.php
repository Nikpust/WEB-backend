<?php

    namespace App\controllers;

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

    class HomeController {
        private Environment $twig;

        public function __construct() {
            $loader = new FilesystemLoader(__DIR__ . '/../views');  # Создает загрузчик шаблонов Twig, указывая путь к папке views
            $this->twig = new Environment($loader);                 # Создает объект Twig для рендеринга шаблонов
        }
        
        public function index(): void {            
            echo $this->twig->render('home.twig');
        }
    }

?>