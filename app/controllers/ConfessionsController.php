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

            $page = max(1, (int) ($_GET['page'] ?? 1));
            $perPage = 20;

            $confessions = $this -> confessionsService -> getConfessions($userId, $page, $perPage);
            $total = $this -> confessionsService -> countConfessions();
            $totalPages = (int) ceil($total / $perPage);

            $totalConfessions = $this -> confessionsService -> getTotalConfessions();
            $weeklyConfessions = $this -> confessionsService -> getWeeklyConfessions();

            $this -> view('confessions/index', [
                'confessions' => $confessions,
                'totalConfessions' => $totalConfessions,
                'weeklyConfessions' => $weeklyConfessions,
                'page' => $page,
                'totalPages' => $totalPages
            ]);
        }

        public function filter()
        {
            $input = $this -> jsonInput();

            $category = trim($input['category'] ?? '');
            $campus = trim($input['campus'] ?? '');
            $sort = trim($input['sort'] ?? 'recent');
            $keyword = trim($input['keyword'] ?? '');

            $confessions = $this -> confessionsService -> getFilteredConfessions($category, $campus, $sort, $keyword);

            $this -> renderPartial('confessions/_cards', ['confessions' => $confessions]);
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

        public function report()
        {
            $payload = AuthMiddleware::requireAuth();
            $userId = (int) $payload['sub'];

            $input = $this -> jsonInput();

            $confessionId = (int) ($input['confessionId'] ?? 0);
            $reason = trim($input['reason'] ?? '');
            $customReason = trim($input['customReason'] ?? '');

            $result = $this -> confessionsService -> reportConfession($userId, $confessionId, $reason, $customReason);
            $this -> json($result, $result['success'] ? 201 : 422);
        }

        public function submit()
        {
            $payload = AuthMiddleware::requireAuth(); 
            $userId = (int) $payload['sub'];

            $input = $this -> jsonInput();

            $title = trim($input['title'] ?? '');
            $category = trim($input['category'] ?? '');
            $campus = trim($input['campus'] ?? '');
            $content = trim($input['content'] ?? '');

            $result = $this -> confessionsService -> submitConfession($userId, $title, $category, $campus, $content);
            $this -> json($result, $result['success'] ? 201 : 422);
        }
    }
?>