CREATE TABLE IF NOT EXISTS categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  description text  NOT NULL,
  ideas int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Structure of table comments
-- Comments are linked to ideas and submitted by an existing user
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
-- Structure of table flags
--
CREATE TABLE IF NOT EXISTS flags (
  id int(11) NOT NULL AUTO_INCREMENT,
  toflagid int(11) NOT NULL,
  userid int(11) NOT NULL,
  date tinytext  NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Structure of table ideas
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
  PRIMARY KEY (id),
  KEY category_id (categoryid),
  CONSTRAINT fk_category_id FOREIGN KEY (categoryid) REFERENCES categories (id) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Structure of table logs
-- Application logs
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
-- Structure of table settings
-- Key/Value pairs of settings
CREATE TABLE IF NOT EXISTS settings (
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext  NOT NULL,
  value tinytext  NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Structure of table users
-- Users can have role admin
-- Users can be banned from application
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
-- Structure of table votes
-- Votes are linked to ideas and submitted by an existing user
CREATE TABLE IF NOT EXISTS votes (
  id int(11) NOT NULL AUTO_INCREMENT,
  ideaid int(11) NOT NULL,
  userid int(11) NOT NULL,
  number int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Structure of table _sessions
-- PHP sessions are persisted into database
CREATE TABLE IF NOT EXISTS _sessions (
  id int(11) NOT NULL AUTO_INCREMENT,
  userid int(11) NOT NULL,
  token tinytext NOT NULL,
  PRIMARY KEY (id),
  KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;