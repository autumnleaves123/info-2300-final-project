/* TODO: create tables */

/* Home page (mewsfeed) */

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

/* Resources */

/* Log in
--> this is my example users table from P3 for login testing purposes - Autumn */
CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  session INTEGER UNIQUE
);

/* TODO: initial seed data */

/* Home page (mewsfeed) */

/* Meet the board (board members) */

INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Jonathan Masci', 'Alumni Advisor', 'Linguistics', '2016', 'He joined CUDAP in his sophomore year in order to learn more about American Sign Language and Deaf culture. During his time in the organization, he found a passion for advocacy and service learning. It was gratifying to work with dedicated colleagues to raise awareness of the issues facing people who are Deaf and Hard of Hearing, and to inspire fellow students to learn more about Deaf culture.', '1.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Mary Grace Hager', 'Co-President', 'Mathematics & Computer Science', '2019', 'She joined CUDAP her freshman year to learn more about ASL and Deaf culture. Mary Grace became Treasurer in the spring of 2016 and transitioned into Co-President a year later. She is excited to continue working to make Cornell a more accessible campus and to raise awareness of issues facing the Deaf and Hard-of-Hearing communities.', '2.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Diana Bartolotta', 'Co-President', 'Environmental & Sustainability Sciences', '2019', 'She joined CUDAP her freshman year to pursue advocacy opportunities and to connect with others who share an interest in learning and improving their American Sign Language skills. Diana advocates for inclusivity and accessibility on campus through her sorority, Kappa Delta.', '3.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Juliet Remi', 'Outreach Chair', 'Industrial and Labor Relations', '2020', 'She joined CUDAP in her freshman year to improve her American Sign Language and learn more about the Deaf community and culture. She is now training for the outreach chair position. Outside of CUDAP, Juliet is involved with Empathy, Assistance and Referral Service (EARS), Orientation, and Cornell Dining.', '4.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Katherine Dillon', 'Secretary', 'Human Biology, Health, and Society', '2019', "She joined the Cornell University Deaf Awareness Project as a freshman and has been CUDAP's secretary since Spring 2017. Katie is dedicated to CUDAP's accessibility goals, and particularly enjoys sharing the beauty of American Sign Language (ASL) as part of the group.", '5.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Lucia Gomez', 'Events Coordinator', 'Computer Science & Linguistics', '2021', "She joined CUDAP during her first semester to connect with other students who love ASL and to spread awareness about Deaf culture. Lucia loves to gloss songs, and she's translated everything from Hamilton to Twenty One Pilots.", '6.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Alyssa Trigg', 'Treasurer', 'Computer Science & Linguistics', '2018', 'She has been a member of CUDAP since spring of 2016 and is currently the treasurer of the Cornell University Deaf Awareness Project. She is also a member of the Cornell Swing Dance Club, and assorted other clubs.', '7.jpg');
INSERT INTO eboard(name, position, major, classyear, bio, image) VALUES ('Pmela Wildstein', 'Publicity Designer', 'Environmental and Sustainability Sciences', '2020', 'She joined CUDAP in the Fall of her sophmore year, after transferring from Penn State, with the goal of becoming an advocate for the Deaf community and learning more about its culture and language. Pam is excited to use her abilities as a graphic designer to help spread awareness about American Sign Language and those who use it.', '8.jpg');

/* Gallery */

/* Learn ASL */

/* Resources */

/* Log in */

INSERT INTO users(username, password) VALUES ('janedoe', '$2y$10$92IushmzxvE9gSiAEb8d2Op16RZSp.5Vtm4snVsyhP1oI8zrEnrOe'); /* Password is 'gobigred' */
INSERT INTO users(username, password) VALUES ('gm', '$2y$10$jFXqOXL7F.Q4rSBSNosGEus6cF2lOZ8vIVJoFpQCaGXOGggIfaqzq'); /* Password is 'liftthechorus' */
