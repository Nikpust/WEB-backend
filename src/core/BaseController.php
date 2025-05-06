<?php

    namespace App\core;

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

    abstract class BaseController {
        protected Environment $twig;

        public function __construct() {
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new Environment($loader);

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $this->twig->addGlobal('session', $_SESSION);
        }
    }

?>