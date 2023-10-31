
CREATE TABLE sys_users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    usertype VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
    PRIMARY KEY (id)
);

INSERT INTO sys_users (usertype, username, pwd, email) VALUES (
    'admin',
    'useradmin',
    '$2y$12$/YqX9.5wZ27rrUt6YFFjWuxqTiu9jKfnWqqCwnXXwVXSQA.CMzKd6',
    'user@admin.com'
);