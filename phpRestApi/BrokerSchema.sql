CREATE DATABASE `brokerDB`;

use `brokerDB`;

CREATE TABLE `customer` (
  `customer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `customer_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `policy` (
  `policy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `policy_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `policy_premium` double NOT NULL,
  `insurer_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `customer` bigint unsigned,
  PRIMARY KEY (`policy_id`),
  FOREIGN KEY (`customer`) REFERENCES `customer`(`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `client` (
  `client_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*A joining table for the client policies*/
CREATE TABLE `client_policies` (
  `client_id`   bigint unsigned        NOT NULL,
  `policy_id`  bigint unsigned         NOT NULL,
  KEY         (`client_id`),
  KEY         (`policy_id`),
  FOREIGN KEY (`client_id`)  REFERENCES `client`   (`client_id`)  ON DELETE CASCADE,
  FOREIGN KEY (`policy_id`) REFERENCES `policy` (`policy_id`) ON DELETE CASCADE,
  PRIMARY KEY (`client_id`, `policy_id`)
);


INSERT INTO customer (  
  customer_id,
  customer_name,
  customer_address
)  VALUES ( 
  1, 
  "ABC Joinery", 
  "12 Ascott Street, Dundee"
);

INSERT INTO customer 
(  
  customer_id,
  customer_name,
  customer_address
) VALUES (
  2,
  "XYZ Plumbing",
  "24 Fleet Street, Glasgow"
);

INSERT INTO customer 
(  
  customer_id,
  customer_name,
  customer_address
) VALUES (
  3,
  "Fast Taxis",
  "324b Bank Street, Aberdeen"
);

INSERT INTO policy 
(  
  policy_id,
  policy_type,
  policy_premium,
  insurer_name,
  customer
 ) VALUES (
  1,
  "Public Liability",
  123.87,
  "Aviva",
  1
);

INSERT INTO policy 
(  
  policy_id ,
  policy_type,
  policy_premium ,
  insurer_name,
  customer
) VALUES (
  2,
  "Public Liability",
  2321.45,
  "Allianz",
  2
);

INSERT INTO policy (  
  policy_id ,
  policy_type,
  policy_premium ,
  insurer_name,
  customer
) VALUES (
  3,
  "Motor Fleet",
  59897.00,
  "Aviva",
  3
);

INSERT INTO policy (  
  policy_id ,
  policy_type,
  policy_premium ,
  insurer_name,
  customer
) VALUES (
  4,
  "Public Liability",
  6845.00,
  "QBE",
  3
);

INSERT INTO client (  
  client_id,
  client_name
) VALUES (
  1,
  "Achme Broker Ltd"
);

INSERT INTO client_policies 
(
  client_id,
  policy_id
) VALUES (
  1, 
  1
);

INSERT INTO client_policies 
(
  client_id,
  policy_id
) VALUES (
  1, 
  2
);

INSERT INTO client_policies 
(
  client_id,
  policy_id
) VALUES (
  1, 
  3
);

INSERT INTO client_policies 
(
  client_id,
  policy_id
) VALUES (
  1, 
  4
);