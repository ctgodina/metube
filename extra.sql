/* THIS FILE IS JUST FOR REFERENCE ON WHAT SQL WAS ADDED MANUALLY TO THE DATABASE */

/* BLOCK USER TRIGGER */
DROP TRIGGER IF EXISTS ins_blocked;
delimiter |
CREATE TRIGGER ins_blocked AFTER INSERT ON blocked
FOR EACH ROW 
BEGIN
    DELETE FROM friends WHERE fname1=NEW.uname1 AND fname2=NEW.uname2;
    DELETE FROM friends WHERE fname2=NEW.uname1 AND fname1=NEW.uname2;
END;
|
delimiter ;
/*END TRIGGER */



/* FRIENDING BLOCKED USER ACTS LIKE UNBLOCKING + FRIENDING */
DROP TRIGGER IF EXISTS friend_block;
delimiter |
CREATE TRIGGER friend_block AFTER INSERT ON friends
FOR EACH ROW 
BEGIN
	DELETE FROM blocked WHERE uname1=NEW.fname1 AND uname2=NEW.fname2;
END;
|
delimiter ;
/* END TRIGGER */

/*UNIQUE INDEX eliminate multiple entries*/
CREATE UNIQUE INDEX uniqueblocks 
ON blocked (uname1, uname2)
/*END INDEX*/