<?php
/**
 * BaseModel.php
 * Lớp nền tảng cho tất cả các model trong hệ thống Quản lý Billiards Club.
 * Nhiệm vụ:
 *  - Quản lý kết nối CSDL (PDO)
 *  - Cung cấp các hàm truy vấn chung: fetchOne, fetchAll, execute, ...
 *  - Hỗ trợ transaction cho các nghiệp vụ nhiều bước (checkout, endSession,...)
 */

use PDO;
use PDOException;

abstract class BaseModel
{
    /** @var PDO */
    protected PDO $db;

    public function __construct()
    {
        // Kết nối tới database khi khởi tạo model
        $this->db = self::connect();
    }

    /* ===========================
     * Kết nối CSDL qua PDO
     * =========================== */
    protected static function connect(): PDO
    {
        $host = 'localhost';     // Tên máy chủ MySQL
        $dbname = 'billiards';   // Tên cơ sở dữ liệu
        $user = 'root';          // Tài khoản MySQL
        $pass = '';              // Mật khẩu (để trống nếu dùng XAMPP)
        $charset = 'utf8mb4';    // Hỗ trợ tiếng Việt

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            echo "Kết nối cơ sở dữ liệu thành công!";
            return $pdo;
        } catch (PDOException $e) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
        }
    }

    /* ===========================
     * Các hàm truy vấn cơ bản
     * =========================== */

    /** Thực thi câu lệnh SQL và trả về PDOStatement */
    protected function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /** Lấy 1 dòng dữ liệu */
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /** Lấy nhiều dòng dữ liệu */
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /** Thực hiện thêm/sửa/xóa (không trả kết quả) */
    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /** Trả về ID vừa insert */
    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }

    /* ===========================
     * Transaction hỗ trợ nghiệp vụ
     * =========================== */

    protected function begin(): void
    {
        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }
    }

    protected function commit(): void
    {
        if ($this->db->inTransaction()) {
            $this->db->commit();
        }
    }

    protected function rollBack(): void
    {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
    }

    /* ===========================
     * Các tiện ích khác
     * =========================== */

    /** Phân trang dữ liệu */
    protected function paginate(string $baseSql, array $params = [], int $page = 1, int $perPage = 10): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $countSql = "SELECT COUNT(*) AS total FROM ({$baseSql}) AS temp";
        $total = (int)($this->fetchOne($countSql, $params)['total'] ?? 0);

        $pagedSql = $baseSql . " LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($pagedSql);

        foreach ($params as $key => $value) {
            is_int($key)
                ? $stmt->bindValue($key + 1, $value)
                : $stmt->bindValue(':' . ltrim($key, ':'), $value);
        }

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'pages' => ceil($total / $perPage)
        ];
    }

    /** Lấy thời điểm hiện tại của máy chủ DB */
    protected function now(): string
    {
        $row = $this->fetchOne("SELECT NOW() AS current_time");
        return $row['current_time'] ?? date('Y-m-d H:i:s');
    }
}
?>
