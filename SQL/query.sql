/*
**
**	CREATE Table
**
*/
CREATE TEMP TABLE users(id bigserial, group_id bigint);
/*
**
**	INSERT Table users
**
*/
INSERT INTO users(group_id) values (1), (1), (1), (2), (1), (3);

/*
**
**	GET All Count
**
*/
SELECT count(id) FROM users

/*
**
**	GET Continuous sequences
**
*/
SELECT col FROM 
	(SELECT group_id AS col, LEAD(group_id, 1, group_id - 1) OVER(order BY id) AS col2 FROM users) AS users 
	WHERE col <> col2