CREATE TABLE apartments (
    apartment_id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) NOT NULL,
    monthly_rent DECIMAL(10, 2) NOT NULL,
    available BOOLEAN DEFAULT 1
);

CREATE TABLE tenants (
    tenant_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    apartment_id INT NOT NULL,
    lease_start DATE NOT NULL,
    lease_end DATE NOT NULL,
    FOREIGN KEY (apartment_id) REFERENCES apartments(apartment_id) ON DELETE CASCADE
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'tenant') NOT NULL,
    tenant_id INT, -- This is NULL for admins
    FOREIGN KEY (tenant_id) REFERENCES tenants(tenant_id) ON DELETE CASCADE
);

CREATE TABLE maintenance_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT NOT NULL,
    complaint TEXT NOT NULL,
    request_date DATE NOT NULL,
    FOREIGN KEY (tenant_id) REFERENCES tenants(tenant_id) ON DELETE CASCADE
);

CREATE TABLE paid_rents (
    rent_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    utr_no VARCHAR(100) NOT NULL,  -- UTR number for tracking payments
    payment_method ENUM('UPI', 'IMPS', 'Bank Transfer') NOT NULL,
    FOREIGN KEY (tenant_id) REFERENCES tenants(tenant_id) ON DELETE CASCADE
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT NOT NULL,
    user_id INT NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (tenant_id) REFERENCES tenants(tenant_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

INSERT INTO apartments (address, monthly_rent, available) 
VALUES 
('123 Maple Street', 1200.00, 1),
('456 Oak Avenue', 1500.00, 1),
('789 Pine Drive', 900.00, 1);

INSERT INTO tenants (name, email, phone, apartment_id, lease_start, lease_end) 
VALUES 
('John Doe', 'john.doe@example.com', '1234567890', 1, '2023-01-01', '2024-01-01'),
('Jane Smith', 'jane.smith@example.com', '9876543210', 2, '2023-02-01', '2024-02-01'),
('Alice Johnson', 'alice.johnson@example.com', '5551234567', 3, '2023-03-01', '2024-03-01');

-- Insert an admin user
INSERT INTO users (username, password, role, tenant_id)
VALUES 
('admin', 'adminpassword', 'admin', NULL);

-- Insert tenant users
INSERT INTO users (username, password, role, tenant_id) 
VALUES 
('johndoe', 'johnpassword', 'tenant', 1),
('janesmith', 'janepassword', 'tenant', 2),
('alicejohnson', 'alicepassword', 'tenant', 3);

INSERT INTO paid_rents (tenant_id, payment_date, amount, utr_no, payment_method)
VALUES 
(1, '2024-01-01', 1200.00, 'UTR123456', 'UPI'),
(2, '2024-01-01', 1500.00, 'UTR987654', 'IMPS'),
(3, '2024-01-01', 900.00, 'UTR555123', 'Bank Transfer');

INSERT INTO maintenance_requests (tenant_id, complaint, request_date)
VALUES 
(1, 'Leaky faucet in the bathroom', '2024-01-05'),
(2, 'Broken window in the living room', '2024-01-06'),
(3, 'Electrical issues in the kitchen', '2024-01-07');

INSERT INTO payments (tenant_id, user_id, payment_date, amount)
VALUES 
(1, 1, '2024-01-01', 1200.00), 
(2, 1, '2024-01-02', 1500.00),
(3, 1, '2024-01-03', 900.00), 
(1, 2, '2024-01-10', 1200.00),
(2, 3, '2024-01-10', 1500.00); 
