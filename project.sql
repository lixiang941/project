-- 创建数据库 project
CREATE DATABASE IF NOT EXISTS `project`;

-- 选择数据库
USE project;

-- 创建用户表 pro_user

CREATE TABLE IF NOT EXISTS `pro_user`(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE,
    password CHAR(32) NOT NULL,
    sex TINYINT NOT NULL DEFAULT 0,
    role TINYINT NOT NULL DEFAULT 0,  -- 0 普通用户 １ 管理员 2 超级管理员 
   `lock` TINYINT NOT NULL DEFAULT 0 -- 0 开启 1 禁止
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 添加超级管理员
INSERT INTO pro_user VALUES(NULL,'admin',md5('123456'),1,2,0);
