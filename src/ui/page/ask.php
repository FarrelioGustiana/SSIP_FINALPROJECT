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
try {
  $doctors = $db->getAllDoctors();
} catch (\Throwable $th) {
  header("Location: ./home.php");
}

?>

<body class="relative min-h-screen min-w-[97vw] bg-[#02071b]">

  <?php include("../components/navbar.php"); ?>

  <main class="top-[70px] relative px-12 py-5 text-white w-full transition-all duration-300">
    <h2 class="mx-3 text-xl font-bold tracking-wider">Ask Doctors</h2>

    <div class="gap-10 w-full flex flex-wrap p-5">
      <?php
      foreach ($doctors as $doctor) {
      ?>
        <a href="./askPage.php?id=<?= $doctor["id"] ?>" style="background-size: 100% 100%;
        background-position: 0px 0px;
        background-image: radial-gradient(57% 79% at 95% 5%, #0A345BFF 1%, #04102AFF 71%);" class="transition-all duration-300 drop-shadow-[0_0_5px_rgba(255,255,255,0.15)] hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.25)] border-[1px] border-white/50 w-full max-w-[350px] rounded-lg h-[150px] flex items-center gap-4 p-4">
          <div class="h-[100px] w-[100px] flex items-center">
            <div class="w-full h-full bg-white rounded-full overflow-hidden">
              <img src="<?= $doctor["image"] ?>" alt="" class="w-full h-full object-cover">
            </div>
          </div>
          <div>
            <p class="capitalize">Name: Dr. <?= $doctor["username"] ?></p>
            <p class="capitalize">doctor type: <?= $doctor["type"] ?> </p>
          </div>
        </a>
      <?php
      }
      ?>
    </div>
  </main>

</body>

</html>