<?php
    class ConfessionsService
    {
        private Confession $confessionModel;

        public function __construct()
        {
            $this -> confessionModel = new Confession();
        }

        public function getConfessions(?int $userId = null): array
        {
            $confessions = $this -> confessionModel -> getAllConfessions($userId);

            return $confessions;
        }

        public function toggleHeart(int $userId, int $id, string $action): array
        {
            if ($id <= 0) 
            {
                return ['success' => false, 'message' => 'Invalid confession ID received.'];
            }

            if (!in_array($action, ['increment', 'decrement'], true)) 
            {
                return ['success' => false, 'message' => 'Invalid interaction action received.'];
            }

            $hearts = $this -> confessionModel -> toggleHeart($userId, $id, $action);

            return ['success' => true, 'hearts' => $hearts];
        }
    }
?>