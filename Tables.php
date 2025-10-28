<?php
require_once 'BaseModel.php';

class TableModel extends BaseModel
{
    private string $table = 'Tables'; 

    /** Lấy toàn bộ bàn (tuỳ chọn lọc theo trạng thái) */
    public function getAll(?string $status = null): array
    {
        if ($status) {
            $sql = "SELECT * FROM {$this->table} WHERE Status = ? ORDER BY TableID ASC";
            return $this->fetchAll($sql, [$status]);
        }
        $sql = "SELECT * FROM {$this->table} ORDER BY TableID ASC";
        return $this->fetchAll($sql);
    }

    /** Lấy 1 bàn theo ID */
    public function getById(int $tableId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE TableID = ?";
        return $this->fetchOne($sql, [$tableId]);
    }

    /** Thêm bàn mới */
    public function insert(string $tableName, float $hourlyRate, ?string $description = null, string $status = 'Available'): bool
    {
        $sql = "INSERT INTO {$this->table} (TableName, Status, HourlyRate, Description)
                VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [$tableName, $status, $hourlyRate, $description]);
    }

    /** Cập nhật thông tin bàn */
    public function update(int $tableId, string $tableName, float $hourlyRate, string $status, ?string $description = null): bool
    {
        $sql = "UPDATE {$this->table}
                   SET TableName = ?, HourlyRate = ?, Status = ?, Description = ?
                 WHERE TableID = ?";
        return $this->execute($sql, [$tableName, $hourlyRate, $status, $description, $tableId]);
    }

    /** Cập nhật trạng thái bàn */
    public function updateStatus(int $tableId, string $status): bool
    {
        $sql = "UPDATE {$this->table} SET Status = ? WHERE TableID = ?";
        return $this->execute($sql, [$status, $tableId]);
    }

    /** Xoá bàn */
    public function delete(int $tableId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE TableID = ?";
        return $this->execute($sql, [$tableId]);
    }

    /** Tìm kiếm theo tên bàn hoặc trạng thái */
    public function search(string $keyword): array
    {
        $like = "%{$keyword}%";
        $sql  = "SELECT * FROM {$this->table}
                 WHERE TableName LIKE ? OR Status LIKE ?
                 ORDER BY TableID ASC";
        return $this->fetchAll($sql, [$like, $like]);
    }
}

?> 