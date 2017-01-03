Factory Testings

// User table
INSERT INTO user(user_name, user_pass, role_id) VALUES('jess', 'jess123', 1);
INSERT INTO user(user_name, user_pass, role_id) VALUES('faith', 'faith123', 1);
INSERT INTO user(user_name, user_pass, role_id) VALUES('teacher', 'teach', 2);

// Student table
INSERT INTO student(user_id, email_address, firstname, lastname) VALUES(1, 'jess@gmail.com', 'Jess Noel', 'Augusto');
INSERT INTO student(user_id, email_address, firstname, lastname) VALUES(2, 'faith@gmail.com', 'Christine Faith', 'Varron');

// Course table
INSERT INTO course(course_name, age_range) VALUES('Flexkids', '8-12');

// Level table
INSERT INTO level(course_id, level_name, num_session) VALUES(1, 'FK3', 72);

// Student_Class_Info table
INSERT INTO student_class_info(student_id, course_id, level_id, lesson_num) VALUES(1, 1, 1, 36);
INSERT INTO student_class_info(student_id, course_id, level_id, lesson_num) VALUES(2, 1, 1, 36);

// Student_Hours table
INSERT INTO student_hours(student_id, hours_enrolled, hours_used) VALUES(1, 72, 24);
INSERT INTO student_hours(student_id, hours_enrolled, hours_used) VALUES(2, 33, 6);

// User_Role table
INSERT INTO user_type(user_type) VALUES('student');
INSERT INTO user_type(user_type) VALUES('teacher');
INSERT INTO user_type(user_type) VALUES('acad');
INSERT INTO user_type(user_type) VALUES('agent');

// Teacher table
INSERT INTO teacher(user_id, email_address, firstname, lastname) VALUES(3, 'teacher@gmail.com', 'Teacher 101', 'Teach');



// In Order Insertion
INSERT INTO user_type(user_type) VALUES('student');
INSERT INTO user_type(user_type) VALUES('teacher');
INSERT INTO user_type(user_type) VALUES('acad');
INSERT INTO user_type(user_type) VALUES('agent');

INSERT INTO user(user_name, user_pass, role_id) VALUES('jess', 'jess123', 1);
INSERT INTO user(user_name, user_pass, role_id) VALUES('faith', 'faith123', 1);
INSERT INTO user(user_name, user_pass, role_id) VALUES('teacher', 'teach', 2);

INSERT INTO student(user_id, email_address, firstname, lastname) VALUES(1, 'jess@gmail.com', 'Jess Noel', 'Augusto');
INSERT INTO student(user_id, email_address, firstname, lastname) VALUES(2, 'faith@gmail.com', 'Christine Faith', 'Varron');
INSERT INTO student(user_id, email_address, firstname, lastname) VALUES(3, 'teacher@gmail.com', 'Teacher 101', 'Teach');

INSERT INTO course(course_name, age_range) VALUES('Flexkids', '8-12');

INSERT INTO level(course_id, level_name, num_session) VALUES(1, 'FK3', 72);

INSERT INTO student_class_info(student_id, course_id, level_id, lesson_num) VALUES(1, 1, 1, 36);
INSERT INTO student_class_info(student_id, course_id, level_id, lesson_num) VALUES(2, 1, 1, 36);

INSERT INTO student_hours(student_id, hours_enrolled, hours_used) VALUES(1, 72, 24);
INSERT INTO student_hours(student_id, hours_enrolled, hours_used) VALUES(2, 33, 6);


CREATE VIEW v_StudentAccountInfo AS 
SELECT s.user_id, s.student_id, u.user_name, u.user_pass, ur.user_type, 
s.email_address, CONCAT(s.firstname, ' ', s.lastname) AS fullname, s.photo 
FROM student AS s 
JOIN user AS u ON (s.user_id = u.user_id)
JOIN user_type as ur ON (u.role_id = ur.role_id);

CREATE VIEW v_StudentClassInfo AS
SELECT sc.student_id AS student_id, c.course_name AS course_name, l.level_name AS level_name,
sc.lesson_num AS lesson_num, (sh.hours_enrolled - sh.hours_used) AS hours_left, sc.class_status AS class_status, sc.origin AS origin 
FROM student_class_info sc
JOIN student_hours sh ON (sc.student_id = sh.student_id) 
JOIN course c ON (sc.course_id = c.course_id) 
JOIN level l ON (sc.level_id = l.level_id);

DELIMITER $$
CREATE TRIGGER update_class_status AFTER UPDATE ON student_hours 
FOR EACH ROW BEGIN
	/** After updating the hours_used, retrieve the hours left **/
    SET @hours_left = (SELECT (hours_enrolled - hours_used) FROM student_hours WHERE student_id = NEW.student_id);

    /** If @hours_left is 0 then update class_status to inactive else active **/
    UPDATE student_class_info 
	SET class_status = IF(@hours_left = 0, 'inactive', 'active')
	WHERE student_id = NEW.student_id;
END$$
DELIMITER ;