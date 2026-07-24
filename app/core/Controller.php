<?php 
    class Controller
    {
        protected string $layout = 'index';

        public function view(string $view, array $data = [])
        {
            extract($data);

            ob_start();
            require_once '../app/views/' . $view . '.php';
            $content = ob_get_clean();

            require_once '../app/views/layouts/' . $this -> layout . '.php';
        }

        public function renderPartial(string $view, array $data = [])
        {
            extract($data);
            require_once '../app/views/' . $view . '.php';
        }

        public function renderError(int $statusCode, string $message)
        {
            http_response_code($statusCode);
            $errorCode = $statusCode;
            $errorMessage = $message;

            $viewPath = '../app/views/layouts/error.php';

            if (file_exists($viewPath)) 
            {
                require $viewPath;
            } 
            else 
            {
                echo $statusCode . ' - ' . htmlspecialchars($message);
            }
        }

        protected function jsonInput(): array
        {
            $raw = file_get_contents('php://input');
            $input = json_decode($raw, true);

            if(is_array($input)) 
            {
                return $input;
            }

            return $_POST;
        }
        
        public function json(array $data, int $status = 200)
        {
            header('Content-Type: application/json');
            http_response_code($status);
            echo json_encode($data);
            exit;
        }
    }
?>