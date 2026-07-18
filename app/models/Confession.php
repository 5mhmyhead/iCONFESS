<?php
    class Confession
    {
        private ?int $id;
        private string $title;
        private string $content;
        private string $category;
        private int $hearts;
        private string $status;
        private ?string $createdAt;

        public function __construct(
            $id = null, 
            $title = '', 
            $content = '', 
            $category = 'Miscellaneous', 
            $hearts = 0, 
            $status = 'pending', 
            $createdAt = null
        ) {
            $this -> id = $id;
            $this -> title = $title;
            $this -> content = $content;
            $this -> hearts = $hearts;
            $this -> createdAt = $createdAt;

            // pass through setters to format values
            $this -> setCategory($category);
            $this -> setStatus($status);
        }

        public function getId(): ?int { return $this -> id; }
        public function setId(?int $id): void { $this -> id = $id; }

        public function getTitle(): string { return $this -> title; }
        public function setTitle(string $title): void { $this -> title = $title; }

        public function getContent(): string { return $this -> content; }
        public function setContent(string $content): void { $this -> content = $content; }

        public function getCategory(): string { return $this -> category; }
        public function setCategory(string $category): void 
        { 
            // normalize the formatting of category string to match database
            // trim whitespace, set lowercase to all characters then capitalize the first letter
            $formattedCategory = ucfirst(strtolower(trim($category)));
            
            if (in_array($formattedCategory, ['Academic', 'Love', 'Drama', 'Miscellaneous'])) 
            {
                $this -> category = $formattedCategory; 
            }
            else
            {
                $this -> category = 'Miscellaneous';
            }  
        }

        public function getHearts(): int { return $this -> hearts; }
        public function setHearts(int $hearts): void { $this -> hearts = $hearts; }

        public function getStatus(): string { return $this -> status; }
        public function setStatus(string $status): void 
        { 
            $status = strtolower(trim($status));

            if (in_array($status, ['pending', 'approved', 'rejected'])) 
            {
                $this->status = $status;
            } 
        }

        public function getCreatedAt(): ?string { return $this -> createdAt; }
        public function getFormattedTime(): string
        {
            if ($this -> createdAt === null) return 'Just now';
            
            // formats time to 'Jan 1, 2026, 6:00AM'
            $date = new DateTime($this -> createdAt);
            return $date -> format('M j, Y, g:i A');
        }

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
                $confessions[] = new self(
                    (int) $row['id'],
                    $row['title'],
                    $row['content'],
                    $row['category'],
                    (int) $row['hearts'],
                    $row['status'],
                    $row['created_at']
                );
            }

            return $confessions;
        }
    }
?>