CREATE DATABASE biblioteca;
USE biblioteca;
CREATE TABLE userAccess (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    published_year INT NOT NULL,
    genre VARCHAR(50) NOT NULL,
    ubication ENUM('PASILLO A', 'PASILLO B') NOT NULL
);
create Table loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    university_degree VARCHAR(100) NOT NULL,
    book_name VARCHAR(100) NOT NULL,
    loan_date DATE NOT NULL,
    return_date DATE
);

insert INTO useraccess (email, password) VALUES ('jbcompany@gmail.com','1234');