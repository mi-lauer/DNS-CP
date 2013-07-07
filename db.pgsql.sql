CREATE TABLE dns_soa (
	id      SERIAL NOT NULL PRIMARY KEY,
	origin  VARCHAR(255) NOT NULL,
	ns      VARCHAR(255) NOT NULL,
	mbox    VARCHAR(255) NOT NULL,
	serial  INTEGER NOT NULL default 1,
	refresh INTEGER NOT NULL default 28800,
	retry   INTEGER NOT NULL default 7200,
	expire  INTEGER NOT NULL default 604800,
	minimum INTEGER NOT NULL default 86400,
	ttl     INTEGER NOT NULL default 86400,
	UNIQUE  (origin)
);

CREATE TABLE dns_rr (
  id     SERIAL NOT NULL PRIMARY KEY,
  zone   INTEGER NOT NULL,
  name   VARCHAR(200) NOT NULL,
  data   BYTEA NOT NULL,
  aux    INTEGER NOT NULL default 0,
  ttl    INTEGER NOT NULL default 86400,
  type   VARCHAR(5) NOT NULL CHECK (type='A' OR type='AAAA' OR type='CNAME' OR type='HINFO' OR type='MX' OR type='NAPTR' OR type='NS' OR type='PTR' OR type='RP' OR type='SRV' OR type='TXT'),
  UNIQUE (zone,name,type,data),
  FOREIGN KEY (zone) REFERENCES dns_soa (id) ON DELETE CASCADE
);

CREATE TABLE dns_users (
id        SERIAL NOT NULL PRIMARY KEY,
username  VARCHAR(255) NOT NULL,
password  VARCHAR(255) NOT NULL,
admin     INTEGER NOT NULL default 0,
UNIQUE  (username)
);

INSERT INTO dns_users (id, username, password, admin) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

ALTER TABLE soa ADD COLUMN owner INTEGER NOT NULL;
