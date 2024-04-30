CREATE TABLE users (
    id CHAR(15) NOT NULL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    userStatus VARCHAR(55) NOT NULL DEFAULT 'customer',
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (id, username, email, phone, userStatus, password) VALUES ('123456789012345', 'First Admin', 'firstadmin@gmail.com', '0812334364', 'admin', '$2y$10$zrENwKpbhW3wkBY3Kb.FS./NbRvzyv8RNS4c4o8lRMjw9oSx9lSNy');