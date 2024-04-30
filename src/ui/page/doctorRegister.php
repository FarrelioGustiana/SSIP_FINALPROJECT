<?php
session_start();
include("../components/head.php");
include("../../database/generateId.php");
include("../../database/database.php");

try {
  //code...
  $db = new ConnectDB();
} catch (\Throwable $th) {
  //throw $th;
  header("Location: ./home.php");
}

$doc_types = $db->getAllCategories();

$is_error = false;
$username = $email = $phone = $password = $conPass = $err_msg = "";
$type = "";

if (isset($_POST["submit"])) {
  $type = $_POST["type"];
  $id = genId();
  $is_error = true;
  $username = trim($_POST["username"]);
  $email = strtolower($_POST["email"]);
  $phone = $_POST["phone"];
  $password = $_POST["password"];
  $conPass = $_POST["conPass"];


  if (empty($username)) {
    $err_msg = "Username cannot be empty";
  } elseif (empty($email)) {
    $err_msg = "Email cannot be empty";
  } elseif (empty($password)) {
    $err_msg = "Password cannot be empty";
  } elseif (empty($phone)) {
    $err_msg = "Phone number cannot be empty";
  } elseif (strlen($password) < 8) {
    $err_msg = "Password minimum 8 characters";
  } elseif ($conPass !== $password) {
    $err_msg = "Password doesn't match";
  } else {
    $users = $db->getAllUsers();

    if (!empty($users)) {
      $users_array = [
        "id" => [],
        "username" => [],
        "email" => [],
        "phone" => [],
        "userStatus" => [],
        "image" => [],
        "createdAt" => []
      ];

      foreach ($users as $user) {
        array_push($users_array["id"], $user["id"]);
        array_push($users_array["email"], $user["email"]);
        array_push($users_array["username"], strtolower($user["username"]));
        array_push($users_array["userStatus"], $user["userStatus"]);
        array_push($users_array["image"], $user["image"]);
        array_push($users_array["phone"], $user["phone"]);
        array_push($users_array["createdAt"], $user["createdAt"]);
      }

      while (in_array($id, $users_array["id"])) {
        $id = genId();
      }

      if (in_array(strtolower($username), $users_array["username"])) {
        $err_msg =  "Username already exist";
      } elseif (in_array($email, $users_array["email"])) {
        $err_msg =  "Email already exist";
      } elseif (in_array($phone, $users_array["phone"])) {
        $err_msg =  "Phone number already exist";
      } else {
        $is_error = false;
        $db->addUser($id, $username, $email, $phone, $password, "doctor");
        $db->addDoctor($id, $type);
        $user_info = [
          "id" => $id,
          "username" => $username,
          "email" => $email,
          "phone" => $phone,
          "userStatus" => "doctor",
          "image" => "../../img/defaultImage.png"
        ];
        $_SESSION["user_info"] = $user_info;
        $_SESSION["doctor_info"] = [
          "id" => $id,
          "type_id" => $type
        ];
        header("Location: ./home.php");
        exit;
      }
    } else {
      $is_error = false;
      $db->addUser($id, $username, $email, $phone, $password, "doctor");
      $db->addDoctor($id, $type);
      $user_info = [
        "id" => $id,
        "username" => $username,
        "email" => $email,
        "phone" => $phone,
        "userStatus" => "doctor",
        "image" => "../../img/defaultImage.png"
      ];
      $_SESSION["user_info"] = $user_info;
      $_SESSION["doctor_info"] = [
        "id" => $id,
        "type" => $type,
      ];
      header("Location: ./home.php");
      exit;
    }
  }
}
$notif_class = $is_error ? "right-3" : "-right-[1000px]";
?>

<!DOCTYPE html>
<html lang="en">

<?php include("../components/head.php"); ?>


<body class="bg-[#02081b] relative min-h-screen min-w-[97vw] flex justify-center items-center overflow-hidden text-white">
  <form autocomplete="off" action="./doctorRegister.php" method="post" class="relative z-10 bg-[#02081b] px-7 md:px-9 py-7 drop-shadow-[0_0_5px_rgba(255,255,255,0.15)] text-white flex flex-col gap-1 md:gap-2 w-full rounded-lg max-w-[390px] sm:max-w-[420px] md:max-w-[470px] transition-all duration-300 hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.25)]">
    <h1 class="uppercase text-xl tracking-wider font-bold">sign up as doctor</h1>

    <div class="px-2 flex flex-col">
      <label for="username" class="capitalize tracking-wider font-semibold">username:</label>
      <input autofocus id="username" name="username" type="text" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-1 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Enter your name" value="<?= $username ?>">
    </div>

    <div class="px-2 flex flex-col">
      <label for="email" class="capitalize tracking-wider font-semibold">email:</label>
      <input id="email" name="email" type="email" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-1 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Enter your email address" value="<?= $email ?>">
    </div>

    <div class="px-2 flex flex-col">
      <label for="phone" class="capitalize tracking-wider font-semibold">phone number:</label>
      <input id="phone" name="phone" type="number" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-1 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Phone number" value="<?= $phone ?>">
    </div>

    <div class="flex justify-center items-center w-full">
      <div class="w-full px-2 flex flex-col">
        <label for="type" class="capitalize tracking-wider font-semibold">doctor type:</label>
        <select name="type" class="border-white border-2 bg-[#02081b] capitalize w-full px-3 py-2 focus:outline-none outline-white rounded-lg mt-1">
          <?php
          foreach ($doc_types as $type) {
          ?>
            <option value="<?= $type["id"] ?>" class="px-1">
              <?= $type["name"] ?>
            </option>
          <?php
          }
          ?>
        </select>
      </div>
    </div>

    <div class="px-2 flex flex-col">
      <label for="password" class="capitalize tracking-wider font-semibold">password:</label>
      <input id="password" name="password" type="password" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-1 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Enter your password" value="<?= $password ?>">
    </div>

    <div class="px-2 flex flex-col">
      <label for="conPass" class="capitalize tracking-wider font-semibold">re-enter password:</label>
      <input id="rePpassword" name="conPass" type="password" class="transition-all duration-500 border-2 py-2 border-white bg-[#02081b] px-5 focus:outline-none mt-1 rounded-xl focus:border-t-none focus:border-x-transparent focus:rounded-none focus:border-t-transparent" placeholder="Re-Enter your password" value="<?= $conPass ?>">
    </div>
    <button type="submit" name="submit" class="mx-2 mt-2 bg-blue-600 py-1.5 px-5 rounded-lg">Sign Up</button>
    <p class="capitalize mx-5">Already have an account? <a class="underline hover:text-purple-600" href="./login.php">sign in here</a></p>
  </form>


  <div id="notif-display" class="transition-all h-[1050px] w-[1050px] md:h-[1250px] md:w-[1250px] rounded-full fixed bg-[#02081b] drop-shadow-[0_-9px_5px_rgb(40,36,167,0.15)] top-[60px]"></div>

  <div class="z-[1001] fixed duration-500 delay-500 rounded overflow-hidden transition-all top-3 px-8 py-3 bg-[#af4242] <?= $notif_class ?> flex justify-center items-center">
    <p class="text-[#fde8ec]"><?php echo $err_msg ?>!</p>
  </div>


</body>

</html>