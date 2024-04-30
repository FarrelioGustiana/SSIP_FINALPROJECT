CREATE TABLE doctors (
	id CHAR(15) PRIMARY KEY,
    type_id CHAR(15),
    FOREIGN KEY(id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (type_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);