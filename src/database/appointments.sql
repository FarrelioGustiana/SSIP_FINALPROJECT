CREATE TABLE appointments(
	appointment_id CHAR(15),
  	date DATE,
    startsAt TIME,
  	endsAt TIME,
    doctor_id CHAR(15),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE ON UPDATE CASCADE,
    status VARCHAR(20),
    CONSTRAINT PRIMARY KEY (appointment_id)
);