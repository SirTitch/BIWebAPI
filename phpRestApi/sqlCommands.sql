CREATE TABLE `users` (
  `user_id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO users (  user_id,
    username,
    user_email,
    user_status) VALUES (
    2,
    "John",
    "john@gmail.com",
    1
);
INSERT INTO users (  user_id,
    username,
    user_email,
    user_status) VALUES (
    3,
    "Mark",
    "mark@gmail.com",
    2
);
INSERT INTO users (  user_id,
    username,
    user_email,
    user_status) VALUES (
    4,
    "Ville",
    "ville@gmail.com",
    0
);
INSERT INTO users (  user_id,
    username,
    user_email,
    user_status) VALUES (
    2,
    "John",
    "john@gmail.com",
    1
);

--  {
--       "user_id":1,
--       "username":"Bob",
--       "user_email":"bob@gmail.com",
--       "user_status":0
--    }