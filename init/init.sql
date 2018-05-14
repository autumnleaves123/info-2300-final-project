/* TODO: create tables */

/* Home page (newsfeed) */
CREATE TABLE feed (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	title TEXT NOT NULL,
	entry_date TEXT NOT NULL,
	content TEXT NOT NULL,
	url_1 TEXT,
	url_2 TEXT
);

CREATE TABLE feed_attachments (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	file_name TEXT,
	file_ext TEXT
);

CREATE TABLE feed_to_feed_attachments (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	feed_id INTEGER NOT NULL,
	feed_attachment_id INTEGER NOT NULL
);

CREATE TABLE feed_tags (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL
);

CREATE TABLE feed_to_tags (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	feed_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL
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
CREATE TABLE images (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	title TEXT NOT NULL,
	file_ext TEXT NOT NULL
);

CREATE TABLE categories (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL UNIQUE
);

CREATE TABLE images_cats (
	image_id INTEGER NOT NULL,
	cat_id INTEGER NOT NULL
);

/* Learn ASL */
CREATE TABLE signs (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  word TEXT NOT NULL,
	frame INTEGER NOT NULL,
  image_path TEXT NOT NULL,
  description TEXT
);

/* Resources */
CREATE TABLE links (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL UNIQUE,
	url TEXT NOT NULL UNIQUE
);

CREATE TABLE ppts (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	link TEXT NOT NULL UNIQUE, /* google drive link */
	label TEXT NOT NULL UNIQUE
);

/* Log in */
--> this is my example users table from P3 for login testing purposes - Autumn */
CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  username TEXT NOT NULL,
  password TEXT NOT NULL
);


/* TODO: initial seed data */

/* Home page (newsfeed) */
/* 1 */INSERT INTO feed (title, entry_date, content, url_1) VALUES ("D/deaf / Hard of Hearing School Counseling Survey", "April 1, 2018", "Phoebe Lo, a New York University graduate student studying School Counseling, is researching how school counselors can understand and help students who are D/deaf / hard of hearing. To facilitate this, she is looking for D/deaf / hard of hearing students to fill out a survey about their experiences. All responses are confidential and used solely for research.", "https://docs.google.com/forms/d/e/1FAIpQLScuN2dMY6eJeJdQdv_RRA7uWD4sifVXAYNZ9AZ6EgZP__ugbQ/viewform");
/* 2 */INSERT INTO feed (title, entry_date, content) VALUES ("E-board Office Hours", "April 9, 2018", "If you'd like extra practice with a song or vocabulary we've done in Sign Choir, or are interested in learning more about ASL, Deaf culture, or CUDAP, feel free to come to any board member's office hours; times are on the attached board list. Please notify them via email so they know to expect you.");
/* 3 */INSERT INTO feed (title, entry_date, content) VALUES ("Apparel Sale", "April 10, 2018", "Thank you to everyone who ordered from CUDAP's first apparel sale! The apparel has been ordered and should arrive within the next two weeks; if you ordered, we will send you an email when it comes in.");
/* 4 */INSERT INTO feed (title, entry_date, content) VALUES ("E-board Openings", "April 12, 2018", "We are excited to announce that the following positions will be open on our executive board for the Fall 2018 Semester: Treasurer, Secretary, Outreach Chair, Publicity Coordinator, and Events Coordinator. Descriptions of all board positions can be found below. If you're interested, please fill out the application. Applications are due Wednesday, April 25th to cudap@cornell.edu. Any questions or concerns may be directed to our email or any current board member. We encourage any student, regardless of ability or experience, to apply!");
/* 5 */INSERT INTO feed (title, entry_date, content) VALUES ("Panel discussion on disability and intersectionality", "April 16, 2018", "The Undergraduate Disability Studies Journal is hosting a panel discussion on disability and intersectionality on campus tomorrow, April 17th, from 4:30-6pm in Ives Hall Room 116. Please join us to learn about the experience of students with disabilities on campus who will share about their personal experiences and academic work in this area. The purpose of the panel is to inspire our campus community to think more broadly of disability as diversity, and create a more welcoming space for students with intersectional experiences.");
/* 6 */INSERT INTO feed (title, entry_date, content) VALUES ("Rehearsal this week", "April 18, 2018", "Join CUDAP this Wednesday, from 5:30 to 6:30, in GSH room 164 for our weekly Sign Choir meeting! We will be reviewing three songs from this past year: Cups Song - Anna Kendrick, It's Time - Imagine Dragons, and Shape of You - Ed Sheeran.");
/* 7 */INSERT INTO feed (title, entry_date, content) VALUES ("CUDAP Arch Sign", "April 23, 2018", "Come to CUDAP's Arch Sign tomorrow from 9:00 to 9:30 at the Balch Arch! We'll be sharing your favorite pieces!");

INSERT INTO feed_tags (name) VALUES ("#signchoir");
INSERT INTO feed_tags (name) VALUES ("#performance");
INSERT INTO feed_tags (name) VALUES ("#eboard");
INSERT INTO feed_tags (name) VALUES ("#interest");
INSERT INTO feed_tags (name) VALUES ("#apparel");
INSERT INTO feed_tags (name) VALUES ("#officehours");

INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (1, 2);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (2, 1);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (3, 4);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (4, 3);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (5, 5);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (6, 3);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (6, 6);
INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (7, 4);

INSERT INTO feed_attachments (file_name, file_ext) VALUES ("officehourslist.docx", "docx");
INSERT INTO feed_attachments (file_name, file_ext) VALUES ("board-descriptions.pdf", "pdf");
INSERT INTO feed_attachments (file_name, file_ext) VALUES ("board-application.pdf", "pdf");

INSERT INTO feed_to_feed_attachments (feed_id, feed_attachment_id) VALUES (2, 1);
INSERT INTO feed_to_feed_attachments (feed_id, feed_attachment_id) VALUES (4, 2);
INSERT INTO feed_to_feed_attachments (feed_id, feed_attachment_id) VALUES (4, 3);

/* Meet the board (board members) */
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Mary Grace Hager', 'President', 'Mathematics & Computer Science', '2019', 'She joined CUDAP her freshman year to learn more about ASL and Deaf culture. Mary Grace became Treasurer in the spring of 2016 and transitioned into Co-President a year later.', '1.png');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Juliet Remi', 'Outreach Chair', 'Industrial and Labor Relations', '2020', 'She joined CUDAP in her freshman year to improve her American Sign Language and learn more about the Deaf community and culture.', '2.png');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Katherine Dillon', 'Secretary', 'Human Biology, Health, and Society', '2019', "She joined the Cornell University Deaf Awareness Project as a freshman and has been CUDAP's secretary since Spring 2017. Katie is dedicated to CUDAP's accessibility goals.", '3.png');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Lucia Gomez', 'Events Coordinator', 'Computer Science & Linguistics', '2021', "She joined CUDAP during her first semester to connect with other students who love ASL and to spread awareness about Deaf culture. Lucia loves to gloss songs, and she's translated everything from Hamilton to Twenty One Pilots.", '4.png');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Alyssa Trigg', 'Treasurer', 'Computer Science & Linguistics', '2018', 'She has been a member of CUDAP since spring of 2016 and is currently the treasurer of the Cornell University Deaf Awareness Project. She is also a member of the Cornell Swing Dance Club, and assorted other clubs.', '5.png');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Pamela Wildstein', 'Publicity Designer', 'Environmental and Sustainability Sciences', '2020', 'She joined CUDAP in the Fall of her sophmore year, after transferring from Penn State, with the goal of becoming an advocate for the Deaf community.', '6.png');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Jonathan Masci', 'Alumni Advisor', 'Linguistics', '2016', 'He joined CUDAP his sophomore year to learn more about ASL and Deaf culture. Since graduating, he has served as an AmeriCorps member with City Year New Hampshire, where he gives students individualized tutoring in a high-need elementary school. He is honored to have the opportunity to support the newest generation of CUDAP leaders.', '7.png');

/* Gallery */
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');
INSERT INTO images (title, file_ext) VALUES ('test', 'jpg');

INSERT INTO categories (name) VALUES ('Sign Choir');
INSERT INTO categories (name) VALUES ('Workshops');
INSERT INTO categories (name) VALUES ('Deaf Awareness Week');

INSERT INTO images_cats (image_id, cat_id) VALUES ('1', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('2', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('3', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('4', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('5', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('6', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('7', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('8', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('9', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('10', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('11', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('12', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('13', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('14', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('15', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('16', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('17', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('18', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('19', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('20', '3');
INSERT INTO images_cats (image_id, cat_id) VALUES ('21', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('22', '2');
INSERT INTO images_cats (image_id, cat_id) VALUES ('23', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('24', '2');
INSERT INTO images_cats (image_id, cat_id) VALUES ('25', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('26', '2');
INSERT INTO images_cats (image_id, cat_id) VALUES ('27', '2');
INSERT INTO images_cats (image_id, cat_id) VALUES ('28', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('29', '2');
INSERT INTO images_cats (image_id, cat_id) VALUES ('30', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('31', '1');

/* Learn ASL */
INSERT INTO signs(word, frame, image_path, description) VALUES ('Cornell', '1', 'uploads/signs/1.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('Cornell', '2', 'uploads/signs/2.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('Cornell', '3', 'uploads/signs/3.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('Deaf', '1', 'uploads/signs/4.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('Deaf', '2', 'uploads/signs/5.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('Deaf', '3', 'uploads/signs/6.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('hard of hearing', '1', 'uploads/signs/7.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('hard of hearing', '2', 'uploads/signs/8.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('hard of hearing', '3', 'uploads/signs/9.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('hearing', '1', 'uploads/signs/10.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('hearing', '2', 'uploads/signs/11.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('hearing', '3', 'uploads/signs/12.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('help', '1', 'uploads/signs/13.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('help', '2', 'uploads/signs/14.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('home', '1', 'uploads/signs/15.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('home', '2', 'uploads/signs/16.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('school', '1', 'uploads/signs/17.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('school', '2', 'uploads/signs/18.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('who', '1', 'uploads/signs/19.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('who', '2', 'uploads/signs/20.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('what', '1', 'uploads/signs/21.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('what', '2', 'uploads/signs/22.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('where', '1', 'uploads/signs/23.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('where', '2', 'uploads/signs/24.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('why', '1', 'uploads/signs/25.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('why', '2', 'uploads/signs/26.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('how', '1', 'uploads/signs/27.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('how', '2', 'uploads/signs/28.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('how', '3', 'uploads/signs/29.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('Ithaca', '1', 'uploads/signs/33.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('Ithaca', '2', 'uploads/signs/34.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('Ithaca', '3', 'uploads/signs/35.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('learn', '1', 'uploads/signs/36.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('learn', '2', 'uploads/signs/37.jpg');
INSERT INTO signs(word, frame, image_path, description) VALUES ('sign', '1', 'uploads/signs/38.jpg', 'lorem ipsum');
INSERT INTO signs(word, frame, image_path) VALUES ('sign', '2', 'uploads/signs/39.jpg');
INSERT INTO signs(word, frame, image_path) VALUES ('sign', '3', 'uploads/signs/40.jpg');

/* Resources */
INSERT INTO links(name, url) VALUES ('www.startasl.com', 'https://www.startasl.com/learn-sign-language-asl');
INSERT INTO links(name, url) VALUES ('www.signlanguage101.com', 'http://www.signlanguage101.com/');
INSERT INTO links(name, url) VALUES ('www.aslpro.com', 'http://www.aslpro.com/');
INSERT INTO links(name, url) VALUES ('www.theaslapp.com', 'http://theaslapp.com/');

INSERT INTO ppts(link, label) VALUES ('https://drive.google.com/open?id=1GGxkO2OQfHAXbyL5fxE3WvdWNRz_zbuUmMH8QHrFr0A', 'animal vocab');
INSERT INTO ppts(link, label) VALUES ('https://drive.google.com/open?id=1QGNO8zuwVmgnep4JpUbQPo5-ARL8LyXXEcdCoBabuq0', 'education vocab');
INSERT INTO ppts(link, label) VALUES ('https://docs.google.com/presentation/d/17X-7bdALqNvkHFXDveoC1cfMq2JNcc8siIa72F58tf4/edit?usp=sharing', 'emotions vocab');
INSERT INTO ppts(link, label) VALUES ('https://docs.google.com/presentation/d/1khDO5KMj6oN60cG7cU0f2sFrGYMr2Gf6feuwh7nptH4/edit?usp=sharing', 'health vocab');
INSERT INTO ppts(link, label) VALUES ('https://docs.google.com/presentation/d/1GIrDhv07cO9qaIqyPpklsohm-st_Tl5GnxKETEBLHe4/edit?usp=sharing', 'occupations vocab');
INSERT INTO ppts(link, label) VALUES ('https://docs.google.com/presentation/d/1XvC_OT-pbz5lymTOlO0oyxW9ZgLEol1a-V6kXTj3Kl0/edit?usp=sharing', 'majors vocab');
INSERT INTO ppts(link, label) VALUES ('https://docs.google.com/presentation/d/1Don8sCoyG3SKTrnvdvY-bzH46WXf1Jtf6LtSSOVma34/edit?usp=sharing', 'december holidays vocab');


/* Log in */
INSERT INTO users(username, password) VALUES ('janedoe', '$2y$10$92IushmzxvE9gSiAEb8d2Op16RZSp.5Vtm4snVsyhP1oI8zrEnrOe'); /* Password is 'gobigred' */
INSERT INTO users(username, password) VALUES ('gm', '$2y$10$jFXqOXL7F.Q4rSBSNosGEus6cF2lOZ8vIVJoFpQCaGXOGggIfaqzq'); /* Password is 'liftthechorus' */
