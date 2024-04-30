CREATE TABLE comments (
	comment_id CHAR(15) PRIMARY KEY,
    comment_type VARCHAR(50),
    comment_title LONGTEXT,
    comment_body LONGTEXT,
    user_id CHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);