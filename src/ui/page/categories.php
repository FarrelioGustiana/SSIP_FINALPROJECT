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
$category = "";
$categories_data = $db->getAllCategories();

if (isset($_POST["add"])) {
  $is_error = true;
  $id = genCategoryId();
  $category = $_POST["category"];

  if (empty($category)) {
    $err_msg = "Category is needed";
  } else {
    if (empty($categories_data)) {
      $db->addCategories($id, $category);
      header("Location: ./home.php");
    } else {
      foreach ($categories_data as $c) {
        if ($c["id"] == $id) $id = genCategoryId();
      }
      $db->addCategories($id, $category);
      header("Location: ./categories.php");
    }
  }
}

if (isset($_POST["delete"])) {
  $db->deleteCategoriesById($_POST["delete"]);
  header("Location: ./categories.php");
}

$err_display = !$is_error ? "hidden" : "flex";
?>

<body class="relative bg-[#02081b] min-h-screen min-w-[97vw] text-white">

  <div class="px-10 py-5">
    <div class="flex items-center gap-3 mb-3">
      <a href="./home.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase font-semibold text-2xl hidden md:block">appointments</h1>
    </div>

    <form style="background-size: 100% 100%;
        background-position: 0px 0px;
        background-image: radial-gradient(57% 79% at 95% 5%, #0A345BFF 1%, #04102AFF 71%);" autocomplete="off" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="max-w-[400px] flex flex-col gap-y-5 rounded-2xl mx-10 mt-10 transition-all duration-300 drop-shadow-[0_0_5px_rgba(255,255,255,0.15)] hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.25)] py-4 items-center px-[50px]">
      <div class="flex flex-col items-start gap-1 w-full">
        <label for="categories" class="uppercase font-medium tracking-wide">categories:</label>
        <input type="text" name="category" class="border border-white px-4 py-1 rounded-xl bg-[#04102AFF] w-full" value="<?= $category ?>">
      </div>
      <div class="w-full">
        <button type="submit" name="add" class="capitalize bg-blue-600 rounded px-4">add</button>
      </div>

    </form>

    <div>
      <div class="p-6 border-b border-white w-full">
        <h2 class="text-xl md:text-2xl font-bold tracking-wider uppercase mt-12">catogory list</h2>
      </div>

      <div class="flex flex-wrap gap-4 px-3 py-2">
        <?php
        foreach ($categories_data as $c) {
        ?>
          <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="px-3 rounded-xl bg-blue-600/30 border border-blue-600 font-semibold capitalize flex gap-5 py-2 items-center">
            <p><?= $c["name"] ?></p>
            <button class="px-2 rounded-lg font-normal cursor-pointer bg-red-600 text-[13px] py-0.5 hover:bg-red-500 transition-all duration-300" type="submit" value="<?= $c["id"] ?>" name="delete">X</button>
          </form>
        <?php
        }
        ?>
      </div>
    </div>
    <?php include("../components/error_display.php"); ?>
</body>

</html>