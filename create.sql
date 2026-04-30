-- create.sql
-- App-compatible schema for this project (XAMPP/MySQL)
-- Database name expected by db.php: school_db

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS StudentParents;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Parents;
DROP TABLE IF EXISTS Person;
DROP TABLE IF EXISTS students;

SET FOREIGN_KEY_CHECKS = 1;

-- Main student table used by CRUD pages and parent linking.
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender VARCHAR(20),
    grade VARCHAR(20),
    address VARCHAR(255),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(30),
    emergency_contact_relationship VARCHAR(50),
    email VARCHAR(100),
    phone VARCHAR(30),
    medical_notes TEXT,
    enrollment_status VARCHAR(20) DEFAULT 'Active',
    enrollment_date DATE DEFAULT (CURRENT_DATE)
);

-- Parent registration tables (used by process_registration.php and process_login.php)
CREATE TABLE Person (
    personID INT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    address VARCHAR(255),
    email VARCHAR(100)
);

CREATE TABLE Parents (
    parentID INT PRIMARY KEY,
    personID INT NOT NULL,
    occupation VARCHAR(100),
    workNumber VARCHAR(30),
    FOREIGN KEY (personID) REFERENCES Person(personID)
);

CREATE TABLE Users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    passwordHash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL,
    parentID INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parentID) REFERENCES Parents(parentID)
);

CREATE TABLE StudentParents (
    student_id INT,
    parentID INT,
    relationship VARCHAR(50),
    PRIMARY KEY (student_id, parentID),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (parentID) REFERENCES Parents(parentID)
);
