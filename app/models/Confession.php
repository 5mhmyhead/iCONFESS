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
        private array $reports = [];

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

        public function setReports(array $reports): void { $this -> reports = $reports; }
        public function getReports(): array { return $this -> reports; }

        public function isLiked(): bool { return $this -> liked; }
        public function getFormattedTime(): string
        {
            if ($this -> createdAt === null) return 'Just now';
            
            // formats time to 'Jan 1, 2026, 6:00AM'
            $date = new DateTime($this -> createdAt);
            return $date -> format('M j, Y, g:i A');
        }

        // for moderator dashboard, fetches confession on pending status
        public function getPendingConfessions(): array
        {
            $pdo = Database::connect();
            $stmt = $pdo -> query("SELECT * FROM confessions WHERE status = 'pending' ORDER BY id ASC");
            
            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
        }

        public function getConfessionsByTitle(string $keyword): array
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare("SELECT * FROM confessions WHERE status = 'approved' AND title LIKE ? ORDER BY created_at DESC");
            $stmt -> execute(['%' . $keyword . '%']);

            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
        }

        public function getTotalConfessions(): int
        {
            $pdo = Database::connect();

            $totalStmt = $pdo -> query("SELECT COUNT(*) FROM confessions");
            $totalConfessions = (int) $totalStmt -> fetchColumn();

            return $totalConfessions;
        }

        public function getWeeklyConfessions(): int
        {
            $pdo = Database::connect();

            $weeklyStmt = $pdo -> query("SELECT COUNT(*) FROM confessions WHERE created_at >= NOW() - INTERVAL 7 DAY");
            $weeklyConfessions = (int) $weeklyStmt -> fetchColumn();

            return $weeklyConfessions;
        }

        public function getFilteredConfessions(
            string $category,
            string $campus,
            string $sort,
            string $keyword,
            ?int $userId = null,
            int $page = 1,
            int $perPage = 20
        ): array {
            $pdo = Database::connect();
            $offset = ($page - 1) * $perPage;

            $where = ["c.status = 'approved'"];
            $params = [];

            if ($category !== '') 
            {
                $where[] = 'c.category = ?';
                $params[] = $category;
            }

            if ($campus !== '') 
            {
                $where[] = 'c.campus = ?';
                $params[] = $campus;
            }

            if ($keyword !== '') 
            {
                $where[] = '(c.title LIKE ? OR c.content LIKE ?)';
                $params[] = '%' . $keyword . '%';
                $params[] = '%' . $keyword . '%';
            }

            if ($sort === 'hot') 
            {
                $where[] = 'c.created_at >= NOW() - INTERVAL 7 DAY';
                $orderBy = 'c.hearts DESC, c.created_at DESC';
            } 
            elseif ($sort === 'top') 
            {
                $orderBy = 'c.hearts DESC';
            } 
            else 
            {
                $orderBy = 'c.created_at DESC';
            }

            $likeSelect = $userId ? '(l.user_id IS NOT NULL) AS liked' : '0 AS liked';
            $likeJoin = $userId ? 'LEFT JOIN confession_likes l ON l.confession_id = c.id AND l.user_id = ?' : '';

            $sql = "SELECT c.*, $likeSelect FROM confessions c $likeJoin WHERE " . implode(' AND ', $where) . " ORDER BY $orderBy LIMIT ? OFFSET ?";

            $stmt = $pdo -> prepare($sql);

            $i = 1;
            if ($userId) 
            {
                $stmt -> bindValue($i++, $userId, PDO::PARAM_INT);
            }

            foreach ($params as $param) 
            {
                $stmt -> bindValue($i++, $param, PDO::PARAM_STR);
            }

            $stmt -> bindValue($i++, $perPage, PDO::PARAM_INT);
            $stmt -> bindValue($i++, $offset, PDO::PARAM_INT);
            $stmt -> execute();

            return $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));
        }

        public function countFilteredConfessions(string $category, string $campus, string $sort, string $keyword): int
        {
            $pdo = Database::connect();

            $where = ["status = 'approved'"];
            $params = [];

            if ($category !== '') 
            { 
                $where[] = 'category = ?'; $params[] = $category; 
            }
            
            
            if ($campus !== '') 
            { 
                $where[] = 'campus = ?'; $params[] = $campus; 
            }
            
            
            if ($keyword !== '') 
            { 
                $where[] = '(title LIKE ? OR content LIKE ?)'; $params[] = "%$keyword%"; $params[] = "%$keyword%"; 
            }
            
            
            if ($sort === 'hot') 
            { 
                $where[] = 'created_at >= NOW() - INTERVAL 7 DAY'; 
            }

            $stmt = $pdo -> prepare('SELECT COUNT(*) FROM confessions WHERE ' . implode(' AND ', $where));
            $stmt -> execute($params);

            return (int) $stmt -> fetchColumn();
        }

        public function getModerationQueue(string $status, string $category, string $campus, string $keyword, int $page = 1, int $perPage = 20): array
        {
            $pdo = Database::connect();
            $offset = ($page - 1) * $perPage;

            $where = [];
            $params = [];

            if ($status === 'flagged') {
                $where[] = "EXISTS (SELECT 1 FROM reports r WHERE r.confession_id = c.id AND r.status = 'pending')";
            } else {
                $validStatuses = ['pending', 'approved', 'rejected'];
                $where[] = 'c.status = ?';
                $params[] = in_array($status, $validStatuses, true) ? $status : 'pending';
            }

            if ($category !== '') { $where[] = 'c.category = ?'; $params[] = $category; }
            if ($campus !== '') { $where[] = 'c.campus = ?'; $params[] = $campus; }
            if ($keyword !== '') { $where[] = '(c.title LIKE ? OR c.content LIKE ?)'; $params[] = "%$keyword%"; $params[] = "%$keyword%"; }

            $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

            $sql = "SELECT c.* FROM confessions c $whereSql ORDER BY c.id ASC LIMIT ? OFFSET ?";

            $stmt = $pdo -> prepare($sql);
            $i = 1;
            foreach ($params as $param) { $stmt -> bindValue($i++, $param, PDO::PARAM_STR); }
            $stmt -> bindValue($i++, $perPage, PDO::PARAM_INT);
            $stmt -> bindValue($i++, $offset, PDO::PARAM_INT);
            $stmt -> execute();

            $confessions = $this -> toObjectArray($stmt -> fetchAll(PDO::FETCH_ASSOC));

            // for the flagged tab, attach each confession's pending reports
            if ($status === 'flagged' && $confessions) {
                $ids = array_map(fn($c) => $c -> getId(), $confessions);
                $placeholders = implode(',', array_fill(0, count($ids), '?'));

                $reportStmt = $pdo -> prepare(
                    "SELECT * FROM reports WHERE confession_id IN ($placeholders) AND status = 'pending' ORDER BY created_at ASC"
                );
                $reportStmt -> execute($ids);
                $allReports = $reportStmt -> fetchAll(PDO::FETCH_ASSOC);

                // group reports by id
                $reportsByConfession = [];
                foreach ($allReports as $r) {
                    $reportsByConfession[$r['confession_id']][] = $r;
                }

                foreach ($confessions as $confession) {
                    $confession -> setReports($reportsByConfession[$confession -> getId()] ?? []);
                }
            }

            return $confessions;
        }

        public function countModerationQueue(string $status, string $category, string $campus, string $keyword): int
        {
            $pdo = Database::connect();

            $where = [];
            $params = [];
            $joinReports = '';

            if ($status === 'flagged') {
                $joinReports = "INNER JOIN (SELECT DISTINCT confession_id FROM reports WHERE status = 'pending') r ON r.confession_id = c.id";
            } else {
                $validStatuses = ['pending', 'approved', 'rejected'];
                $where[] = 'c.status = ?';
                $params[] = in_array($status, $validStatuses, true) ? $status : 'pending';
            }

            if ($category !== '') { $where[] = 'c.category = ?'; $params[] = $category; }
            if ($keyword !== '') { $where[] = '(c.title LIKE ? OR c.content LIKE ?)'; $params[] = "%$keyword%"; $params[] = "%$keyword%"; }
            if ($campus !== '') { $where[] = 'c.campus = ?'; $params[] = $campus; }

            $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

            $stmt = $pdo -> prepare("SELECT COUNT(*) FROM confessions c $joinReports $whereSql");
            $stmt -> execute($params);

            return (int) $stmt -> fetchColumn();
        }

        public function createConfession(int $userId, string $title, string $category, string $campus, string $content): int
        {
            $pdo = Database::connect();

            $stmt = $pdo -> prepare(
                "INSERT INTO confessions (user_id, title, content, category, campus, status)
                VALUES (?, ?, ?, ?, ?, 'approved')"
            );
            // status set to approved for now for testing
            // swap to pending when moderator is wired
            $stmt -> execute([$userId, $title, $content, $category, $campus]);

            return (int) $pdo -> lastInsertId();
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

        // helper functions for metrics
        public function countAllConfessions(): int
        {
            $pdo = Database::connect();
            return (int) $pdo -> query("SELECT COUNT(*) FROM confessions") -> fetchColumn();
        }

        public function countConfessionsToday(): int
        {
            $pdo = Database::connect();
            return (int) $pdo -> query("SELECT COUNT(*) FROM confessions WHERE DATE(created_at) = CURDATE()") -> fetchColumn();
        }

        public function countByStatus(string $status): int
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare("SELECT COUNT(*) FROM confessions WHERE status = ?");
            $stmt -> execute([$status]);
            return (int) $stmt -> fetchColumn();
        }

        public function countFlaggedConfessions(): int
        {
            // "flagged" = confessions with at least one pending report against them
            $pdo = Database::connect();
            return (int) $pdo -> query(
                "SELECT COUNT(DISTINCT confession_id) FROM reports WHERE status = 'pending'"
            ) -> fetchColumn();
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