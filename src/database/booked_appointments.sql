CREATE TABLE booked_online_appointments (
    id CHAR(15) PRIMARY KEY,
	appointment_id CHAR(15),
    customer_id CHAR(15),
    FOREIGN KEY (appointment_id)
    REFERENCES appointments(appointment_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN  KEY (customer_id) REFERENCES
    users(id) ON DELETE CASCADE ON UPDATE CASCADE
);