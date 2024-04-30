<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include("../components/head.php");
include("../../database/database.php");

try {
  //code...
  $db = new ConnectDB();
} catch (\Throwable $th) {
  //throw $th;
  header("Location: ./home.php");
}
$display = isset($_SESSION["user_info"]) ? "block" : "hidden";
?>

<body class="relative min-h-screen min-w-[97vw] bg-[#02071b] text-white">

  <div class="px-10 py-5">
    <div class="flex items-center gap-3 mb-3">
      <a href="./home.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase font-semibold text-2xl hidden md:block">appointments</h1>
    </div>

    <div class="mx-3 mt-6 <?= $display ?>">
      <h2 class="uppercase mb-2 text-xl tracking-wide font-medium">your appointments</h2>
      <div class="flex flex-wrap gap-4">
        <?php
        $customer_appointments = $db->getCustomerAppointments($_SESSION["user_info"]["id"]);
        if (empty($customer_appointments)) {
        ?>
          <p class="text-lg mx-3 font-medium ">You haven't book any appointments</p>
          <?php
        } else {
          foreach ($customer_appointments as $appointment) {
            $bg_class = $appointment["status"] == "pending" ? "border-orange-600 bg-orange-600/20 hover:bg-orange-600/40" : "border-blue-600 bg-blue-600/20 hover:bg-blue-600/40"
          ?>
            <div class="border <?= $bg_class ?> transition-colors duration-300 w-full max-w-[300px] rounded-lg capitalize px-3 py-1">
              <p><?php echo $appointment["date"] . " " . substr($appointment["startsAt"], 0, 5) . "-" . substr($appointment["endsAt"], 0, 5) ?></p>
              <p class="capitalize">status: <?= $appointment["status"] ?></p>
            </div>
        <?php
          }
        }

        ?>
      </div>

    </div>

    <div class=" flex flex-wrap gap-5 mx-3 mt-6">
      <?php
      $doctors = $db->getAllDoctors();
      foreach ($doctors as $doctor) {
      ?>
        <div class="max-w-[450px] w-full border border-white rounded-lg py-4 px-5">
          <div class="flex items-center gap-6 mb-4">
            <div class="h-[60px] w-[60px] bg-white rounded-full overflow-hidden">
              <img src="<?= $doctor["image"] ?>" alt="" class="h-full object-cover">
            </div>

            <div>
              <p class="capitalize">Dr. <?= $doctor["username"] ?></p>
              <p class="capitalize">Doctor type: <?= $doctor["type"] ?></p>
            </div>
          </div>

          <div class="p-3 flex flex-wrap gap-2 border-t-[1px] border-t-white">
            <?php
            $doc_appointments = $db->getAppointmentsByDocId($doctor["id"]);
            if (empty($doc_appointments)) {
            ?>
              <p class="capitalize">there's no available appointment</p>
              <?php
            } else {
              foreach ($doc_appointments as $appointment) {
                if ($appointment["status"] == "available") {
              ?>
                  <a href="./appointmentDetails.php?id=<?= $appointment["appointment_id"] ?>" class="border bg-white/20 hover:bg-white/40 transition-colors duration-300 w-full max-w-[300px] cursor-pointer border-white rounded-lg capitalize px-3 py-1">
                    <p><?php echo $appointment["date"] . " " . substr($appointment["startsAt"], 0, 5) . "-" . substr($appointment["endsAt"], 0, 5) ?></p>
                    <p class="capitalize">status: <?= $appointment["status"] ?></p>
                  </a>
                <?php
                } else {
                  $bg_class = $appointment["status"] == "pending" ? "border-orange-600 bg-orange-600/20 hover:bg-orange-600/40" : "border-blue-600 bg-blue-600/20 hover:bg-blue-600/40"
                ?>
                  <div class="border <?= $bg_class ?> transition-colors duration-300 w-full max-w-[300px] rounded-lg capitalize px-3 py-1">
                    <p><?php echo $appointment["date"] . " " . substr($appointment["startsAt"], 0, 5) . "-" . substr($appointment["endsAt"], 0, 5) ?></p>
                    <p class="capitalize">status: <?= $appointment["status"] ?></p>
                  </div>

            <?php
                }
              }
            }
            ?>
          </div>
        </div>
      <?php
      }
      ?>
    </div>

  </div>


</body>

</html>