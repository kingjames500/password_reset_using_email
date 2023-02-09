
/* 2023-02-03 13:02:16 [907 ms] */ 
CREATE TABLE `users` (
  `users_id` int(11) NOT NULL PRIMARY key AUTO_INCREMENT,
  `users_uid` varchar(20) not null,
  `users_email` varchar(100) NOT NULL,
  `users_pwd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/* 2023-02-03 13:12:23 [233 ms] */ 

/* 2023-02-03 13:12:47 [979 ms] */ 
/* 2023-02-03 14:07:28 [360 ms] */ 

/* 2023-02-03 14:07:43 [865 ms] */ 
CREATE TABLE `codes` (
  `id` int(11) PRIMARY key  NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `code` varchar(6) NOT NULL,
  `expire` DATETIME,
  resetTimes int not null
);