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
        $payload = AuthMiddleware::requireAuth();
        if (!in_array($payload['role'] ?? '', ['moderator', 'admin'], true)) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }

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
}