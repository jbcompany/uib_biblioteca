CREATE DATABASE IF NOT EXISTS biblioteca_test;
USE biblioteca_test;

CREATE TABLE IF NOT EXISTS userAccess (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    published_year INT NOT NULL,
    genre VARCHAR(50) NOT NULL,
    ubication VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    university_degree VARCHAR(100) NOT NULL,
    book_name VARCHAR(100) NOT NULL,
    loan_date DATE NOT NULL,
    return_date DATE
);

INSERT INTO userAccess (email, password)
SELECT 'jbcompany@gmail.com', '1234'
WHERE NOT EXISTS (
    SELECT 1 FROM userAccess WHERE email = 'jbcompany@gmail.com'
);
