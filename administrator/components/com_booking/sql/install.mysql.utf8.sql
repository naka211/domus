CREATE TABLE IF NOT EXISTS `#__booking` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`supplier_id` TINYINT(4)  NOT NULL ,
`first_name` VARCHAR(255)  NOT NULL ,
`last_name` VARCHAR(255)  NOT NULL ,
`house_id` VARCHAR(255)  NOT NULL ,
`information` TEXT NOT NULL ,
`checkin` VARCHAR(255)  NOT NULL ,
`checkout` VARCHAR(255)  NOT NULL ,
`total` VARCHAR(255)  NOT NULL ,
`booking_date` VARCHAR(255)  NOT NULL ,
`pay_30` TINYINT(4)  NOT NULL ,
`pay_all` TINYINT(4)  NOT NULL ,
`status` TINYINT(4)  NOT NULL ,
`number_of_persons` TINYINT(4)  NOT NULL ,
`address` TEXT NOT NULL ,
`zip` VARCHAR(255)  NOT NULL ,
`city` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`phone` VARCHAR(255)  NOT NULL ,
`comment` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

