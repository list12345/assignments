CREATE DATABASE testdb;

USE testdb;

CREATE TABLE user
(
    id            int          NOT NULL AUTO_INCREMENT,
    email         varchar(128) NOT NULL,
    password_hash varchar(128) NOT NULL,
    lastname      varchar(128) NOT NULL,
    firstname     varchar(128) NOT NULL,
    state         int          NOT NULL,
    role          varchar(128) NOT NULL,
    created_at    timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT email_uk UNIQUE (email)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO user (email, password_hash, lastname, firstname, state, role)
VALUES ('test@test.com', '9a92b12c781be2e389e822325ed1ae93', 'John', 'Smith', 1, 'admin');

INSERT INTO user (email, password_hash, lastname, firstname, state, role)
VALUES ('testuser@test.com', '9a92b12c781be2e389e822325ed1ae93', 'Jane', 'Like', 1, 'user');