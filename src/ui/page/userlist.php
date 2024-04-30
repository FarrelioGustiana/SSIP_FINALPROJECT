<!DOCTYPE html>
<html lang="en">

<?php

session_start();

include("../../database/database.php");
include("../components/head.php");

try {
  //code...
  $db = new ConnectDB();
} catch (\Throwable $th) {
  //throw $th;
  header("Location: ./home.php");
}

$data = $db->getAllUsers();

if (isset($_POST["delete"])) {
  $db->deleteUserById($_POST["delete"]);
  header("Location: ./home.php");
  exit;
}

if (isset($_POST["admin"])) {
  $db->makeAdmin($_POST["admin"]);
  header("Location: ./home.php");
  exit;
}

?>

<body class="relative min-w-[97vw] bg-[#020F22]">
  <?php include("../components/navbar.php") ?>


  <div class="text-white py-[80px] px-12 w-full">
    <h1 class="text-2xl font-bold capitalize tracking-wide">user list</h1>
    <div class="flex flex-col gap-y-6 p-3 w-full">
      <?php

      for ($i = 0; $i < count($data); $i++) {
        $customer_display = $data[$i]["userStatus"] == "customer" ? "block" : "hidden";
        $self_display = $data[$i]["id"] == $_SESSION["user_info"]["id"] ? "hidden" : "block";
      ?>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="w-full border-white border-2 p-4 rounded-2xl relative">

          <div class="flex items-center gap-2">
            <p class="capitalize font-semibold">id:</p>
            <p class="font-medium"><?= $data[$i]["id"] ?></p>
          </div>

          <div class="flex items-center gap-2">
            <p class="capitalize font-semibold">email:</p>
            <p class="font-medium"><?= $data[$i]["email"] ?></p>
          </div>

          <div class="flex items-center gap-2">
            <p class="capitalize font-semibold">username:</p>
            <p class="font-medium"><?= $data[$i]["username"] ?></p>
          </div>

          <div class="flex items-center gap-2">
            <p class="capitalize font-semibold">phone number:</p>
            <p class="font-medium"><?= $data[$i]["phone"] ?></p>
          </div>

          <div class="flex items-center gap-2">
            <p class="capitalize font-semibold">status:</p>
            <p class="font-medium capitalize"><?= $data[$i]["userStatus"] ?></p>
          </div>

          <?php
          if ($data[$i]["userStatus"] == "doctor") {
          ?>
            <div class="flex items-center gap-2">
              <p class="capitalize font-semibold">Type:</p>
              <p class="font-medium capitalize"><?= $data[$i]["userStatus"] ?></p>
            </div>
          <?php
          }
          ?>


          <div class="flex items-center gap-2">
            <p class="capitalize font-semibold">create date:</p>
            <p class="font-medium capitalize"><?= $data[$i]["createdAt"] ?></p>
          </div>

          <div class="flex items-center gap-3 mt-3">
            <button class="<?= $customer_display ?> bg-blue-600 px-3 py-0.5 capitalize font-medium rounded" name="admin" value="<?= $data[$i]["id"] ?>">admin</button>

            <button class="<?= $self_display ?> bg-white px-3 py-0.5 capitalize font-medium rounded text-red-600" name="delete" value="<?= $data[$i]["id"] ?>">delete</button>
          </div>



        </form>

      <?php
      }
      ?>
    </div>

  </div>




</body>

</html>