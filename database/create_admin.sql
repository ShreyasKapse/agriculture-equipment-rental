-- Create a default admin user
-- Password is 'admin123'
INSERT INTO users (full_name, email, password_hash, phone, address, role) 
VALUES 
('System Admin', 'admin@aers.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0000000000', 'Admin HQ', 'admin');
