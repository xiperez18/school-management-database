-- Create Person table first (Base table)
CREATE TABLE Person (
    personID INT PRIMARY KEY,
    SSN CHAR(9) UNIQUE,
    firstName VARCHAR(50),
    middleName VARCHAR(50),
    lastName VARCHAR(50),
    dateOfBirth DATE,
    address VARCHAR(100),
    city VARCHAR(50),
    state CHAR(2),
    postalCode VARCHAR(10),
    email VARCHAR(100),
    personalNumber VARCHAR(15)
);

CREATE TABLE StaffAdmin (
    staffAdminID INT PRIMARY KEY,
    personID INT,
    workNumber VARCHAR(15),
    FOREIGN KEY (personID) REFERENCES Person(personID)
);

CREATE TABLE Teachers (
    teacherID INT PRIMARY KEY,
    personID INT,
    staffAdminID INT,
    teachingSubject VARCHAR(50),
    gradeLevel VARCHAR(20),
    workNumber VARCHAR(15),
    FOREIGN KEY (personID) REFERENCES Person(personID),
    FOREIGN KEY (staffAdminID) REFERENCES StaffAdmin(staffAdminID)
);

CREATE TABLE Students (
    studentID INT PRIMARY KEY,
    personID INT,
    studentGrade VARCHAR(10),
    primaryTeacherID INT,
    studentPicture BLOB,
    enrollmentStatus VARCHAR(20),
    enrollmentDate DATE,
    FOREIGN KEY (personID) REFERENCES Person(personID),
    FOREIGN KEY (primaryTeacherID) REFERENCES Teachers(teacherID)
);

CREATE TABLE EmergencyContacts (
    studentID INT,
    personID INT,
    relationship VARCHAR(50),
    PRIMARY KEY (studentID, personID),
    FOREIGN KEY (studentID) REFERENCES Students(studentID),
    FOREIGN KEY (personID) REFERENCES Person(personID)
);

CREATE TABLE Parents (
    parentID INT PRIMARY KEY,
    personID INT,
    occupation VARCHAR(100),
    workNumber VARCHAR(15),
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
    studentID INT,
    parentID INT,
    relationship VARCHAR(50),
    PRIMARY KEY (studentID, parentID),
    FOREIGN KEY (studentID) REFERENCES Students(studentID),
    FOREIGN KEY (parentID) REFERENCES Parents(parentID)
);

CREATE TABLE Medicine (
    medicationID INT PRIMARY KEY,
    studentID INT,
    medicationName VARCHAR(100),
    dosage VARCHAR(50),
    administrationSchedule VARCHAR(100),
    startDate DATE,
    endDate DATE,
    FOREIGN KEY (studentID) REFERENCES Students(studentID)
);

CREATE TABLE Allergies (
    allergyID INT PRIMARY KEY,
    studentID INT,
    allergenName VARCHAR(100),
    severity VARCHAR(20),
    FOREIGN KEY (studentID) REFERENCES Students(studentID)
);

CREATE TABLE AllergySymptoms (
    allergyID INT,
    symptom VARCHAR(100),
    PRIMARY KEY (allergyID, symptom),
    FOREIGN KEY (allergyID) REFERENCES Allergies(allergyID)
);

CREATE TABLE AllergyMedication (
    allergyID INT,
    medicationID INT,
    PRIMARY KEY (allergyID, medicationID),
    FOREIGN KEY (allergyID) REFERENCES Allergies(allergyID),
    FOREIGN KEY (medicationID) REFERENCES Medicine(medicationID)
);

CREATE TABLE Vaccinations (
    vaccineID INT PRIMARY KEY,
    studentID INT,
    vaccineName VARCHAR(100),
    dateAdministered DATE,
    status VARCHAR(20),
    FOREIGN KEY (studentID) REFERENCES Students(studentID)
);
