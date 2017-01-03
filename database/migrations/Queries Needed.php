/** Student Account Info View **/
CREATE VIEW v_StudentAccountInfo AS 
SELECT s.user_id, s.student_id, u.user_name, u.user_pass, ur.user_type, 
s.email_address, CONCAT(s.firstname, ' ', s.lastname) AS fullname, s.photo 
FROM student AS s 
JOIN user AS u ON (s.user_id = u.user_id)
JOIN user_type as ur ON (u.role_id = ur.role_id);


/** Student Class Info View **/
CREATE VIEW v_StudentClassInfo AS
SELECT sc.student_id AS student_id, c.course_name AS course_name, l.level_name AS level_name,
sc.lesson_num AS lesson_num, (sh.hours_enrolled - sh.hours_used) AS hours_left, sc.class_status AS class_status, sc.origin AS origin 
FROM student_class_info sc
JOIN student_hours sh ON (sc.student_id = sh.student_id) 
JOIN course c ON (sc.course_id = c.course_id) 
JOIN level l ON (sc.level_id = l.level_id);


/** On Student adding class schedule trigger **/
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


NOTE:
	- Always check the foreign keys to determine if the table is a child table or the base table.
	- A row in base table cannot be deleted without deleting first the related data in the child table.

	/* TRIGGERS */
	- When the student adds a class schedule, the student's class will automatically be determined according to his/her hours_left