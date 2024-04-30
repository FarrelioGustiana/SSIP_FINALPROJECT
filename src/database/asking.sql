CREATE TABLE asking (
	ask_id CHAR(15),
    customer_id CHAR(15),
    doctor_id CHAR(15),
    ask_text LONGTEXT,
    answer LONGTEXT,
    PRIMARY KEY (ask_id),
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES  doctors(id) ON DELETE CASCADE ON UPDATE CASCADE,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);