<!-- Tạo database và chọn dùng -->
CREATE DATABASE IF NOT EXISTS billiards
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE billiards;

 <!-- Bảng Tables – quản lý bàn bi-a -->
CREATE TABLE IF NOT EXISTS Tables (
  TableID      INT AUTO_INCREMENT PRIMARY KEY,
  TableName    VARCHAR(50) NOT NULL UNIQUE,               
  Status       ENUM('Available','Playing','Maintenance') NOT NULL DEFAULT 'Available',
  HourlyRate   DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  Description  TEXT NULL
) ENGINE=InnoDB;

CREATE INDEX idx_tables_status ON Tables (Status); -- Chỉ mục để tăng tốc truy vấn theo trạng thái bàn

<!-- Bảng Services – danh mục dịch vụ (đồ ăn/uống) -->
CREATE TABLE IF NOT EXISTS Services (
  ServiceID      INT AUTO_INCREMENT PRIMARY KEY,
  ServiceName    VARCHAR(100) NOT NULL,
  Price_Service  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  Category       ENUM('Drink','Food','Snack') NOT NULL,
  Numbers        INT NULL DEFAULT NULL            
) ENGINE=InnoDB;

CREATE INDEX idx_services_name ON Services (ServiceName); -- Chỉ mục để tăng tốc tìm kiếm dịch vụ theo tên

 <!-- Bảng Invoices – hóa đơn -->
CREATE TABLE IF NOT EXISTS Invoices (
  InvoiceID     INT AUTO_INCREMENT PRIMARY KEY,
  TableID       INT NOT NULL,
  StartTime     DATETIME NULL,       
  EndTime       DATETIME NULL,
  TimePlay      DECIMAL(5,2) NULL,   
  InvoiceDate   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  TotalAmount   DECIMAL(10,2) NOT NULL DEFAULT 0.00,   
  PaymentMethod ENUM('Cash','Card','Other') NULL,
  IsPaid        BOOLEAN NOT NULL DEFAULT 0,
  CONSTRAINT fk_invoices_table
    FOREIGN KEY (TableID) REFERENCES Tables(TableID)
    ON UPDATE CASCADE ON DELETE RESTRICT -- Khi bàn bị xóa, không xóa hóa đơn liên quan
) ENGINE=InnoDB;

CREATE INDEX idx_invoices_date  ON Invoices (InvoiceDate); -- Chỉ mục để tăng tốc truy vấn theo ngày hóa đơn
CREATE INDEX idx_invoices_paid  ON Invoices (IsPaid); -- Chỉ mục để tăng tốc truy vấn theo trạng thái thanh toán

 <!-- Bảng InvoiceDetails – chi tiết hóa đơn (dịch vụ hoặc dòng giờ chơi) -->
CREATE TABLE IF NOT EXISTS InvoiceDetails (
  InvoiceDetailID  INT AUTO_INCREMENT PRIMARY KEY,
  InvoiceID        INT NOT NULL,
  TableID          INT NOT NULL,
  ServiceID        INT NULL,           
  Numbers          INT NULL,           
  Price_Services   DECIMAL(12,2) NOT NULL,  
  Note             VARCHAR(255) NULL,
  CONSTRAINT fk_detail_invoice
    FOREIGN KEY (InvoiceID) REFERENCES Invoices(InvoiceID)
    ON UPDATE CASCADE ON DELETE CASCADE, -- Xóa chi tiết khi hóa đơn bị xóa
    
  CONSTRAINT fk_detail_table
    FOREIGN KEY (TableID) REFERENCES Tables(TableID)
    ON UPDATE CASCADE ON DELETE RESTRICT, -- Không xóa chi tiết khi bàn bị xóa

  CONSTRAINT fk_detail_service
    FOREIGN KEY (ServiceID) REFERENCES Services(ServiceID)
    ON UPDATE CASCADE ON DELETE RESTRICT -- Không xóa chi tiết khi dịch vụ bị xóa
    
) ENGINE=InnoDB;

CREATE INDEX idx_details_invoice ON InvoiceDetails (InvoiceID); -- Chỉ mục để tăng tốc truy vấn theo hóa đơn
CREATE INDEX idx_details_service ON InvoiceDetails (ServiceID); -- Chỉ mục để tăng tốc truy vấn theo dịch vụ

