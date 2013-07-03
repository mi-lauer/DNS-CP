CREATE TABLE users (
id        SERIAL NOT NULL PRIMARY KEY,
username  VARCHAR(255) NOT NULL,
password  VARCHAR(255) NOT NULL,
admin     INTEGER NOT NULL default 0,
UNIQUE  (username)
);

# User: admin
# Pass: admin
INSERT INTO users (id, username, password, admin) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

ALTER TABLE soa ADD COLUMN owner INTEGER NOT NULL;