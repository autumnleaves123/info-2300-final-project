/* TODO: create tables */

/* Home page (mewsfeed) */

/* Meet the board (board members) */

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

/* Gallery */

/* Learn ASL */

/* Resources */

/* Log in */

INSERT INTO users(username, password) VALUES ('janedoe', '$2y$10$92IushmzxvE9gSiAEb8d2Op16RZSp.5Vtm4snVsyhP1oI8zrEnrOe'); /* Password is 'gobigred' */
INSERT INTO users(username, password) VALUES ('gm', '$2y$10$jFXqOXL7F.Q4rSBSNosGEus6cF2lOZ8vIVJoFpQCaGXOGggIfaqzq'); /* Password is 'liftthechorus' */
