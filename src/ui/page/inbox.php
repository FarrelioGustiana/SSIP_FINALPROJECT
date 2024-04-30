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
?>

<body class="relative min-h-screen min-w-[97vw] bg-[#02071b] text-white">
  <div class="px-10 py-5">
    <div class="flex items-center gap-3 mb-3">
      <a href="./home.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase font-semibold text-2xl hidden md:block">Inbox</h1>
    </div>
  </div>
  <main class="mt-3 w-full">
    <?php
    $customer_comments = $db->getCommentsByUserId($_SESSION["user_info"]["id"]);

    if (empty($customer_comments)) {
    ?>
      <h1 class="mx-16 capitalize font-semibold text-lg md:text-xl">You don't have anything in your inbox.</h1>
      <?php
    } else {
      foreach ($customer_comments as $comment) {
      ?>
        <div class="w-full px-10 py-3 flex flex-col bg-[#02071b] hover:bg-[#18224a] transition-all duration-300 gap-2">
          <div class="flex justify-between">
            <p><?= $comment["comment_title"] ?></p>
            <p><?= $comment["createdAt"] ?></p>
          </div>
          <p><?= $comment["comment_body"] ?></p>
        </div>
    <?php
      }
    }

    ?>
  </main>
</body>

</html>