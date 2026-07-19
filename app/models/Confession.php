<?php
    class Confession
    {
        private ?int $id;
        private string $title;
        private string $content;
        private string $category;
        private string $campus;
        private int $hearts;
        private string $status;
        private ?string $createdAt;
        private bool $liked;

        public function __construct(
            $id = null, 
            $title = '', 
            $content = '', 
            $category = 'Miscellaneous', 
            $campus = '',
            $hearts = 0, 
            $status = 'pending', 
            $createdAt = null,
            $liked = false
        ) {
            $this -> id = $id;
            $this -> title = $title;
            $this -> content = $content;
            $this -> category = $category;
            $this -> campus = $campus;
            $this -> hearts = $hearts;
            $this -> status = $status;
            $this -> createdAt = $createdAt;
            $this -> liked = $liked;
        }

        public function getId(): ?int { return $this -> id; }
        public function setId(?int $id): void { $this -> id = $id; }

        public function getTitle(): string { return $this -> title; }
        public function setTitle(string $title): void { $this -> title = $title; }

        public function getContent(): string { return $this -> content; }
        public function setContent(string $content): void { $this -> content = $content; }

        public function getCategory(): string { return $this -> category; }
        public function setCategory(string $category): void { $this -> category = $category; }

        public function getCampus(): string { return $this -> campus; }
        public function setCampus(string $campus): void { $this -> campus = $campus; }

        public function getHearts(): int { return $this -> hearts; }
        public function setHearts(int $hearts): void { $this -> hearts = $hearts; }

        public function getStatus(): string { return $this -> status; }
        public function setStatus(string $status) { $this -> status = $status; }

        public function getCreatedAt(): ?string { return $this -> createdAt; }
        public function setCreatedAt(string $createdAt) { $this -> createdAt = $createdAt; }

        public function isLiked(): bool { return $this -> liked; }
        public function getFormattedTime(): string
        {
            if ($this -> createdAt === null) return 'Just now';
            
            // formats time to 'Jan 1, 2026, 6:00AM'
            $date = new DateTime($this -> createdAt);
            return $date -> format('M j, Y, g:i A');
        }

        public function getAllConfessions(?int $userId = null): array
        {
            $pdo = Database::connect();

            if ($userId) {
                $stmt = $pdo -> prepare(
                    "SELECT c.*, (l.user_id IS NOT NULL) AS liked
                    FROM confessions c
                    LEFT JOIN confession_likes l
                        ON l.confession_id = c.id AND l.user_id = ?
                    WHERE c.status = 'approved'
                    ORDER BY c.id DESC"
                );
                $stmt -> execute([$userId]);
            } else {
                $stmt = $pdo -> query(
                    "SELECT c.*, 0 AS liked
                    FROM confessions c
                    WHERE c.status = 'approved'
                    ORDER BY c.id DESC"
                );
            }

            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
        }

        // for moderator dashboard, fetches confession on pending status
        public function getPendingConfessions(): array
        {
            $pdo = Database::connect();
            $stmt = $pdo -> query("SELECT * FROM confessions WHERE status = 'pending' ORDER BY id ASC");
            
            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
        }

        public function toggleHeart(int $userId, int $id, string $action): int
        {
            $pdo = Database::connect();

            if ($action === 'increment') 
            {
                $stmt = $pdo -> prepare("INSERT IGNORE INTO confession_likes (user_id, confession_id) VALUES (?, ?)");
                $stmt -> execute([$userId, $id]);

                // if the row count is greater than zero, it means the user hasn't liked the confession yet
                if ($stmt -> rowCount() > 0) {
                    $pdo -> prepare("UPDATE confessions SET hearts = hearts + 1 WHERE id = ? AND status = 'approved'") -> execute([$id]);
                }
            } 
            else 
            {
                $stmt = $pdo -> prepare("DELETE FROM confession_likes WHERE user_id = ? AND confession_id = ?");
                $stmt -> execute([$userId, $id]);

                // do not decrement if row count is 0, which means there's nothing to delete
                if ($stmt -> rowCount() > 0) {
                    $pdo -> prepare("UPDATE confessions SET hearts = GREATEST(0, hearts - 1) WHERE id = ? AND status = 'approved'") -> execute([$id]);
                }
            }

            $check = $pdo -> prepare("SELECT hearts FROM confessions WHERE id = ?");
            $check -> execute([$id]);
            return (int) $check -> fetchColumn();
        }

        // helper function that converts raw associative row to an object array
        private function toObjectArray(array $rows): array
        {
            $confessions = [];

            foreach ($rows as $row) 
            {
                $confessions[] = new Confession(
                    $row['id'],
                    $row['title'],
                    $row['content'],
                    $row['category'],
                    $row['campus'],
                    $row['hearts'],
                    $row['status'],
                    $row['created_at'],
                    $row['liked'] ?? false
                );
            }

            return $confessions;
        }
    }
?>