CREATE DATABASE IF NOT EXISTS lab9 CHARACTER SET utf8 COLLATE utf8_general_ci;
USE lab9;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (nickname) VALUES ('alice'), ('bob'), ('charlie');

INSERT INTO articles (title, content, user_id) VALUES
('Первая статья', 'Содержимое первой статьи...', 1),
('Вторая статья', 'Содержимое второй статьи...', 2),
('Третья статья', 'Содержимое третьей статьи...', 1);