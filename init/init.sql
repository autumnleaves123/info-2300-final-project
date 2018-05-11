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
	file_name_1 TEXT,
	file_ext_1 TEXT,
	file_name_2 TEXT,
	file_ext_2 TEXT
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
/* 1 */INSERT INTO feed (title, entry_date, content) VALUES ("CUDAP Arch Sign", "April 23, 2018", "Come to CUDAP's Arch Sign tomorrow from 9:00 to 9:30 at the Balch Arch! We'll be sharing your favorite pieces!");
/* 2 */INSERT INTO feed (title, entry_date, content) VALUES ("Rehearsal this week", "April 18, 2018", "Join CUDAP this Wednesday, from 5:30 to 6:30, in GSH room 164 for our weekly Sign Choir meeting! We will be reviewing three songs from this past year: Cups Song - Anna Kendrick, It's Time - Imagine Dragons, and Shape of You - Ed Sheeran.");
/* 3 */INSERT INTO feed (title, entry_date, content) VALUES ("Panel discussion on disability and intersectionality", "April 16, 2018", "The Undergraduate Disability Studies Journal is hosting a panel discussion on disability and intersectionality on campus tomorrow, April 17th, from 4:30-6pm in Ives Hall Room 116. Please join us to learn about the experience of students with disabilities on campus who will share about their personal experiences and academic work in this area. The purpose of the panel is to inspire our campus community to think more broadly of disability as diversity, and create a more welcoming space for students with intersectional experiences.");
/* 4 */INSERT INTO feed (title, entry_date, content) VALUES ("E-board Openings", "April 12, 2018", "We are excited to announce that the following positions will be open on our executive board for the Fall 2018 Semester: Treasurer, Secretary, Outreach Chair, Publicity Coordinator, and Events Coordinator. Descriptions of all board positions can be found below. If you're interested, please fill out the application. Applications are due Wednesday, April 25th to cudap@cornell.edu. Any questions or concerns may be directed to our email or any current board member. We encourage any student, regardless of ability or experience, to apply!");
/* 5 */INSERT INTO feed (title, entry_date, content) VALUES ("Apparel Sale", "April 10, 2018", "Thank you to everyone who ordered from CUDAP's first apparel sale! The apparel has been ordered and should arrive within the next two weeks; if you ordered, we will send you an email when it comes in.");
/* 6 */INSERT INTO feed (title, entry_date, content) VALUES ("E-board Office Hours", "April 9, 2018", "If you'd like extra practice with a song or vocabulary we've done in Sign Choir, or are interested in learning more about ASL, Deaf culture, or CUDAP, feel free to come to any board member's office hours; times are on the attached board list. Please notify them via email so they know to expect you.");
/* 7 */INSERT INTO feed (title, entry_date, content, url_1) VALUES ("D/deaf / Hard of Hearing School Counseling Survey", "April 1, 2018", "Phoebe Lo, a New York University graduate student studying School Counseling, is researching how school counselors can understand and help students who are D/deaf / hard of hearing. To facilitate this, she is looking for D/deaf / hard of hearing students to fill out a survey about their experiences. All responses are confidential and used solely for research.", "https://docs.google.com/forms/d/e/1FAIpQLScuN2dMY6eJeJdQdv_RRA7uWD4sifVXAYNZ9AZ6EgZP__ugbQ/viewform");


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


/* Meet the board (board members) */
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Mary Grace Hager', 'President', 'Mathematics & Computer Science', '2019', 'She joined CUDAP her freshman year to learn more about ASL and Deaf culture. Mary Grace became Treasurer in the spring of 2016 and transitioned into Co-President a year later.', '1.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Juliet Remi', 'Outreach Chair', 'Industrial and Labor Relations', '2020', 'She joined CUDAP in her freshman year to improve her American Sign Language and learn more about the Deaf community and culture.', '2.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Katherine Dillon', 'Secretary', 'Human Biology, Health, and Society', '2019', "She joined the Cornell University Deaf Awareness Project as a freshman and has been CUDAP's secretary since Spring 2017. Katie is dedicated to CUDAP's accessibility goals.", '3.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Lucia Gomez', 'Events Coordinator', 'Computer Science & Linguistics', '2021', "She joined CUDAP during her first semester to connect with other students who love ASL and to spread awareness about Deaf culture. Lucia loves to gloss songs, and she's translated everything from Hamilton to Twenty One Pilots.", '4.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Alyssa Trigg', 'Treasurer', 'Computer Science & Linguistics', '2018', 'She has been a member of CUDAP since spring of 2016 and is currently the treasurer of the Cornell University Deaf Awareness Project. She is also a member of the Cornell Swing Dance Club, and assorted other clubs.', '5.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Pamela Wildstein', 'Publicity Designer', 'Environmental and Sustainability Sciences', '2020', 'She joined CUDAP in the Fall of her sophmore year, after transferring from Penn State, with the goal of becoming an advocate for the Deaf community.', '6.jpg');

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

INSERT INTO categories (name) VALUES ('Test');

INSERT INTO images_cats (image_id, cat_id) VALUES ('1', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('2', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('3', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('4', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('5', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('6', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('7', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('8', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('9', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('10', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('11', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('12', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('13', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('14', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('15', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('16', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('17', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('18', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('19', '1');
INSERT INTO images_cats (image_id, cat_id) VALUES ('20', '1');


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
