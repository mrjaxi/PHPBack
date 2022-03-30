
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

INSERT INTO `categories` (`id`, `name`, `description`, `ideas`) VALUES
(1, 'TEST', 'TEST', 3);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS types (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  description text  NOT NULL,
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
-- (11, 4, 0, 'sdfsdfsdfsdf', '23/03/22 15:02', 15, 'new', 'sdfsdfsdf', 0),
-- (11, 4, 0, 'sdfgsdfgsdfgsddfsdf', '23/03/22 15:17', 20, 'new', 'dfgdfgdfgdfg', 0),
-- (11, 4, 0, 'testtesttetstetstetstetstetestt', '23/03/22 15:30', 22, 'new', 'atmatest', 0),
-- (11, 3, 0, 'dgdfgdfgdfgdfg', '23/03/22 15:40', 27, 'new', 'testttt', 0),
-- (11, 2, 0, 'werwerwerwerwerwer', '23/03/22 15:41', 28, 'new', 'werwerwerwer', 0),
-- (11, 3, 0, 'shdgfkhsdfgskdjfsd', '23/03/22 15:45', 29, 'new', 'sjhdfgkhjsdfjkhsdfkjh', 0),
-- (15, 5, 0, 'сделать звонко и по красоте ваще', '23/03/22 16:50', 33, 'considered', 'Сделать систему обратной связи', 0);


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