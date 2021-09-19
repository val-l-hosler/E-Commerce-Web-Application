USE `valerjp1_cupcakery` ;

CREATE TABLE IF NOT EXISTS `valerjp1_cupcakery`.`admin` (
    `admin_id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(20) NOT NULL,
    `password` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`admin_id`)
);

CREATE TABLE IF NOT EXISTS `valerjp1_cupcakery`.`customer` (
    `customer_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `phone_number` VARCHAR(12) NOT NULL,
    PRIMARY KEY (`customer_id`)
);

CREATE TABLE IF NOT EXISTS `valerjp1_cupcakery`.`cupcake_order` (
    `cupcake_order_id` INT NOT NULL AUTO_INCREMENT,
    `card_name` VARCHAR(150) NOT NULL,
    `card_number` VARCHAR(19) NOT NULL,
    `card_cvv` VARCHAR(3) NOT NULL,
    `card_expiration_month` VARCHAR(2) NOT NULL,
    `card_expiration_year` VARCHAR(4) NOT NULL,
    `pickup_date` DATE NOT NULL,
    `status` VARCHAR(5) NOT NULL,
    `fk_customer_id` INT NOT NULL,
    PRIMARY KEY (`cupcake_order_id`),
    INDEX `ux_1_idx` (`fk_customer_id` ASC),
    CONSTRAINT `ux_1` FOREIGN KEY (`fk_customer_id`)
        REFERENCES `valerjp1_cupcakery`.`customer` (`customer_id`)
);

CREATE TABLE IF NOT EXISTS `valerjp1_cupcakery`.`item` (
    `item_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `cupcake_price` DECIMAL(10 , 2 ) NOT NULL,
    PRIMARY KEY (`item_id`)
);

CREATE TABLE IF NOT EXISTS `valerjp1_cupcakery`.`cupcake_order_item` (
    `cupcake_order_item_id` INT NOT NULL AUTO_INCREMENT,
    `quantity_purchased` INT NOT NULL,
    `fk_cupcake_order_id` INT NOT NULL,
    `fk_item_id` INT NOT NULL,
    PRIMARY KEY (`cupcake_order_item_id`),
    INDEX `ux_2_idx` (`fk_cupcake_order_id` ASC),
    INDEX `ux_3_idx` (`fk_item_id` ASC),
    CONSTRAINT `ux_2` FOREIGN KEY (`fk_cupcake_order_id`)
        REFERENCES `valerjp1_cupcakery`.`cupcake_order` (`cupcake_order_id`),
    CONSTRAINT `ux_3` FOREIGN KEY (`fk_item_id`)
        REFERENCES `valerjp1_cupcakery`.`item` (`item_id`)
);

INSERT INTO admin
(username, password)
VALUES
('admin', 'pass')
;

INSERT INTO item
(name, cupcake_price)
VALUES
('Berry Cupcake', 3.50),
('Carrot Cupcake', 3.50),
('Cinnamon Cupcake', 3.50),
('Mint Chocolate Cupcake', 3.50),
('Rainbow Cupcake', 3.50),
('Red Velvet Cupcake', 3.50)
;
