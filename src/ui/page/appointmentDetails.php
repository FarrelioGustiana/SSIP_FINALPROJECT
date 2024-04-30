<!DOCTYPE html>
<html lang="en">

<?php
session_start();

$appointment_id = $_GET["id"];
if (empty($appointment_id)) {
  header("Location: ./home.php");
  exit;
}
include("../components/head.php");
include("../../database/database.php");
include("../../database/generateId.php");

try {
  //code...
  $db = new ConnectDB();
} catch (\Throwable $th) {
  //throw $th;
  header("Location: ./home.php");
}

$appointment = $db->getAppointmentByAppointmentId($appointment_id)[0];
$doctor = $db->getDoctorById($appointment["doctor_id"])[0];
$is_error = false;
$err_msg = "";

if (isset($_POST["book"])) {
  $is_error = true;

  if (!isset($_SESSION["user_info"])) {
    $err_msg = "You need to <a href='./login.php' class='underline'>login</a> first";
  } else {
    $comments_data = $db->getAllComments();
    $booked_appointments = $db->getAllBookedAppointments();

    if (empty($booked_appointments)) {
      if (empty($comments_data)) {
        $db->addInbox(generateCommentId(), "appointment", "Appointment request", "You get an appointment request from {$_SESSION['user_info']['username']}", $doctor["id"]);
        $db->updateAppointmentStatById("pending", $appointment_id);
        $db->addBookedAppointment(genBookedAppoinmentId(), $appointment_id, $_SESSION["user_info"]["id"]);
        header("Location: ./appointment.php");
      } else {
        $comment_id = generateCommentId();
        foreach ($comments_data as $comment) {
          if ($comment["comment_id"] == $comment_id) {
            $comment_id = generateCommentId();
          }
        }
        $db->addInbox(generateCommentId(), "appointment", "Appointment request", "You get an appointment request from {$_SESSION['user_info']['username']}", $doctor["id"]);
        $db->updateAppointmentStatById("pending", $appointment_id);
        $db->addBookedAppointment(genBookedAppoinmentId(), $appointment_id, $_SESSION["user_info"]["id"]);
        header("Location: ./appointment.php");
      }
    } else {
      $id = genBookedAppoinmentId();
      foreach ($booked_appointments as $booked) {
        if ($booked["id"] == $id) $id = genBookedAppoinmentId();
      }

      if (empty($comments_data)) {
        $db->addInbox(generateCommentId(), "appointment", "Appointment request", "You get an appointment request from {$_SESSION['user_info']['username']}", $doctor["id"]);
        $db->updateAppointmentStatById("pending", $appointment_id);
        $db->addBookedAppointment($id, $appointment_id, $_SESSION["user_info"]["id"]);
        header("Location: ./appointment.php");
      } else {
        $comment_id = generateCommentId();
        foreach ($comments_data as $comment) {
          if ($comment["comment_id"] == $comment_id) {
            $comment_id = generateCommentId();
          }
        }
        $db->addInbox($comment_id, "appointment", "Appointment request", "You get an appointment request from {$_SESSION['user_info']['username']}", $doctor["id"]);
        $db->updateAppointmentStatById("pending", $appointment_id);
        $db->addBookedAppointment($id, $appointment_id, $_SESSION["user_info"]["id"]);
        header("Location: ./appointment.php");
      }
    }
  }
}

$err_display = !$is_error ? "hidden" : "flex";
?>

<body class="relative min-h-screen min-w-[97vw] bg-[#02071b] text-white">

  <div class="px-10 py-5">
    <div class="flex items-center gap-3 mb-3">
      <a href="./appointment.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase text-2xl hidden md:block">details</h1>
    </div>

    <!-- Appointments details -->
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="px-5 py-6 max-w-[350px] border border-white flex flex-col gap-y-2 mx-auto rounded-lg mt-8">

      <div class="mx-3 flex items-center gap-6">
        <?php

        ?>
        <div class="bg-white w-[60px] h-[60px] rounded-full overflow-hidden">
          <img src="<?= $doctor["image"] ?>" alt="" class="w-full h-full object-cover">
        </div>
        <div>
          <p class="capitalize">Dr. <?= $doctor["username"] ?></p>
          <p class="capitalize">Type: <?= $doctor["type"] ?></p>
        </div>
      </div>

      <div class="mx-3">
        <p class="uppercase text-lg font-semibold tracking-wide">Date & Time:</p>
        <p><?php echo $appointment["date"] . " " . substr($appointment["startsAt"], 0, 5) . "-" . substr($appointment["endsAt"], 0, 5) ?></p>
      </div>

      <button type="submit" name="book" class="bg-blue-600 rounded-md font-semibold mx-3 py-0.5 hover:bg-blue-800 transition-all duration-300">Book Now</button>

    </form>
    <?php include("../components/error_display.php") ?>
  </div>

</body>

</html>