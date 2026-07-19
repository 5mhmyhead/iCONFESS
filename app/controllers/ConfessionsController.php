<?php
    class ConfessionsController extends Controller
    {
        private ConfessionsService $confessionsService;

        public function __construct()
        {
            $this -> layout = 'index';
            $this -> confessionsService = new ConfessionsService();
        }

        public function index()
        {
            $payload = AuthMiddleware::optionalAuth();
            $userId = $payload ? (int) $payload['sub'] : null;

            $confessions = $this -> confessionsService -> getConfessions($userId);

            $this -> view('confessions/index', [
                'confessions' => $confessions
            ]);
        }

        public function heart()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this -> json(['success' => false, 'message' => 'POST method required.'], 405);
                return;
            }

            $payload = AuthMiddleware::requireAuth();
            $userId = (int) $payload['sub'];

            $input = $this -> jsonInput();
            $id = (int) ($input['id'] ?? 0);
            $action = $input['action'] ?? '';

            $result = $this -> confessionsService -> toggleHeart($userId, $id, $action);

            if (!$result['success']) {
                $this -> json(['success' => false, 'message' => $result['message']], 422);
                return;
            }

            $this -> json(['success' => true, 'hearts' => $result['hearts']]);
        }
    }
?>