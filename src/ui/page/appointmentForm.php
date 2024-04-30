<!DOCTYPE html>
<html lang="en">

<?php
session_start();
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

$err_msg = "";
$is_error = false;
$appointment_date = "";
$hour_start = $minute_start = "";
$hour_end = $minute_end = "";

if (isset($_POST["done"])) {
  $db->deleteAppointmentById($_POST["done"]);
}

if (isset($_POST["delete"])) {
  $delete_id = $_POST["delete"];
  $db->deleteAppointmentById($delete_id);
  header("Location: ./appointmentForm.php");
  exit;
}

if (isset($_POST["accept"])) {
  $comments_data = $db->getAllComments();
  $booked_appointment = $db->getBookedAppointmentByAppointmentId($_POST["accept"])[0];

  if (empty($comments_data)) {
    $db->addInbox(generateCommentId(), "appointment", "Accepted Appointment", "Your appointments has been accepted by Dr. {$_SESSION['user_info']['username']}", $booked_appointment["customer_id"]);
    $db->updateAppointmentStatById("booked", $_POST["accept"]);
  } else {
    $comment_id = generateCommentId();
    foreach ($comments_data as $comment) {
      if ($comment["comment_id"] == $comment_id) {
        $comment_id = generateCommentId();
      }
    }
    $db->addInbox($comment_id, "appointment", "Accepted Appointment", "Your appointments has been accepted by Dr. {$_SESSION['user_info']['username']}", $booked_appointment["customer_id"]);
    $db->updateAppointmentStatById("booked", $_POST["accept"]);
    header("Location: ./appointmentForm.php");
  }
}

if (isset($_POST["decline"])) {
  $db->updateAppointmentStatById("available", $_POST["decline"]);
  $db->deleteBookedAppointments($_POST["decline"]);
  header("Location: ./appointmentForm.php");
}

if (isset($_POST["add"])) {
  $is_error = true;
  $appointment_date = $_POST["appointment_date"];
  $hour_start = $_POST["hour_start"];
  $minute_start = $_POST["minute_start"];
  $hour_end = $_POST["hour_end"];
  $minute_end = $_POST["minute_end"];
  $id = genAppointmentId();
  $startsAt = sprintf('%02d:%02d:00', $hour_start, $minute_start);
  $endsAt = sprintf('%02d:%02d:00', $hour_end, $minute_end);

  $appointments_data = $db->getAllAppointments();

  if (empty($appointment_date)) {
    $err_msg = "Date is needed";
  } elseif ($startsAt >= $endsAt) {
    $err_msg = "Input the time correctly";
  } else {
    if (empty($appointments_data)) {
      $is_error = false;
      $db->makeAppointment($id, $appointment_date, $startsAt, $endsAt, $_SESSION["doctor_info"]["id"], "available");
      header("Location: ./appointmentForm.php");
      exit;
    } else {
      $id_arr = [];
      foreach ($appointments_data as $appointment) {
        array_push($id_arr, $appointment["appointment_id"]);
      }

      while (in_array($id, $id_arr)) {
        $id = genAppointmentId();
      }

      $db->makeAppointment($id, $appointment_date, $startsAt, $endsAt, $_SESSION["doctor_info"]["id"], "available");

      header("Location: ./appointmentForm.php");
      exit;
    }
  }
}

$err_display = !$is_error ? "hidden" : "flex";
?>

<body class="relative min-h-screen min-w-[97vw] bg-[#02071b] text-white">
  <?php
  $minDate = date("Y-m-d", strtotime("+2 days"));
  ?>

  <div class="px-10 py-5">
    <div class="flex items-center gap-3 mb-3">
      <a href="./home.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase text-2xl hidden md:block">appointments</h1>
    </div>
    <!-- Form -->
    <form style="background-size: 100% 100%;
        background-position: 0px 0px;
        background-image: radial-gradient(57% 79% at 95% 5%, #0A345BFF 1%, #04102AFF 71%);" autocomplete="off" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="max-w-[400px] flex flex-col justify-center items-center gap-y-5 rounded-2xl h-[490px] mx-auto mt-10 transition-all duration-300 drop-shadow-[0_0_5px_rgba(255,255,255,0.15)] hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.25)]">


      <div class="flex flex-col items-start w-[70%] gap-y-0.5">
        <label for="appointment_date" class="capitalize font-semibold text-lg tracking-wide">date:</label>
        <input type="date" min="<?= $minDate ?>" name="appointment_date" class="px-3 py-1 border border-white w-full text-white bg-[#04102AFF]  appearance-none rounded-lg" placeholder="select date" value="value=" <?= $appointment_date ?>"">
      </div>

      <div class="flex flex-col items-start w-[70%] gap-y-0.5">
        <p class="capitalize font-semibold text-lg tracking-wide">startsAt:</p>
        <div class="flex items-center gap-x-3">
          <label for="hour_start" class="capitalize font-semibold text-lg tracking-wide">hour:</label>
          <select name="hour_start" class="bg-[#04102AFF] border border-white rounded px-1">
            <?php
            for ($i = 0; $i < 24; $i++) {
            ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
          </select>
          <label for="minute_start" class="capitalize font-semibold text-lg tracking-wide">minute:</label>
          <select name="minute_start" class="bg-[#04102AFF] border border-white rounded px-1">
            <?php
            for ($i = 0; $i < 60; $i++) {
            ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
          </select>
        </div>

      </div>

      <div class="flex flex-col items-start w-[70%] gap-y-0.5">
        <p class="capitalize font-semibold text-lg tracking-wide">endsAt:</p>
        <div class="flex items-center gap-x-3">
          <label for="hour_end" class="capitalize font-semibold text-lg tracking-wide">hour:</label>
          <select name="hour_end" class="bg-[#04102AFF] border border-white rounded px-1">
            <?php
            for ($i = 0; $i < 24; $i++) {
            ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
          </select>
          <label for="minute_end" class="capitalize font-semibold text-lg tracking-wide">minute:</label>
          <select name="minute_end" class="bg-[#04102AFF] border border-white rounded px-1">
            <?php
            for ($i = 0; $i < 60; $i++) {
            ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
          </select>
        </div>

      </div>

      <button name="add" type="submit" class="bg-blue-600 hover:bg-blue-800 duration-300 transition-colors px-3 py-1 rounded font-semibold w-[70%] capitalize">add appointment</button>

    </form>

    <div>
      <div class="p-4 border-b border-white w-full">
        <h2 class="text-xl md:text-2xl font-bold tracking-wider uppercase mt-12">your appointments</h2>
      </div>

      <main class="p-6 flex flex-wrap gap-5 items-start">
        <?php
        $doc_appointments = $db->getAppointmentsByDocId($_SESSION["doctor_info"]["id"]);
        if (empty($doc_appointments)) {
        ?>
          <p class="capitalize text-xl font-semibold tracking-wide">you don't have any appointments</p>
          <?php
        } else {
          foreach ($doc_appointments as $dAppointment) {
          ?>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="w-[290px] px-4 py-2 border border-white rounded-xl relative gap-2">
              <p>Date: <?= $dAppointment["date"] ?></p>
              <p>Time: <?php echo substr($dAppointment["startsAt"], 0, 5) . "-" . substr($dAppointment["endsAt"], 0, 5); ?></p>
              <p class="capitalize">status: <?= $dAppointment["status"] ?></p>

              <?php
              if ($dAppointment["status"] == "available") {
              ?>
                <button class="absolute right-4 bottom-2 capitalize bg-red-600 px-2 py-0.5 text-[13px] hover:opacity-80 transition-all duration-300 font-semibold rounded" name="delete" value="<?= $dAppointment["appointment_id"] ?>">delete</button>
              <?php
              } elseif ($dAppointment["status"] == "pending") {
              ?>
                <div class="flex gap-3 mt-2">
                  <button value="<?= $dAppointment["appointment_id"] ?>" class="py-0.5 capitalize font-semibold px-4 rounded-lg bg-red-600" name="decline">decline</button>
                  <button value="<?= $dAppointment["appointment_id"] ?>" class="py-0.5 capitalize font-semibold px-4 rounded-lg bg-green-600" name="accept">accept</button>
                </div>
              <?php
              } elseif ($dAppointment["status"] == "booked") {
              ?>
                <button class="absolute right-4 bottom-2 capitalize bg-blue-600 px-2 py-0.5 text-[13px] hover:opacity-80 transition-all duration-300 font-semibold rounded" name="done" value="<?= $dAppointment["appointment_id"] ?>">done</button>
              <?php
              }
              ?>


            </form>
        <?php
          }
        }
        ?>

      </main>
    </div>

    <?php include("../components/error_display.php"); ?>
</body>

</html>