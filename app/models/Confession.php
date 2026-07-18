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

        public function __construct(
            $id = null, 
            $title = '', 
            $content = '', 
            $category = 'Miscellaneous', 
            $campus = '',
            $hearts = 0, 
            $status = 'pending', 
            $createdAt = null
        ) {
            $this -> id = $id;
            $this -> title = $title;
            $this -> content = $content;
            $this -> category = $category;
            $this -> campus = $campus;
            $this -> hearts = $hearts;
            $this -> status = $status;
            $this -> createdAt = $createdAt;
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

        public function getAllConfessions(): array
        {
            $pdo = Database::connect();
            $stmt = $pdo -> query("SELECT * FROM confessions WHERE status = 'approved' ORDER BY id DESC");
            
            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
        }

        // for moderator dashboard, fetches confession on pending status
        public function getPendingConfessions(): array
        {
            $pdo = Database::connect();
            $stmt = $pdo -> query("SELECT * FROM confessions WHERE status = 'pending' ORDER BY id ASC");
            
            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
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
                    $row['created_at']
                );
            }

            return $confessions;
        }
    }
?>