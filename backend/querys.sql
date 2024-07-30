-- sql for creation of user tables
CREATE TABLE `sms_test`.`users` ( `email` VARCHAR(190) NOT NULL , `hashedpassword` INT NOT NULL , `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `first_name` VARCHAR(190) NOT NULL , `last_name` VARCHAR(190) NULL ) ENGINE = InnoDB;
