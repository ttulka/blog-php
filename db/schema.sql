CREATE DATABASE IF NOT EXISTS `blog`;
USE `blog`;

CREATE TABLE `Property` (
  `name` VARCHAR(50) NOT NULL,
  `value` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`name`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `Category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `Author` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `Post` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(100) NOT NULL,
  `createdAt` int(10) unsigned NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `summary` TEXT,
  `body` TEXT,
  `authorId` INT(11) NOT NULL,
  `categoryId` INT(11) NOT NULL,
  `isDraft` ENUM('true','false') NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`),
  INDEX `post_author_idx` (`authorId`),
  INDEX `post_category_idx` (`categoryId`),
  FOREIGN KEY (`authorId`) REFERENCES Author(id),
  FOREIGN KEY (`categoryId`) REFERENCES Category(id)
) DEFAULT CHARSET=utf8;

CREATE TABLE `Comment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `createdAt` int(10) unsigned NOT NULL,
  `author` VARCHAR(50) DEFAULT NULL,
  `body` TEXT,
  `parentId` INT(11) NULL,
  `postId` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `comment_parent_idx` (`parentId`),
  INDEX `comment_post_idx` (`postId`),
  FOREIGN KEY (`parentId`) REFERENCES Comment(id),
  FOREIGN KEY (`postId`) REFERENCES Post(id)
) DEFAULT CHARSET=utf8;


INSERT INTO `Property` VALUES 
  ('blogTitle', 'Tomas Tulka\'s Blog'), 
  ('blogDescription', 'A small blog about programming and stuff.'),
  ('blogAuthor', 'Tomas Tulka - NET21 s.r.o.');

INSERT INTO `Category` VALUES (1, 'First Category'), (2, 'Second Category');

INSERT INTO `Author` VALUES (1, 'Tomas Tulka'), (2, 'John Smith');

INSERT INTO `Post` VALUES
  (1, 'first-post', '1399000', 'First Post', '<p><b>Lorem ipsum</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (2, 'second-post', '1398000', 'Second Post', '<p><b>Lorem ipsum 2</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 2 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 2, 2, 'false'),
  (3, 'draft-post', '1397000', 'Draft Post', '<p><b>Lorem ipsum draft</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum draft dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'true'),
  (4, 'about', '1396000', 'About Me', '<p><b>Lorem ipsum About Me</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 4 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (5, 'post-5-link', '1395000', 'Post 5', '<p><b>Lorem ipsum 5</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 5 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (6, 'post-6-link', '1394000', 'Post 6', '<p><b>Lorem ipsum 6</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 6 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (7, 'post-7-link', '1393000', 'Post 7', '<p><b>Lorem ipsum 7</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 7 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (8, 'post-8-link', '1392000', 'Post 8', '<p><b>Lorem ipsum 8</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 8 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (9, 'post-9-link', '1391000', 'Post 9', '<p><b>Lorem ipsum 9</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 9 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (10, 'post-10-link', '1390000', 'Post 10', '<p><b>Lorem ipsum 10</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 10 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (11, 'post-11-link', '1389000', 'Post 11', '<p><b>Lorem ipsum 11</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 11 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (12, 'post-12-link', '1388000', 'Post 12', '<p><b>Lorem ipsum 12</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 12 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (13, 'post-13-link', '1387000', 'Post 13', '<p><b>Lorem ipsum 13</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 13 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (14, 'post-14-link', '1386000', 'Post 14', '<p><b>Lorem ipsum 14</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 14 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (15, 'post-15-link', '1385000', 'Post 15', '<p><b>Lorem ipsum 15</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 15 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (16, 'post-16-link', '1384000', 'Post 16', '<p><b>Lorem ipsum 16</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 16 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (17, 'post-17-link', '1383000', 'Post 17', '<p><b>Lorem ipsum 17</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 17 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (18, 'post-18-link', '1382000', 'Post 18', '<p><b>Lorem ipsum 18</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 18 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (19, 'post-19-link', '1381000', 'Post 19', '<p><b>Lorem ipsum 19</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 19 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (20, 'post-20-link', '1380000', 'Post 20', '<p><b>Lorem ipsum 20</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 20 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (21, 'post-21-link', '1379000', 'Post 21', '<p><b>Lorem ipsum 21</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 21 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (22, 'post-22-link', '1378000', 'Post 22', '<p><b>Lorem ipsum 22</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 22 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (23, 'post-23-link', '1377000', 'Post 23', '<p><b>Lorem ipsum 23</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 23 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (24, 'post-24-link', '1376000', 'Post 24', '<p><b>Lorem ipsum 24</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 24 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (25, 'post-25-link', '1375000', 'Post 25', '<p><b>Lorem ipsum 25</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 25 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (26, 'post-26-link', '1374000', 'Post 26', '<p><b>Lorem ipsum 26</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 26 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (27, 'post-27-link', '1373000', 'Post 27', '<p><b>Lorem ipsum 27</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 27 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false'),
  (28, 'post-28-link', '1372000', 'Post 28', '<p><b>Lorem ipsum 28</b> dolor sit amet, consectetur adipiscing elit.</p>', '<p><b>Lorem ipsum 28 dolor sit amet</b>,</p><p>consectetur adipiscing elit.</p>', 1, 1, 'false');
  
INSERT INTO `Comment` VALUES 
  (1, '1400000', 'Author 1', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (2, '1401000', 'Author 2', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (3, '1402000', 'Author 3', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (4, '1403000', 'Author 4', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (5, '1404000', 'Author 5', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (6, '1405000', 'Author 6', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (7, '1406000', 'Author 7', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (8, '1407000', 'Author 8', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (9, '1408000', 'Author 9', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (10, '1409000', 'Author 10', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (11, '1410000', 'Author 11', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (12, '1411000', 'Author 12', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (13, '1412000', 'Author 13', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (14, '1413000', 'Author 14', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (15, '1414000', 'Author 15', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (16, '1415000', 'Author 16', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (17, '1416000', 'Author 17', '1-1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1),
  (18, '1417000', 'Author 18', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (19, '1418000', 'Author 19', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (20, '1419000', 'Author 20', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (21, '1420000', 'Author 21', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (22, '1421000', 'Author 22', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (23, '1422000', 'Author 23', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (24, '1423000', 'Author 24', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (25, '1424000', 'Author 25', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (26, '1425000', 'Author 26', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (27, '1426000', 'Author 27', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (28, '1427000', 'Author 28', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (29, '1428000', 'Author 29', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (30, '1429000', 'Author 30', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (31, '1430000', 'Author 31', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (32, '1432000', 'Author 32', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (33, '1433000', 'Author 33', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (34, '1434000', 'Author 34', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (35, '1435000', 'Author 35', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (36, '1436000', 'Author 36', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (37, '1437000', 'Author 37', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (38, '1438000', 'Author 38', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (39, '1439000', 'Author 39', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (40, '1440000', 'Author 40', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (41, '1440000', 'Author 41', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (42, '1440000', 'Author 42', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (43, '1440000', 'Author 43', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (44, '1440000', 'Author 44', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (45, '1440000', 'Author 45', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (46, '1440000', 'Author 46', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (47, '1440000', 'Author 47', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (48, '1440000', 'Author 48', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (49, '1440000', 'Author 49', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (50, '1440000', 'Author 50', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (51, '1440000', 'Author 51', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (52, '1440000', 'Author 52', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (53, '1440000', 'Author 53', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (54, '1440000', 'Author 54', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (55, '1440000', 'Author 55', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1),
  (56, '1440000', 'Author 56', '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 1);
  