<?php
    class Report
    {
        private ?int $id;
        private int $confessionId;
        private int $userId;
        private string $reason;
        private ?string $customReason;
        private string $status;
        private ?string $createdAt;

        public function __construct(
            ?int $id = null,
            int $confessionId = 0,
            int $userId = 0,
            string $reason = 'Spam',
            ?string $customReason = null,
            string $status = 'pending',
            ?string $createdAt = null
        ) {
            $this -> id = $id;
            $this -> confessionId = $confessionId;
            $this -> userId = $userId;
            $this -> reason = $reason;
            $this -> customReason = $customReason;
            $this -> status = $status;
            $this -> createdAt = $createdAt;
        }

        public function getId(): ?int { return $this -> id; }
        public function setId(?int $id): void { $this -> id = $id; }

        public function getConfessionId(): int { return $this -> confessionId; }
        public function setConfessionId(int $confessionId): void { $this -> confessionId = $confessionId; }

        public function getUserId(): int { return $this -> userId; }
        public function setUserId(int $userId): void { $this -> userId = $userId; }

        public function getReason(): string { return $this -> reason; }
        public function setReason(string $reason): void { $this -> reason = $reason; }

        public function getCustomReason(): ?string { return $this -> customReason; }
        public function setCustomReason(?string $customReason): void { $this -> customReason = $customReason; }

        public function getStatus(): string { return $this->status; }
        public function setStatus(string $status): void { $this -> status = $status; }

        public function getCreatedAt(): ?string { return $this -> createdAt; }
        public function setCreatedAt(?string $createdAt): void { $this -> createdAt = $createdAt; }

        public function getFormattedTime(): string
        {
            if ($this -> createdAt === null) return 'Just now';

            $date = new DateTime($this -> createdAt);
            return $date -> format('M j, Y, g:i A');
        }

        public function createReport(?int $userId, int $confessionId, string $reason, ?string $customReason): int
        {
            $pdo = Database::connect();

            $stmt = $pdo -> prepare("INSERT INTO reports (confession_id, user_id, reason, custom_reason) VALUES (?, ?, ?, ?)");
            $stmt -> execute([$confessionId, $userId, $reason, $customReason]);

            return (int) $pdo -> lastInsertId();
        }
    }
?>