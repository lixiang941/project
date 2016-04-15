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

-- 创建商品分类表 pro_category
CREATE TABLE IF NOT EXISTS `pro_category`(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) ,
    pid INT UNSIGNED,
    path VARCHAR(255),
    display INT NOT NULL DEFAULT 1 -- 1显示 2 隐藏
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 创建商品表 pro_goods

CREATE TABLE IF NOT EXISTS `pro_goods`(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    cate_id INT UNSIGNED NOT NULL,                           -- 分类id
    price DECIMAL(10,2) NOT NULL DEFAULT 0,                  -- 商品价格
    stock INT NOT NULL DEFAULT 0,                            -- 商品库存数
    `status` TINYINT NOT NULL DEFAULT 0,                     -- 商品状态 0 下架 1 上架
    is_hot TINYINT NOT NULL DEFAULT 0,                       -- 热销 0 不热 1 热
    is_new TINYINT NOT NULL DEFAULT 0,                       -- 新品 0 不新 1 新
    is_best TINYINT NOT NULL DEFAULT 0,                      -- 精品 0 不精 1 精
    addtime INT UNSIGNED NOT NULL DEFAULT 0,                 -- 首次添加时间
    sail_num INT UNSIGNED NOT NULL DEFAULT 0,                -- 销售数量
    `describe` TEXT                                          -- 商品描述

)ENGINE = MyISAM DEFAULT CHARSET=UTF8;


-- 创建商品图片表 pro_image

CREATE TABLE IF NOT EXISTS `pro_image`(
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name  VARCHAR(255) NOT NULL DEFAULT '',
      goods_id INT UNSIGNED NOT NULL DEFAULT 0,
      is_face  TINYINT  NOT NULL DEFAULT 1                    -- 1是封皮  0 不是封皮
)ENGINE=MyISAM DEFAULT CHARSET=utf8;


