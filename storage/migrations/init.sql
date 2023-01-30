
CREATE TABLE users
(
    id          SERIAL       PRIMARY KEY,
    username        VARCHAR(255)         UNIQUE,
    password    VARCHAR(255)    NOT NULL

);

INSERT INTO
    users (username, password)
VALUES
    ('shit', 'WEFW'),
    ('Yahoo', 'HJVF'),
    ('Bing', 'XCDR');