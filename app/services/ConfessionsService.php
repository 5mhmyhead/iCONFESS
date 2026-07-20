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

        public function submitConfession(int $userId, string $title, string $category, string $campus, string $content): array
        {
            if ($title === '' || $category === '' || $campus === '' || $content === '') {
                return ['success' => false, 'message' => 'All fields are required.'];
            }

            if (!in_array($category, ['Love', 'Academic', 'Drama', 'Miscellaneous'], true)) {
                return ['success' => false, 'message' => 'Invalid category.'];
            }

            if (!in_array($campus, ['Makati', 'Cebu'], true)) {
                return ['success' => false, 'message' => 'Invalid campus.'];
            }

            if (mb_strlen($title) > 80 || mb_strlen($content) > 500) {
                return ['success' => false, 'message' => 'Title or content exceeds allowed length.'];
            }

            $id = $this -> confessionModel -> createConfession($userId, $title, $category, $campus, $content);
            return ['success' => true, 'id' => $id];
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