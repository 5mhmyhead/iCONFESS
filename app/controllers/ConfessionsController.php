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
            $isLoggedIn = $payload !== null;

            $viewMode = $_COOKIE['confessions_view_mode'] ?? 'list';

            $category = trim($_GET['category'] ?? '');
            $campus = trim($_GET['campus'] ?? '');
            $sort = trim($_GET['sort'] ?? 'recent');
            $keyword = trim($_GET['keyword'] ?? '');
            $page = max(1, (int) ($_GET['page'] ?? 1));
            $perPage = 20;

            $confessions = $this -> confessionsService -> getFilteredConfessions($category, $campus, $sort, $keyword, $userId, $page, $perPage);
            $total = $this -> confessionsService -> countFilteredConfessions($category, $campus, $sort, $keyword);
            $totalPages = (int) ceil($total / $perPage);

            $totalConfessions = $this -> confessionsService -> getTotalConfessions();
            $weeklyConfessions = $this -> confessionsService -> getWeeklyConfessions();

            $this -> view('confessions/index', [
                'confessions' => $confessions,
                'totalConfessions' => $totalConfessions,
                'weeklyConfessions' => $weeklyConfessions,
                'page' => $page,
                'totalPages' => $totalPages,
                'category' => $category,
                'campus' => $campus,
                'sort' => $sort,
                'keyword' => $keyword,
                'isLoggedIn' => $isLoggedIn,
                'viewMode' => $viewMode
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

        protected function filterUrl(array $overrides, array $current): string
        {
            $params = array_merge([
                'url' => 'confessions',
                'category' => $current['category'] ?? '',
                'campus' => $current['campus'] ?? '',
                'sort' => $current['sort'] ?? '',
                'keyword' => $current['keyword'] ?? '',
                'page' => 1
            ], $overrides);

            $params = array_filter($params, fn($v) => $v !== '' && $v !== null);

            return '?' . http_build_query($params);
        }
    }
?>