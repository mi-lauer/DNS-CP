create table domains (
  id                INTEGER PRIMARY KEY,
  name              VARCHAR(255) NOT NULL COLLATE NOCASE,
  master            VARCHAR(128) DEFAULT NULL,
  last_check        INTEGER DEFAULT NULL,
  type              VARCHAR(6) NOT NULL,
  notified_serial   INTEGER DEFAULT NULL, 
  account           VARCHAR(40) DEFAULT NULL
  owner			    INTEGER Not NULL
);

CREATE UNIQUE INDEX name_index ON domains(name);

CREATE TABLE records (
  id              INTEGER PRIMARY KEY,
  domain_id       INTEGER DEFAULT NULL,
  name            VARCHAR(255) DEFAULT NULL, 
  type            VARCHAR(10) DEFAULT NULL,
  content         VARCHAR(65535) DEFAULT NULL,
  ttl             INTEGER DEFAULT NULL,
  prio            INTEGER DEFAULT NULL,
  change_date     INTEGER DEFAULT NULL
);
              
CREATE INDEX rec_name_index ON records(name);
CREATE INDEX nametype_index ON records(name,type);
CREATE INDEX domain_id ON records(domain_id);

create table supermasters (
  ip          VARCHAR(64) NOT NULL, 
  nameserver  VARCHAR(255) NOT NULL COLLATE NOCASE, 
  account     VARCHAR(40) DEFAULT NULL
);

CREATE TABLE dns_users (
 id        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
 username  VARCHAR(255) NOT NULL UNIQUE,
 password  VARCHAR(255) NOT NULL,
 admin     INTEGER NOT NULL default 0
);

INSERT INTO dns_users (id, username, password, admin) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);