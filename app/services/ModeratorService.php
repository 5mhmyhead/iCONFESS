<?php
class ModeratorService
{
    private Confession $confessionModel;
    private User $userModel;

    public function __construct()
    {
        $this -> confessionModel = new Confession();
        $this -> userModel = new User();
    }

    public function getMetrics(): array
    {
        return [
            'totalPosts' => $this -> confessionModel -> countAllConfessions(),
            'newToday' => $this -> confessionModel -> countConfessionsToday(),
            'pending' => $this -> confessionModel -> countByStatus('pending'),
            'flagged' => $this -> confessionModel -> countFlaggedConfessions(),
            'registeredUsers' => $this -> userModel -> countAllUsers(),
            'newUsersThisWeek' => $this -> userModel -> countUsersThisWeek()
        ];
    }

    public function approveConfession(int $id): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid confession.'];

        $this -> confessionModel -> approveConfession($id);
        return ['success' => true];
    }

    public function rejectConfession(int $id, string $reason): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid confession.'];

        if (trim($reason) === '') return ['success' => false, 'message' => 'A rejection reason is required.'];

        $this -> confessionModel -> rejectConfession($id, trim($reason));
        return ['success' => true];
    }

    public function returnToQueue(int $id): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid confession.'];
        
        $this -> confessionModel -> returnToQueue($id);
        return ['success' => true];
    }

    public function getQueue(string $status, string $category, string $campus, string $keyword, int $page = 1, int $perPage = 20): array
    {
        return $this -> confessionModel -> getModerationQueue($status, $category, $campus, $keyword, $page, $perPage);
    }

    public function countQueue(string $status, string $category, string $campus, string $keyword): int
    {
        return $this -> confessionModel -> countModerationQueue($status, $category, $campus, $keyword);
    }
}