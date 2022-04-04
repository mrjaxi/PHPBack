
--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  description text  NOT NULL,
  ideas int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

insert into `categories` (`description`, `id`, `ideas`, `name`) values
('Всё, что связано с методологией создания эффективного корпоративного обучения', 1, 1, 'Методология'),
('Всё, что касается приложения', 2, 1, 'Приложение'),
('Всё, что касается администрирования системы, создания новых карт и прохождение в веб-версии', 3, 0, 'Платформа'),
('Всe записи, которые не определили к конкретной категории', 4, 0, 'Прочее');


-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS types (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  description text,
  ideas int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `types` (`id`, `name`, `ideas`) VALUES
(1, 'Предложить идею', 0),
(2, 'Сообщить о проблеме', 0),
(3, 'Поблагодарить', 0),
(4, 'Задать вопрос', 0),
(5, 'Без категории', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS comments (
  id int(11) NOT NULL AUTO_INCREMENT,
  content text  NOT NULL,
  ideaid int(11) NOT NULL,
  userid int(11) NOT NULL,
  date tinytext  NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

-- --------------------------------------------------------

--
-- Table structure for table `flags`
--

CREATE TABLE IF NOT EXISTS flags (
  id int(11) NOT NULL AUTO_INCREMENT,
  toflagid int(11) NOT NULL,
  userid int(11) NOT NULL,
  date tinytext  NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE IF NOT EXISTS ideas (
  id int(11) NOT NULL AUTO_INCREMENT,
  title tinytext  NOT NULL,
  content text  NOT NULL,
  authorid int(11) NOT NULL,
  date tinytext  NOT NULL,
  votes int(11) NOT NULL,
  comments int(11) NOT NULL,
  status tinytext  NOT NULL,
  categoryid int(11) NOT NULL,
  typeid int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ideas`
--

-- INSERT INTO `ideas` (`authorid`, `categoryid`, `comments`, `content`, `date`, `id`, `status`, `title`, `votes`) VALUES
-- (5, 4, 2, 'После принятия или отклонения задания ментором нужно открывать следующее задание', '16/03/22 12:21', 1, 'considered', 'Оптимизировать проверку заданий', 2),


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS logs (
  id int(11) NOT NULL AUTO_INCREMENT,
  content tinytext  NOT NULL,
  date tinytext  NOT NULL,
  type tinytext  NOT NULL,
  toid int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS settings (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  value tinytext  NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

insert into `settings` (`id`, `name`, `value`) values
(1, 'title', 'AtmaGuru');
(2, 'welcometext-title', 'Добро пожаловать в систему обратной связи');
(3, 'welcometext-description', 'Здесь вы можете предложить идеи по улучшению наших услуг или проголосовать за идеи других людей');
(4, 'recaptchapublic', '');
(5, 'recaptchaprivate', '');
(6, 'language', 'rus');
(7, 'maxvotes', '20');
(8, 'mainmail', 'tip@atmaguru.online');
(9, 'max_results', '10');
(10, 'smtp-host', '127.0.0.1');
(11, 'smtp-port', '25');
(12, 'smtp-user', '');
(13, 'smtp-pass', '');


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  email tinytext  NOT NULL,
  pass tinytext  NOT NULL,
  votes int(11) NOT NULL,
  isadmin tinyint(1) NOT NULL,
  banned int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

insert into `users` (`banned`, `email`, `id`, `isadmin`, `name`, `pass`, `votes`) values
(0, 'bobcatoshigu@gmail.com', 1, 3, 'jordanpie', '$2a$08$MWfOcPmxZcg5Yv3NFjMhZ.HrIjefMsFQFJIwy8mtrt1SYkSsoCpjO', 20),
(0, 'yakov@atmadev.ru', 2, 3, 'Yakov', '$2a$08$gtFDNo.OYY6ysPyaWXgNnO/k9qaEsF2WRXWrO9jd4YaQMMxSZlVku', 20),
(0, 'damedvedev@atmapro.ru', 3, 3, 'Дмитрий Медведев', '$2a$08$xJo6nkE3FYXZlTqplr/XtO5DXeFgLu9MTIeeBT1ZqdpK74CF7A1ie', 20),
(0, 'BBL@yandex.ru', 4, 0, 'BBL', '$2a$08$OLVEJZzrTTUc8f6O3Xr1YObyT5He774lYaifpKP3V4cqjD8e8MKQ6', 20);


-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS votes (
  id int(11) NOT NULL AUTO_INCREMENT,
  ideaid int(11) NOT NULL,
  userid int(11) NOT NULL,
  number int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `_sessions`
--

CREATE TABLE IF NOT EXISTS _sessions (
  id int(11) NOT NULL AUTO_INCREMENT,
  userid int(11) NOT NULL,
  token tinytext NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;