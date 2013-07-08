CREATE TABLE dns_soa (
	id      integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	origin  VARCHAR(255) NOT NULL UNIQUE,
	ns      VARCHAR(255) NOT NULL,
	mbox    VARCHAR(255) NOT NULL,
	serial  INTEGER NOT NULL default 1,
	refresh INTEGER NOT NULL default 28800,
	retry   INTEGER NOT NULL default 7200,
	expire  INTEGER NOT NULL default 604800,
	minimum INTEGER NOT NULL default 86400,
	ttl     INTEGER NOT NULL default 86400,
	owner	INTEGER Not NULL
);

CREATE TABLE dns_rr (
  id     integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  zone   INTEGER NOT NULL UNIQUE,
  name   VARCHAR(200) NOT NULL UNIQUE,
  data   VARCHAR(200) NOT NULL UNIQUE,
  aux    INTEGER NOT NULL default 0,
  ttl    INTEGER NOT NULL default 86400,
  type   VARCHAR(200) NOT NULL UNIQUE
);

CREATE TABLE dns_users (
id        integer PRIMARY KEY AUTOINCREMENT NOT NULL,
username  VARCHAR(255) NOT NULL UNIQUE,
password  VARCHAR(255) NOT NULL,
admin     INTEGER NOT NULL default 0
);

INSERT INTO dns_users (id, username, password, admin) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);
