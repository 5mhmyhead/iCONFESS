<?php 
    class Router
    {
        private array $routes;

        public function __construct(array $routes)
        {
            $this -> routes = $routes;
        }

        public function route(string $url)
        {
            if(!isset($this -> routes[$url]))
            {
                $this -> renderError(404, "The page you're looking for doesn't exist or has been moved.");
                return;
            }

            [$controllerClass, $method] = $this -> routes[$url];

            if (!class_exists($controllerClass)) {
                $this -> renderError(500, "Controller class direct access error.");
                return;
            }

            $controller = new $controllerClass();

            if(!method_exists($controller, $method))
            {
                $this -> renderError(500, "Action method not found.");
                return;
            }

            $controller -> $method();
        }

        private function renderError(int $statusCode, string $message)
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
    }
?>