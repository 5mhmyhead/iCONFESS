<?php
    class AuthController extends Controller
    {
        private AuthService $authService;
        private ConfessionsService $confessionsService;
        private array $authConfig;

        public function __construct()
        {
            $this -> layout = 'index';
            $this -> authService = new AuthService();
            $this -> confessionsService = new ConfessionsService();
            $this -> authConfig = require __DIR__ . '/../config/auth.php';
        }

        public function index()
        {
            $totalConfessions = $this -> confessionsService -> getTotalConfessions();
            $weeklyConfessions = $this -> confessionsService -> getWeeklyConfessions();
            $accountsLive = $this -> authService -> getAccountsLive();

            $this -> view('auth/index', [
                'error' => '',
                'formView' => '../app/views/auth/_login.php',
                'totalConfessions' => $totalConfessions,
                'weeklyConfessions' => $weeklyConfessions,
                'accountsLive' => $accountsLive
            ]);
        }

        public function register()
        {
            $totalConfessions = $this -> confessionsService -> getTotalConfessions();
            $weeklyConfessions = $this -> confessionsService -> getWeeklyConfessions();
            $accountsLive = $this -> authService -> getAccountsLive();

            $this -> view('auth/index', [
                'error' => '', 
                'formView' => '../app/views/auth/_register.php',
                'totalConfessions' => $totalConfessions,
                'weeklyConfessions' => $weeklyConfessions,
                'accountsLive' => $accountsLive
            ]);
        } 
        
        public function registerUser()
        {
            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this -> json(['success' => false, 'message' => 'POST method required'], 405);
                return;
            }

            $input = $this -> jsonInput();

            $email = $input['email'] ?? '';
            $username = $input['username'] ?? '';
            $password = $input['password'] ?? '';
            $role = $input['role'] ?? 'user';
            $modSecret = $input['mod_secret'] ?? '';

            // passcode required to register as moderator
            $expectedModSecret = $this -> authConfig['mod_secret'] ?? 'studyhard2026';

            if ($role === 'moderator') 
            {
                if (empty($modSecret) || $modSecret !== $expectedModSecret) 
                {
                    $this -> json(['success' => false, 'message' => 'Invalid moderator passcode.'], 403);
                    return;
                }
            } 
            else 
            {
                $role = 'user';
            }

            $result = $this -> authService -> registerUser($email, $username, $password, $role);
            $this -> json($result, $result['success'] ? 201 : 422);
        }

        public function loginUser()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this -> json(['success' => false, 'message' => 'POST method required'], 405);
                return;
            }

            $input = $this -> jsonInput();
            $username = $input['username'] ?? '';
            $password = $input['password'] ?? '';

            $result = $this -> authService -> loginUser($username, $password);

            if (!$result['success']) {
                $this -> json(['success' => false, 'message' => $result['message']], 401);
                return;
            }

            $user = $result['user'];
            $token = Jwt::createForUser(
                $user,
                $this -> authConfig['jwt_secret'],
                (int) $this -> authConfig['jwt_ttl']
            );

            $_SESSION['user_id'] = $user -> getId();

            $this -> json([
                'success' => true, 
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => (int) $this -> authConfig['jwt_ttl']
            ]);
        }

        public function logout()
        {
            session_destroy();
            header('Location: ?url=auth');
            exit;
        }
    }
?>