-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

SET NAMES utf8mb4;

-- -----------------------------------------------------
-- Schema pec_database
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `pec_database` ;

-- -----------------------------------------------------
-- Schema pec_database
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pec_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_vi_0900_ai_ci ;
USE `pec_database` ;

-- -----------------------------------------------------
-- Table `Students`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Students` ;

CREATE TABLE IF NOT EXISTS `Students` (
  `studentID` INT UNSIGNED NOT NULL,
  `username` VARCHAR(16) NULL,
  `firstName` VARCHAR(30) NULL,
  `lastName` VARCHAR(30) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phoneNumber` VARCHAR(15) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `school` ENUM('UET', 'ULIS', 'IS', 'UEd', 'UEB', 'SoL') NOT NULL,
  `createdAt` DATETIME NOT NULL DEFAULT NOW(),
  `modifiedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP,  
  PRIMARY KEY (`studentID`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `username_UNIQUE` ON `Students` (`username` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `AttendingStudents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AttendingStudents` ;

CREATE TABLE IF NOT EXISTS `AttendingStudents` (
  `studentID` INT UNSIGNED NOT NULL,
  `classCode` VARCHAR(11) GENERATED ALWAYS AS (CONCAT(subjectCode, " ", classNumber)) VIRTUAL,
  `subjectCode` VARCHAR(8) NULL,
  `classNumber` TINYINT(2) NULL,
  PRIMARY KEY (`studentID`),
  CONSTRAINT `classCode_AttendingStudents_fk`
    FOREIGN KEY (`subjectCode` , `classNumber`)
    REFERENCES `Classes` (`subjectCode` , `classNumber`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE);

CREATE INDEX `classCode_Students_fk` ON `AttendingStudents` (`subjectCode` ASC, `classNumber` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `Admins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Admins` ;

CREATE TABLE IF NOT EXISTS `Admins` (
  `adminID` INT UNSIGNED NOT NULL,
  `username` VARCHAR(16) NULL,
  `firstName` VARCHAR(30) NULL,
  `lastName` VARCHAR(30) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phoneNumber` VARCHAR(15) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `createdAt` DATETIME NOT NULL DEFAULT NOW(),
  `modifiedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Weekdays`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Weekdays` ;

CREATE TABLE IF NOT EXISTS `Weekdays` (
  `weekdayNumber` TINYINT(1) UNSIGNED NOT NULL,
  `dayOfWeek` ENUM('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY') NOT NULL,
  PRIMARY KEY (`weekdayNumber`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Subjects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Subjects` ;

CREATE TABLE IF NOT EXISTS `Subjects` (
  `subjectCode` VARCHAR(8) NOT NULL,
  `subjectName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`subjectCode`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Classes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Classes` ;

CREATE TABLE IF NOT EXISTS `Classes` (
  `classCode` VARCHAR(11) GENERATED ALWAYS AS (CONCAT(`subjectCode`, " ", `classNumber`)) VIRTUAL,
  `subjectCode` VARCHAR(8) NOT NULL,
  `classNumber` TINYINT(2) NOT NULL,
  `weekdayNumber` TINYINT(1) UNSIGNED NULL,
  `startTime` TIME NOT NULL,
  `studyTime` TIME NOT NULL,
  `numberOfStudents` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`subjectCode`, `classNumber`),
  CONSTRAINT `weekdayNumber_fk`
    FOREIGN KEY (`weekdayNumber`)
    REFERENCES `Weekdays` (`weekdayNumber`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `subjectCode_fk`
    FOREIGN KEY (`subjectCode`)
    REFERENCES `Subjects` (`subjectCode`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `weekdayNumber_fk_idx` ON `Classes` (`weekdayNumber` ASC) INVISIBLE;

CREATE INDEX `subjectCode_fk_idx` ON `Classes` (`subjectCode` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `Products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Products` ;

CREATE TABLE IF NOT EXISTS `Products` (
  `itemCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `itemName` VARCHAR(45) NOT NULL,
  `availableQuantity` INT UNSIGNED NOT NULL,
  `category` ENUM('SPORT_EQUIPMENT', 'UNIFORM') NOT NULL DEFAULT 'SPORT_EQUIPMENT',
  `primaryImage` VARCHAR(100),
  `description` TEXT(100) NULL,
  `createdAt` DATETIME NOT NULL DEFAULT NOW(),
  `modifiedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`itemCode`))
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `Carts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Carts` ;

CREATE TABLE IF NOT EXISTS `Carts` (
  `userID` INT UNSIGNED NOT NULL,
  `itemCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` INT UNSIGNED NOT NULL,
  `type` VARCHAR(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`, `itemCode`, `type`),
  CONSTRAINT `userID_Carts_fk`
    FOREIGN KEY (`userID`)
    REFERENCES `Students` (`studentID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `itemCode_Carts_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `Products` (`itemCode`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `itemCode_Carts_fk_idx` ON `Carts` (`itemCode` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `SportEquipments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SportEquipments` ;

CREATE TABLE IF NOT EXISTS `SportEquipments` (
  `itemCode` INT UNSIGNED NOT NULL,
  `category` ENUM('BALL', 'NET', 'PROTECTION') NULL,
  PRIMARY KEY (`itemCode`),
  CONSTRAINT `itemCode_SportEquipments_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `Products` (`itemCode`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Requests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Requests` ;

CREATE TABLE IF NOT EXISTS `Requests` (
  `requestNumber` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `studentID` INT UNSIGNED NOT NULL,
  `requestDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `startTime` DATETIME NOT NULL,
  `endTime` DATETIME NULL,
  `classCode` VARCHAR(11) NULL,
  `status` ENUM('SENT', 'APPROVED', 'RETURNED', 'CANCEL') NOT NULL DEFAULT 'SENT',
  `note` TEXT(50) NULL,
  `modifiedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`requestNumber`),
  CONSTRAINT `studentID_Requests_fk`
    FOREIGN KEY (`studentID`)
    REFERENCES `Students` (`studentID`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `studentID_Requests_fk_idx` ON `Requests` (`studentID` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `RequestDetails`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `RequestDetails` ;

CREATE TABLE IF NOT EXISTS `RequestDetails` (
  `requestNumber` INT UNSIGNED NOT NULL,
  `itemCode` INT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`requestNumber`, `itemCode`),
  CONSTRAINT `requestNumber_RequestDetails_fk`
    FOREIGN KEY (`requestNumber`)
    REFERENCES `Requests` (`requestNumber`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `itemCode_RequestDetails_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `SportEquipments` (`itemCode`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `itemCode_RequestDetails_fk_idx` ON `RequestDetails` (`itemCode` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `Orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Orders` ;

CREATE TABLE IF NOT EXISTS `Orders` (
  `orderNumber` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `studentID` INT UNSIGNED NOT NULL,
  `orderDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `receivedDate` DATETIME NULL,
  `status` ENUM('SENT', 'PREPARING', 'READY', 'RECEIVED', 'CANCELED') NOT NULL DEFAULT 'SENT',
  `note` TEXT(100) NULL,
  `modifiedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderNumber`),
  CONSTRAINT `studentID_Orders_fk`
    FOREIGN KEY (`studentID`)
    REFERENCES `Students` (`studentID`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `studentID_Orders_fk_idx` ON `Orders` (`studentID` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `Uniforms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Uniforms` ;

CREATE TABLE IF NOT EXISTS `Uniforms` (
  `itemCode` INT UNSIGNED NOT NULL,
  `priceEach` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`itemCode`),
  CONSTRAINT `itemCode_Uniforms_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `Products` (`itemCode`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `orderDetails`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orderDetails` ;

CREATE TABLE IF NOT EXISTS `orderDetails` (
  `orderNumber` INT UNSIGNED NOT NULL,
  `itemCode` INT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`orderNumber`, `itemCode`),
  CONSTRAINT `orderNumber_OrderDetails_fk`
    FOREIGN KEY (`orderNumber`)
    REFERENCES `Orders` (`orderNumber`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `itemCode_OrderDetails_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `Uniforms` (`itemCode`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `itemCode_OrderDetails_fk_idx` ON `orderDetails` (`itemCode` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `UniformSizes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UniformSizes` ;

CREATE TABLE IF NOT EXISTS `UniformSizes` (
  `itemCode` INT UNSIGNED NOT NULL,
  `size` VARCHAR(5) NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`itemCode`, `size`),
  CONSTRAINT `itemCode_UniformSizes_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `Uniforms` (`itemCode`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ProductImages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ProductImages` ;

CREATE TABLE IF NOT EXISTS `ProductImages` (
  `itemCode` INT UNSIGNED NOT NULL,
  `uri` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`itemCode`, `uri`),
  CONSTRAINT `itemCode_ProductImages_fk`
    FOREIGN KEY (`itemCode`)
    REFERENCES `Products` (`itemCode`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RequestStatus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `RequestStatus` ;

CREATE TABLE IF NOT EXISTS `RequestStatus` (
  `statusID` TINYINT(2) UNSIGNED NOT NULL,
  `statusName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`statusID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `OrderStatus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `OrderStatus` ;

CREATE TABLE IF NOT EXISTS `OrderStatus` (
  `statusID` TINYINT(2) UNSIGNED NOT NULL,
  `statusName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`statusID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Data for table `Weekdays`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (1, 'Sunday');
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (2, 'Monday');
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (3, 'Tuesday');
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (4, 'Wednesday');
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (5, 'Thursday');
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (6, 'Friday');
INSERT INTO `Weekdays` (`weekdayNumber`, `dayOfWeek`) VALUES (7, 'Saturday');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Subjects`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Subjects` (`subjectCode`, `subjectName`) VALUES ('PEC2002', 'Bóng bàn');
INSERT INTO `Subjects` (`subjectCode`, `subjectName`) VALUES ('PEC1090', 'Cầu lông');
INSERT INTO `Subjects` (`subjectCode`, `subjectName`) VALUES ('PEC2000', 'Bóng rổ');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Classes`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Classes` (`subjectCode`, `classNumber`, `weekdayNumber`, `startTime`, `studyTime`, `numberOfStudents`) VALUES ('PEC2002', 1, 2, '07:00:00', '01:50:00', 2);
INSERT INTO `Classes` (`subjectCode`, `classNumber`, `weekdayNumber`, `startTime`, `studyTime`, `numberOfStudents`) VALUES ('PEC1090', 4, 2, '09:00:00', '01:50:00', 2);
INSERT INTO `Classes` (`subjectCode`, `classNumber`, `weekdayNumber`, `startTime`, `studyTime`, `numberOfStudents`) VALUES ('PEC2000', 3, 6, '13:00:00', '01:50:00', 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Students`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Students` (`studentID`, `username`, `firstName`, `lastName`, `email`, `phoneNumber`, `password`, `school`, `createdAt`) VALUES (20020001, 'std', 'Qwe', 'rty', 'qwe@gmail.com', '0123456789', '123', 'UET', DEFAULT);
INSERT INTO `Students` (`studentID`, `username`, `firstName`, `lastName`, `email`, `phoneNumber`, `password`, `school`, `createdAt`) VALUES (20020002, 'std1', 'yjh', 'Otyu', 'vbn@gmail.com', '0987654321', '123', 'ULIS', DEFAULT);
INSERT INTO `Students` (`studentID`, `username`, `firstName`, `lastName`, `email`, `phoneNumber`, `password`, `school`, `createdAt`) VALUES (20020003, 'std2', NULL, 'thn', 'thn@outlook.com', '0111222333', '321', 'UET', DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Products`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (1, 'Áo Polo', 100, 'UNIFORM', NULL);
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (2, 'Quần Thể Thao', 100, 'UNIFORM', NULL);
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (3, 'Áo Khoác', 100, 'UNIFORM', NULL);
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (4, 'Bóng Rổ', 150, 'SPORT_EQUIPMENT', NULL);
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (5, 'Cầu Lông', 150, 'SPORT_EQUIPMENT', NULL);
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (6, 'Bóng Đá', 150, 'SPORT_EQUIPMENT', NULL);
INSERT INTO `Products` (`itemCode`, `itemName`, `availableQuantity`, `category`, `description`) VALUES (7, 'Bóng Chuyền', 150, 'SPORT_EQUIPMENT', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `SportEquipments`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `SportEquipments` (`itemCode`, `category`) VALUES (4, 'BALL');
INSERT INTO `SportEquipments` (`itemCode`, `category`) VALUES (5, 'BALL');
INSERT INTO `SportEquipments` (`itemCode`, `category`) VALUES (6, 'BALL');
INSERT INTO `SportEquipments` (`itemCode`, `category`) VALUES (7, 'BALL');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Uniforms`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Uniforms` (`itemCode`, `priceEach`) VALUES (1, 110);
INSERT INTO `Uniforms` (`itemCode`, `priceEach`) VALUES (2, 140);
INSERT INTO `Uniforms` (`itemCode`, `priceEach`) VALUES (3, 120);

COMMIT;


-- -----------------------------------------------------
-- Data for table `UniformSizes`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (1, 'XS', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (1, 'S', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (1, 'M', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (1, 'L', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (1, 'XL', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (2, 'XS', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (2, 'S', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (2, 'M', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (2, 'L', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (2, 'XL', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (3, 'XS', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (3, 'S', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (3, 'M', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (3, 'L', 20);
INSERT INTO `UniformSizes` (`itemCode`, `size`, `quantity`) VALUES (3, 'XL', 20);

COMMIT;


-- -----------------------------------------------------
-- Data for table `AttendingStudents`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `AttendingStudents` (`studentID`, `subjectCode`, `classNumber`) VALUES (20020001, 'PEC2002', 1);
INSERT INTO `AttendingStudents` (`studentID`, `subjectCode`, `classNumber`) VALUES (20020002, 'PEC1090', 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Admins`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `Admins` (`adminID`, `username`, `firstName`, `lastName`, `email`, `phoneNumber`, `password`, `createdAt`) VALUES (1001, 'admin', 'Abc', 'Def', 'abc@gmail.com', '0999888777', '123', DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `RequestStatus`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `RequestStatus` (`statusID`, `statusName`) VALUES (1, 'SENT');
INSERT INTO `RequestStatus` (`statusID`, `statusName`) VALUES (2, 'APPROVED');
INSERT INTO `RequestStatus` (`statusID`, `statusName`) VALUES (3, 'RETURNED');
INSERT INTO `RequestStatus` (`statusID`, `statusName`) VALUES (4, 'CANCELED');

COMMIT;


-- -----------------------------------------------------
-- Data for table `OrderStatus`
-- -----------------------------------------------------
START TRANSACTION;
USE `pec_database`;
INSERT INTO `OrderStatus` (`statusID`, `statusName`) VALUES (1, 'SENT');
INSERT INTO `OrderStatus` (`statusID`, `statusName`) VALUES (2, 'PREPARING');
INSERT INTO `OrderStatus` (`statusID`, `statusName`) VALUES (3, 'READY');
INSERT INTO `OrderStatus` (`statusID`, `statusName`) VALUES (4, 'RECEIVED');
INSERT INTO `OrderStatus` (`statusID`, `statusName`) VALUES (5, 'CANCELED');
INSERT INTO `OrderStatus` (`statusID`, `statusName`) VALUES (6, 'RETURNED');

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
