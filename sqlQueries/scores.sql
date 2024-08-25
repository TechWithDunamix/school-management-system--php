CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(255) NOT NULL,
    class_id INT NOT NULL
);

CREATE TABLE scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    score DECIMAL(5, 2) NOT NULL
);

CREATE TABLE tests (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    test_name VARCHAR(255) NOT NULL,
    test_date DATE NOT NULL,
    subject_id INT NOT NULL
);

CREATE TABLE test_scores (
    test_score_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    test_id INT NOT NULL,
    score DECIMAL(5, 2) NOT NULL
);
