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
                http_response_code(404);
                $this -> render404("The page you're looking for doesn't exist or has been moved.");
                return;
            }

            [$controllerClass, $method] = $this -> routes[$url];

            if (!class_exists($controllerClass)) {
                $this -> render404("Controller class direct access error.");
                return;
            }

            $controller = new $controllerClass();

            if(!method_exists($controller, $method))
            {
                $this -> render404("Action method not found.");
                return;
            }

            $controller -> $method();
        }

        private function render404(string $message)
        {
            http_response_code(404);
            $errorMessage = $message;

            $viewPath = '../app//views/layouts/404.php';

            if (file_exists($viewPath)) 
            {
                require $viewPath;
            } 
            else 
            {
                echo '404 Page Not Found';
            }
        }
    }
?>