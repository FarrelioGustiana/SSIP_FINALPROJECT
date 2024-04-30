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

if (!isset($_SESSION["user_info"]) || empty($_SESSION["user_info"])) {
  header("Location: ./home.php");
  exit;
}

$user_info = $_SESSION["user_info"];
$image = $user_info["image"];
$id = $user_info["id"];
$username = $user_info["username"];
$phone = $user_info["phone"];
$email = $user_info["email"];
$is_err = true;
$err_msg = "";
$notif_class = "-right-[1000px]";
if (isset($_POST["update"])) {
  $is_err = true;


  $username = trim($_POST["username"]);
  $email = trim(strtolower($_POST["email"]));
  $phone = $_POST["phone"];

  if (empty($username)) {
    $err_msg = "Username cannot be empty";
  } elseif (empty($email)) {
    $err_msg = "Email cannot be empty";
  } elseif (empty($phone)) {
    $err_msg = "Phone number cannot be empty";
  } else {
    if (empty(basename($_FILES["image_file"]["name"]))) {
      $image = $image;
    } else {
      $image = "../../img/" . basename($_FILES["image_file"]["name"]);
    }
    $users = $db->getAllUsers();

    $users_array = [
      "username" => [],
      "email" => [],
      "phone" => [],
    ];

    foreach ($users as $user) {
      if ($user["id"] == $id) continue;
      array_push($users_array["email"], $user["email"]);
      array_push($users_array["username"], strtolower($user["username"]));
      array_push($users_array["phone"], $user["phone"]);
    }
    if (in_array(strtolower($username), $users_array["username"])) {
      $err_msg =  "Username already exist";
    } elseif (in_array($email, $users_array["email"])) {
      $err_msg =  "Email already exist";
    } elseif (in_array($phone, $users_array["phone"])) {
      $err_msg =  "Phone number already exist";
    } else {
      $is_err = false;
      $err_msg =  "Update succeed";

      move_uploaded_file($_FILES["image_file"]["tmp_name"], $image);

      $db->updateUserById($id, $username, $email, $phone, $image);

      $_SESSION["user_info"]["image"] = $image;
      $_SESSION["user_info"]["username"] = $username;
      $_SESSION["user_info"]["email"] = $email;
      $_SESSION["user_info"]["phone"] = $phone;
    }
  }
  $notif_class = $is_err ? "right-3 bg-[#af4242]" : "right-3 bg-green-600";
}

if (isset($_POST["sign_out"])) {
  session_unset();
  session_destroy();
  header("Location: ./home.php");
}

if (isset($_POST["delete_btn"])) {
  $db->deleteUserById($id);
  session_unset();
  session_destroy();
  header("Location: ./home.php");
}

?>

<body class="relative overflow-hidden bg-[#02081b] min-h-screen min-w-[97vw] text-white">

  <div class="px-10 py-5">
    <div class="flex items-center gap-3 mb-3">
      <a href="./home.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase text-2xl hidden md:block">edit profile</h1>
    </div>

    <div class="md:flex md:justify-center">
      <form autocomplete="off" method="post" class="shadow-[0_0px_10px_5px_rgba(255,255,255,0.15)] hover:shadow-[0_0px_12px_10px_rgba(255,255,255,0.25)] md:max-w-[550px] px-10 w-full flex flex-col items-center gap-y-3 py-[50px] rounded-xl transition-shadow duration-300" enctype="multipart/form-data">
        <div class="w-full flex justify-start md:justify-center" id="profile_area">
          <label class="w-[90px] h-[90px] rounded-full border overflow-hidden cursor-pointer bg-white">
            <input type="file" id="image_file" name="image_file" class="hidden" accept="image/*">
            <img src="
            <?php echo $image; ?>
          " alt="" class="w-full h-full object-cover object-center">
          </label>
        </div>

        <div class="flex flex-col gap-3 w-full">
          <label for="username" class="capitalize font-semibold text-xl">username:</label>
          <input name="username" type="text" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-2 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent w-[100%]" value="<?= $username ?>">
        </div>

        <div class="flex flex-col gap-3 w-full">
          <label for="email" class="capitalize font-semibold text-xl">email:</label>
          <input name="email" type="text" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-2 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent w-[100%]" value="<?= $email ?>">
        </div>

        <div class="flex flex-col gap-3 w-full">
          <label for="phone" class="capitalize font-semibold text-xl">phone number:</label>
          <input name="phone" type="number" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-2 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent w-[100%]" value="<?= $phone ?>">
        </div>
        <div class="flex w-full justify-between">

          <button name="update" class="bg-blue-600 font-semibold px-5 py-1 capitalize rounded-lg">update</button>
          <button name="sign_out" class="bg-blue-600 font-semibold px-5 py-1 capitalize rounded-lg">sign out</button>
        </div>
        <button name="delete_btn" class="bg-white w-full text-red-600 font-semibold px-3 py-1 capitalize rounded-lg">delete account</button>
      </form>
    </div>

  </div>
  <div class="z-[1001] fixed duration-500 delay-500 rounded overflow-hidden transition-all top-3 px-8 py-3 <?= $notif_class ?> flex justify-center items-center">
    <p class="text-[#fde8ec]"><?= $err_msg ?>!</p>
  </div>

  <script>
    const imageInput = document.getElementById('image_file');
    const imageArea = document.getElementById("profile_area");
    const imagePreview = imageArea.querySelector("img");

    imageInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      const reader = new FileReader();

      reader.onload = function(event) {
        imagePreview.src = event.target.result;
      };

      reader.readAsDataURL(file);
    });
  </script>
</body>

</html>