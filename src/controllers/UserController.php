<?php

    namespace App\controllers;

    use App\core\BaseController;
    use App\models\User;

    class UserController extends BaseController {

        public function index(string $mode): void {
            echo $this->twig->render('auth.twig', ['mode' => $mode]);
        }

        public function register(): void {
            header('Content-Type: application/json');
            
            $userModel = new User();
            $result = $userModel->register($_POST);
            
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function login(): void {
            header('Content-Type: application/json');
            
            $userModel = new User();
            $result = $userModel->login($_POST);
            
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        public function logout(): void {
            session_destroy();
            header('Location: /');
            exit();
        }
        
    }

?>