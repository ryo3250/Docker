CREATE USER IF NOT EXISTS 'data_user'@'%' IDENTIFIED BY 'data';
GRANT ALL PRIVILEGES ON * . * TO 'data_user'@'%';

DROP DATABASE IF EXISTS test_db;
CREATE DATABASE IF NOT EXISTS test_db;

use test_db;

DROP TABLE IF EXISTS test_table;
CREATE TABLE IF NOT EXISTS test_table (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    example_number INT,
    example_message VARCHAR(255)
);

insert into test_table (id, name, example_number, example_message) values (1, 'test1', 10, 'message1');
insert into test_table (id, name, example_number, example_message) values (2, 'test2', 20, 'message2');
insert into test_table (id, name, example_number, example_message) values (3, 'test3', 30, 'message3');

DROP DATABASE IF EXISTS data_master;
CREATE DATABASE IF NOT EXISTS data_master;

use data_master;

DROP TABLE IF EXISTS students;
CREATE TABLE IF NOT EXISTS students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(255),
    class_id INT
);

DROP TABLE IF EXISTS classes;
CREATE TABLE IF NOT EXISTS classes (
    class_id INT PRIMARY KEY,
    class_name VARCHAR(255)
);

insert into students (student_id, student_name, class_id) values (1, 'Tanaka', 1);
insert into students (student_id, student_name, class_id) values (2, 'Sato', 1);
insert into students (student_id, student_name, class_id) values (3, 'Suzuki', 2);
insert into students (student_id, student_name, class_id) values (4, 'Kimura', 2);

insert into classes (class_id, class_name) values (1, 'Programmer Class');
insert into classes (class_id, class_name) values (2, 'Designer Class');

insert into students (student_id, student_name, class_id) values (5, 'Takagi', 3);