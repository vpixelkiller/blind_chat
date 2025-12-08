CREATE DATABASE IF NOT EXISTS testdb;
USE testdb;

CREATE TABLE IF NOT EXISTS usuarios (
    user VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (user, password) 
VALUES ('test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE password = VALUES(password);

