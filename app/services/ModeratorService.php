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
}