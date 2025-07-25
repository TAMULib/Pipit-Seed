--
-- Database: 'phpseedapp'
--
CREATE DATABASE IF NOT EXISTS pipit_seed;

-- --------------------------------------------------------

--
-- Table structure for table 'users'
--

CREATE TABLE IF NOT EXISTS users (
  id serial NOT NULL,
  username varchar(20) NOT NULL,
  password varchar(80) NOT NULL,
  email varchar(120) NOT NULL,
  name_first varchar(30) NOT NULL,
  name_last varchar(30) NOT NULL,
  role int NOT NULL DEFAULT '0',
  inactive smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ;

-- --------------------------------------------------------

-- Default password is 'changethis' --
INSERT INTO users (username, password, email, name_first, name_last, role, inactive) VALUES
('admin', '$2y$10$XWsCnoBSNE2P6YKD3ERqZ.Wjwtq1RR5fgXKVcRYaWtmpkPGbYyi.G', '', 'Adam', 'Admin', 1, 0);


--
-- Table structure for table 'users_ldap'
--

CREATE TABLE IF NOT EXISTS users_ldap (
  id serial NOT NULL,
  userid int NOT NULL UNIQUE,
  samaccountname varchar(50) NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table 'widgets'
--

CREATE TABLE IF NOT EXISTS widgets (
  id serial NOT NULL,
  name varchar(100) NOT NULL,
  description text NOT NULL,
  part_count int NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table 'widgets_parts'
--

CREATE TABLE IF NOT EXISTS widgets_parts (
  id serial NOT NULL,
  widgetid int NOT NULL,
  name varchar(60) NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table dynamic_repo_ex
--

CREATE TABLE IF NOT EXISTS dynamic_repo_ex (
  id serial NOT NULL,
  name varchar(60) NOT NULL,
  description text,
  PRIMARY KEY (id)
);

--
-- Table structure for table files
--

CREATE TABLE IF NOT EXISTS files (
  id serial NOT NULL PRIMARY KEY,
  name varchar(40) NOT NULL,
  path varchar(40) NOT NULL,
  uploaded TIMESTAMP NOT NULL DEFAULT NOW(),
  userid int NOT NULL,
  typeid int NOT NULL,
  relatedid int NOT NULL,
  gloss varchar(40) NOT NULL,
  file_type varchar(20) NOT NULL,
  UNIQUE (typeid, relatedid)
);

--
-- Table structure for table files_types
--

CREATE TABLE IF NOT EXISTS files_types (
  id SERIAL NOT NULL PRIMARY KEY,
  name varchar(40) NOT NULL
);

INSERT INTO files_types (name) VALUES ('Widget Attachments');
