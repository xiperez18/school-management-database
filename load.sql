-- load.sql
-- Sample starter data for the app-compatible schema in create.sql

INSERT INTO students (
    first_name, last_name, gender, grade, address,
    emergency_contact_name, emergency_contact_phone, emergency_contact_relationship,
    email, phone, medical_notes, enrollment_status, enrollment_date
) VALUES
    ('Alice', 'Brown', 'Female', '5', '123 Maple St',
     'Sarah Brown', '555-2001', 'Mother',
     'alice.brown@example.com', '555-1001', 'Peanut allergy', 'Active', '2023-08-15'),
    ('John', 'Smith', 'Male', '5', '456 Oak St',
     'David Smith', '555-2002', 'Father',
     'john.smith@example.com', '555-1002', '', 'Active', '2023-08-15'),
    ('Emma', 'Davis', 'Female', '4', '789 Pine St',
     'Laura Davis', '555-2003', 'Mother',
     'emma.davis@example.com', '555-1003', 'Asthma', 'Active', '2023-08-15');

-- Optional demo parent account (password is bcrypt hash of: parent123)
INSERT INTO Person (personID, firstName, lastName, address, email) VALUES
    (1, 'Sample', 'Parent', '900 Family Ave', 'parent@example.com');

INSERT INTO Parents (parentID, personID, occupation, workNumber) VALUES
    (1, 1, 'Parent', '555-9000');

INSERT INTO StudentParents (student_id, parentID, relationship) VALUES
    (1, 1, 'mother');

INSERT INTO Users (email, passwordHash, role, parentID) VALUES
    ('parent@example.com', '$2y$10$WPqVx6j53wlvMZ9hXPE0w.h9jD57L7z5.J6Qw95AOFYeuDvvS3j2y', 'parent', 1);

-- Demo teacher account (password: parent123)
INSERT INTO Users (email, passwordHash, role, parentID) VALUES
    ('teacher@example.com', '$2y$10$WPqVx6j53wlvMZ9hXPE0w.h9jD57L7z5.J6Qw95AOFYeuDvvS3j2y', 'teacher', NULL);
