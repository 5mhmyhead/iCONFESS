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
            $this -> renderError(403, "You don't have permission to access this page.");
            return;
        }

        $metrics = $this -> moderatorService -> getMetrics();

        $this -> view('moderator/index', [
            'error' => '',
            'metrics' => $metrics
        ]);
    }
}