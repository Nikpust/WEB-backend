<?php

    namespace App\controllers;

    use App\core\BaseController;

    class HomeController extends BaseController {
        
        public function index(): void {            
            echo $this->twig->render('home.twig');
        }
    }

?>