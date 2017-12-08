CREATE TABLE users
(
  username VARCHAR(50) NOT NULL,
  email VARCHAR(55) NOT NULL,
  first_name VARCHAR(55) NOT NULL,
  last_name VARCHAR NOT NULL,
  birthday DATE NOT NULL,
  age INT NOT NULL,
  password VARCHAR(100) NOT NULL,
  salt VARCHAR(100) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  course VARCHAR(100) NOT NULL,
  year_graduated DATE NOT NULL,
  city VARCHAR(100) NOT NULL,
  address VARCHAR(255) NOT NULL,
  mobile_number VARCHAR(55) NOT NULL,
  telephone_number VARCHAR(55) NOT NULL,
  civil_status VARCHAR(55) NOT NULL,
  joined DATE NOT NULL,
  groups INT NOT NULL,
  time_elapsed INT NOT NULL,
  id INT NOT NULL,
  is_approved INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE projects
(
  id INT NOT NULL,
  title VARCHAR(100) NOT NULL,
  content VARCHAR(1000) NOT NULL,
  status INT NOT NULL,
  time_elapsed INT NOT NULL,
  image VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE news
(
  id INT NOT NULL,
  title VARCHAR(55) NOT NULL,
  content VARCHAR(1000) NOT NULL,
  status INT NOT NULL,
  time_elapsed INT NOT NULL,
  image VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE forum
(
  id INT NOT NULL,
  section VARCHAR(55) NOT NULL,
  time_elapsed INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE questions
(
  id INT NOT NULL,
  content VARCHAR(255) NOT NULL,
  time_elapsed INT NOT NULL,
  user_id INT NOT NULL,
  PRIMARY KEY (id)
);
  
CREATE TABLE events
(
  id INT NOT NULL,
  title VARCHAR(55) NOT NULL,
  content VARCHAR(1000) NOT NULL,
  status INT NOT NULL,
  time_elapsed INT NOT NULL,
  image VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE comments
(
  id INT NOT NULL,
  content VARCHAR(255) NOT NULL,
  time_elapsed INT NOT NULL,
  is_approved INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE answers
(
  id INT NOT NULL,
  user_id INT NOT NULL,
  question_id INT NOT NULL,
  content INT NOT NULL,
  time_elapsed INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE groups
(
  id INT NOT NULL,
  name VARCHAR(55) NOT NULL,
  permission VARCHAR(55) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users_session
(
  id INT NOT NULL,
  hash VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  PRIMARY KEY (id)
);