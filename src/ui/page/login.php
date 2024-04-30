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

$is_error = false;
$email = $password = $err_msg =  "";

if (isset($_POST["submit"])) {
  $email = strtolower(trim($_POST["email"]));
  $password = $_POST["password"];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $is_error = true;
    $err_msg = "Invalid email format";
  } elseif (empty($email)) {
    $is_error = true;
    $err_msg = "Email is needed";
  } elseif (empty($password)) {
    $is_error = true;
    $err_msg = "Password is needed";
  } else {

    $user = $db->loginUser($email);

    if (empty($user)) {
      $is_error = true;
      $err_msg = "Cannot find the email!";
    } else {
      $is_valid = password_verify($password, $user["password"]);

      if (!$is_valid) {
        $is_error = true;
        $err_msg = "Wrong password";
      } else {
        $user_info = [
          "id" => $user["id"],
          "username" => $user["username"],
          "email" => $email,
          "phone" => $user["phone"],
          "userStatus" => $user["userStatus"],
          "image" => $user["image"]
        ];

        if ($user["userStatus"] == "doctor") {
          $doctor = $db->getDoctorById($user["id"])[0];
          $_SESSION["doctor_info"] = [
            "id" => $user["id"],
            "type" => $doctor["type"],
          ];
        }

        $_SESSION["user_info"] = $user_info;
        header("Location: ./home.php");
        exit;
      }
    }
  }
}

$err_display = !$is_error ? "hidden" : "flex";

?>


<body class="bg-[#02081b] relative min-h-screen min-w-[97vw] flex justify-center items-center overflow-hidden">
  <form autocomplete="off" method="post" class="relative z-10 bg-[#02081b] px-8 md:px-12 py-12 md:py-16 drop-shadow-[0_0_3px_rgba(255,255,255,0.15)] text-white flex flex-col gap-2 md:gap-5 w-full rounded-lg max-w-[350px] sm:max-w-[400px] md:max-w-[450px] transition-all duration-300 hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.25)]">
    <h1 class="uppercase text-xl tracking-wider font-bold">Login</h1>

    <div class="px-2 flex flex-col">
      <label for="email" class="capitalize tracking-wider font-semibold">email:</label>
      <input id="email" name="email" type="text" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-2 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Enter your email address" value="<?= $email ?>">
    </div>

    <div class="px-2 flex flex-col">
      <label for="password" class="capitalize tracking-wider font-semibold">password:</label>
      <input id="password" name="password" type="password" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-2 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Enter your password" value="<?= $password ?>">
    </div>

    <button type="submit" name="submit" class="mx-2 mt-2 bg-blue-600 py-1.5 px-5 rounded-lg">Login</button>

    <p class="capitalize mx-auto">Don't have an account? <a class="underline hover:text-purple-600" href="./signUp.php">sign up here</a></p>
  </form>

  <div class="transition-all h-[1050px] w-[1050px] md:h-[1250px] md:w-[1250px] rounded-full absolute bg-[#02081b] drop-shadow-[0_-9px_5px_rgb(40,36,167,0.15)] top-[60px]"></div>

  <?php include("../components/error_display.php"); ?>

</body>

</html>