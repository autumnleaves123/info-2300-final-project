/* TODO: create tables */

/* Home page (newsfeed) */
CREATE TABLE feed (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	title TEXT NOT NULL,
	entry_date TEXT NOT NULL,
	content TEXT NOT NULL
);

/* Meet the board (board members) */

CREATE TABLE eboard (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL,
  position TEXT NOT NULL,
  major TEXT NOT NULL,
  classyear TEXT NOT NULL,
  bio TEXT NOT NULL,
  image TEXT NOT NULL
);

/* Gallery */

/* Learn ASL */
CREATE TABLE signs (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  word TEXT NOT NULL UNIQUE,
  image_path TEXT NOT NULL,
  description TEXT NOT NULL
);

/* Resources */

/* Log in
--> this is my example users table from P3 for login testing purposes - Autumn */
CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  username TEXT NOT NULL,
  password TEXT NOT NULL
);

/* TODO: initial seed data */

/* Home page (newsfeed) */
INSERT INTO feed(title, entry_date, content) VALUES ("CUDAP Arch Sign", "April 23, 2018", "Come to CUDAP's Arch Sign tomorrow from 9:00 to 9:30 at the Balch Arch! We'll be sharing your favorite pieces!");
INSERT INTO feed(title, entry_date, content) VALUES ("Rehearsal this week", "April 18, 2018", "Join CUDAP this Wednesday, from 5:30 to 6:30, in GSH room 164 for our weekly Sign Choir meeting! We will be reviewing three songs from this past year: Cups Song - Anna Kendrick, It's Time - Imagine Dragons, and Shape of You - Ed Sheeran.");
INSERT INTO feed(title, entry_date, content) VALUES ("Panel discussion on disability and intersectionality", "April 16, 2018", "The Undergraduate Disability Studies Journal is hosting a panel discussion on disability and intersectionality on campus tomorrow, April 17th, from 4:30-6pm in Ives Hall Room 116. Please join us to learn about the experience of students with disabilities on campus who will share about their personal experiences and academic work in this area. The purpose of the panel is to inspire our campus community to think more broadly of disability as diversity, and create a more welcoming space for students with intersectional experiences.");

/* Meet the board (board members) */

INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Jonathan Masci', 'Alumni Advisor', 'Linguistics', '2016', 'He joined CUDAP in his sophomore year in order to learn more about American Sign Language and Deaf culture. During his time in the organization, he found a passion for advocacy and service learning.', '1.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Mary Grace Hager', 'Co-President', 'Mathematics & Computer Science', '2019', 'She joined CUDAP her freshman year to learn more about ASL and Deaf culture. Mary Grace became Treasurer in the spring of 2016 and transitioned into Co-President a year later.', '2.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Diana Bartolotta', 'Co-President', 'Environmental & Sustainability Sciences', '2019', 'She joined CUDAP her freshman year to pursue advocacy opportunities and to connect with others who share an interest in learning and improving their American Sign Language skills.', '3.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Juliet Remi', 'Outreach Chair', 'Industrial and Labor Relations', '2020', 'She joined CUDAP in her freshman year to improve her American Sign Language and learn more about the Deaf community and culture.', '4.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Katherine Dillon', 'Secretary', 'Human Biology, Health, and Society', '2019', "She joined the Cornell University Deaf Awareness Project as a freshman and has been CUDAP's secretary since Spring 2017. Katie is dedicated to CUDAP's accessibility goals.", '5.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Lucia Gomez', 'Events Coordinator', 'Computer Science & Linguistics', '2021', "She joined CUDAP during her first semester to connect with other students who love ASL and to spread awareness about Deaf culture. Lucia loves to gloss songs, and she's translated everything from Hamilton to Twenty One Pilots.", '6.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Alyssa Trigg', 'Treasurer', 'Computer Science & Linguistics', '2018', 'She has been a member of CUDAP since spring of 2016 and is currently the treasurer of the Cornell University Deaf Awareness Project. She is also a member of the Cornell Swing Dance Club, and assorted other clubs.', '7.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Pamela Wildstein', 'Publicity Designer', 'Environmental and Sustainability Sciences', '2020', 'She joined CUDAP in the Fall of her sophmore year, after transferring from Penn State, with the goal of becoming an advocate for the Deaf community.', '8.jpg');

/* Gallery */

/* Learn ASL */
INSERT INTO signs(word, image_path, description) VALUES ('a', 'uploads/signs/a.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('b', 'uploads/signs/b.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('c', 'uploads/signs/c.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('d', 'uploads/signs/d.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('e', 'uploads/signs/e.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('f', 'uploads/signs/f.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('g', 'uploads/signs/g.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('h', 'uploads/signs/h.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('i', 'uploads/signs/i.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('j', 'uploads/signs/j.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('k', 'uploads/signs/k.jpg', 'lorem ipsum');
INSERT INTO signs(word, image_path, description) VALUES ('l', 'uploads/signs/l.jpg', 'lorem ipsum');

/* Resources */

/* Log in */

INSERT INTO users(username, password) VALUES ('janedoe', '$2y$10$92IushmzxvE9gSiAEb8d2Op16RZSp.5Vtm4snVsyhP1oI8zrEnrOe'); /* Password is 'gobigred' */
INSERT INTO users(username, password) VALUES ('gm', '$2y$10$jFXqOXL7F.Q4rSBSNosGEus6cF2lOZ8vIVJoFpQCaGXOGggIfaqzq'); /* Password is 'liftthechorus' */
