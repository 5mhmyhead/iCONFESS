<?php
class ModeratorController extends Controller
{
    private ModeratorService $moderatorService;

    public function __construct()
    {
        $this -> layout = 'index';
        $this -> moderatorService = new ModeratorService();
    }

    public function index()
    {
        $this -> requireModerator();

        $status = trim($_GET['status'] ?? 'pending');
        $category = trim($_GET['category'] ?? '');
        $campus = trim($_GET['campus'] ?? '');
        $keyword = trim($_GET['keyword'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 20;

        $confessions = $this -> moderatorService -> getQueue($status, $category, $campus, $keyword, $page, $perPage);
        $total = $this -> moderatorService -> countQueue($status, $category, $campus, $keyword);
        $totalPages = (int) ceil($total / $perPage);
        $metrics = $this -> moderatorService -> getMetrics();

        $this -> view('moderator/index', [
            'error' => '',
            'metrics' => $metrics,
            'confessions' => $confessions,
            'status' => $status,
            'category' => $category,
            'campus' => $campus,
            'keyword' => $keyword,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function approve()
    {
        $this -> requireModerator();

        $input = $this -> jsonInput();
        $result = $this -> moderatorService -> approveConfession((int) ($input['id'] ?? 0));

        $this -> json($result, $result['success'] ? 200 : 422);
    }

    public function reject()
    {
        $this -> requireModerator();
        $input = $this -> jsonInput();
        
        $result = $this -> moderatorService -> rejectConfession((int) ($input['id'] ?? 0), trim($input['reason'] ?? ''));
        $this -> json($result, $result['success'] ? 200 : 422);
    }

    public function returnToQueue()
    {
        $this -> requireModerator();
        $input = $this -> jsonInput();
        $result = $this -> moderatorService -> returnToQueue((int) ($input['id'] ?? 0));
        $this -> json($result, $result['success'] ? 200 : 422);
    }

    private function requireModerator(): array
    {
        $payload = AuthMiddleware::requireAuth();

        if (!in_array($payload['role'] ?? '', ['moderator', 'admin'], true)) 
        {
            $this -> json(['success' => false, 'message' => 'Forbidden'], 403);
            exit;
        }

        return $payload;
    }
}