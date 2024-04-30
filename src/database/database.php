<?php

use LDAP\Result;

class ConnectDB
{
  private $conn;

  public function __construct()
  {
    $this->conn =
      new PDO(
        "mysql:host=localhost;dbname=final_project",
        "root",
        ""
      );
  }

  public function getAllCategories()
  {
    $sql = "SELECT id, name FROM categories";
    $result = $this->conn->prepare($sql);
    $result->execute();
    $categories = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($categories)) return [];

    return $categories;
  }

  public function getCategoriesById($id)
  {
    $sql = "SELECT id, name FROM categories WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    $categories = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($categories)) return [];

    return $categories[0];
  }

  public function addCategories($id, $name)
  {
    $sql = "INSERT INTO categories (id, name) VALUES (?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$id, $name]);
  }

  public function deleteCategoriesById($id)
  {
    $sql = "DELETE FROM categories WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
  }

  public function getAllUsers()
  {
    $sql = "SELECT id, username, email, phone, userStatus, image, createdAt FROM users";
    $result = $this->conn->prepare($sql);
    $result->execute();
    $users = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) return [];

    return $users;
  }




  public function getUserById($id)
  {
    $sql = "SELECT id, username, email, phone, userStatus, image FROM users WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    $users = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) return [];

    return $users;
  }

  public function addUser($id, $username, $email, $phone, $password, $userStats)
  {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (id, username, email, phone, userStatus, password) VALUES (?, ?, ?, ?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$id, $username,  strtolower($email), $phone,  $userStats, $hashedPassword]);
  }

  public function addDoctor($id, $type)
  {
    $sql = "INSERT INTO doctors (id, type_id) VALUES (?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$id,  $type]);
  }

  public function getAllDoctors()
  {
    $sql = "SELECT a.id, a.username, a.email, a.userStatus, a.phone, a.image, c.name as type FROM users AS a INNER JOIN doctors AS b ON a.id = b.id INNER JOIN categories as c ON b.type_id = c.id; ";
    $result = $this->conn->prepare($sql);
    $result->execute();
    $doctors = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($doctors)) return [];

    return $doctors;
  }

  public function getDoctorById($id)
  {
    $sql = "SELECT a.id, a.username, a.email, a.userStatus, a.phone, a.image, c.name as type FROM users AS a INNER JOIN doctors AS b ON a.id = b.id INNER JOIN categories as c ON b.type_id = c.id AND b.id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    $doctors = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($doctors)) return [];

    return $doctors;
  }

  public function loginUser($email)
  {
    $sql = "SELECT id, username, email, phone, userStatus, password, image FROM users WHERE email = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$email]);

    $user = $result->fetch(PDO::FETCH_ASSOC);

    if (empty($user)) return [];

    return $user;
  }

  public function updateUserById($id, $username, $email, $phone, $image)
  {
    $sql = "UPDATE users SET username = ?, image = ?, phone = ?, email= ? WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$username, $image, $phone, $email, $id]);
  }

  public function deleteUserById($id)
  {
    $sql = "DELETE FROM users WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
  }

  public function makeAdmin($id)
  {
    $sql = "UPDATE users SET userStatus = 'admin' WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
  }

  public  function getAllQuestion($doctor_id)
  {
    $sql = "SELECT ask_id, customer_id, doctor_id, ask_id, ask_text, answer, createdAt FROM asking WHERE doctor_id = ?;";
    $result = $this->conn->prepare($sql);
    $result->execute([$doctor_id]);
    $questions = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($questions)) return [];

    return $questions;
  }

  public function addQuestion($ask_id, $customer_id, $doctor_id, $ask_text)
  {
    $sql = "INSERT INTO asking(ask_id, customer_id,doctor_id,ask_text) VALUES (?, ?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$ask_id, $customer_id, $doctor_id, $ask_text]);
  }

  public function addAnswer($ask_id, $answer)
  {
    $sql = "UPDATE asking SET answer = ? WHERE ask_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$answer, $ask_id]);
  }

  public function getAllAppointments()
  {
    $sql = "SELECT appointment_id, date, startsAt, endsAt, doctor_id, status FROM appointments";
    $result = $this->conn->prepare($sql);
    $result->execute();
    $appointments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($appointments)) return [];

    return $appointments;
  }

  public function makeAppointment($id, $date, $startsAt, $endsAt, $doctor_id, $status)
  {
    $sql = "INSERT INTO appointments (appointment_id, date, startsAt, endsAt, doctor_id, status) VALUES (?, ?, ?, ?, ?, ?)";

    $result = $this->conn->prepare($sql);
    $result->execute([$id, $date, $startsAt, $endsAt, $doctor_id, $status]);
  }

  public function getAppointmentsByDocId($doctor_id)
  {
    $sql = "SELECT appointment_id, date, startsAt, endsAt, doctor_id, status FROM appointments WHERE doctor_id = ? ORDER BY status";
    $result = $this->conn->prepare($sql);
    $result->execute([$doctor_id]);
    $appointments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($appointments)) return [];

    return $appointments;
  }

  public function getAppointmentByAppointmentId($appointment_id)
  {
    $sql = "SELECT appointment_id, date, startsAt, endsAt, doctor_id, status FROM appointments WHERE appointment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$appointment_id]);
    $appointments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($appointments)) return [];

    return $appointments;
  }

  public function updateAppointmentStatById($status, $appointment_id)
  {
    $sql = "UPDATE appointments set status = ? WHERE appointment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$status,  $appointment_id]);
  }

  public function deleteAppointmentById($appointment_id)
  {
    $sql = "DELETE FROM appointments WHERE appointment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$appointment_id]);
  }

  public function addBookedAppointment($id, $appointment_id, $customer_id)
  {
    $sql = "INSERT INTO booked_online_appointments (id, appointment_id, customer_id) VALUES (?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$id, $appointment_id, $customer_id]);
  }

  public function getAllBookedAppointments()
  {
    $sql = "SELECT id, appointment_id, customer_id FROM booked_online_appointments";
    $result = $this->conn->prepare($sql);
    $result->execute();
    $booked_appointments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($booked_appointments)) return [];

    return $booked_appointments;
  }

  public function getBookedAppointmentByAppointmentId($appointment_id)
  {
    $sql = "SELECT id, appointment_id, customer_id FROM booked_online_appointments WHERE appointment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$appointment_id]);
    $booked_appointments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($booked_appointments)) return [];

    return $booked_appointments;
  }

  public function getCustomerAppointments($customer_id)
  {
    $sql = "SELECT appointment_id, date, startsAt, endsAt, doctor_id, status FROM appointments WHERE appointment_id in (SELECT appointment_id FROM booked_online_appointments WHERE customer_id = ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$customer_id]);
    $appointments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($appointments)) return [];

    return $appointments;
  }

  public function deleteBookedAppointments($id)
  {
    $sql = "DELETE FROM booked_online_appointments WHERE appointment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
  }

  public function addInbox($comment_id, $comment_type, $comment_title, $comment_body, $user_id)
  {
    $sql = "INSERT INTO comments (comment_id, comment_type, comment_title, comment_body, user_id) VALUES (?, ?, ?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$comment_id, $comment_type, $comment_title, $comment_body, $user_id]);
  }

  public function getAllComments()
  {
    $sql = "SELECT comment_id, comment_type, comment_title, comment_body, user_id, createdAt FROM comments";
    $result = $this->conn->prepare($sql);
    $result->execute();
    $comments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($comments)) return [];

    return $comments;
  }

  public function getCommentsByUserId($user_id)
  {
    $sql = "SELECT comment_id, comment_type, comment_title, comment_body, user_id, createdAt FROM comments WHERE user_id = ? ORDER BY createdAt DESC";
    $result = $this->conn->prepare($sql);
    $result->execute([$user_id]);
    $comments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($comments)) return [];

    return $comments;
  }

  public function getCommentByCommentId($comment_id)
  {
    $sql = "SELECT comment_id, comment_type, comment_title, comment_body, user_id, createdAt FROM comments WHERE comment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$comment_id]);
    $comments = $result->fetchAll(PDO::FETCH_ASSOC);

    if (empty($comments)) return [];

    return $comments;
  }

  public function deleteCommentById($comment_id)
  {
    $sql = "DELETE FROM comments WHERE comment_id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$comment_id]);
  }
}
