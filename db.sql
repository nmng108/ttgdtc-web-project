CREATE TABLE `Tokens` (
  `user_id` int(11) NOT NULL,
  `token` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE products(
    id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name varchar(30) NOT NULL,
    thumbnail varchar(250) NOT NULL,
    content longtext,
    quantityInStock int,
    created_at datetime,
    updated_at datetime   
);

create table orders (
	id int primary key auto_increment,
	fullname varchar(100),
	phone_number varchar(20),
	email varchar(200),
	address varchar(200),
	order_date datetime
);
create table order_details (
	id int primary key auto_increment,
	order_id int references orders (id),
	product_id int references products (id),
	num int
);