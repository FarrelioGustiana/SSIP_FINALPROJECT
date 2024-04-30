<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (isset($_GET["id"])) {
  $doctor_id = $_GET["id"];
} else {
  header("Location: ./ask.php");
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

$form_display = isset($_SESSION["user_info"]) && $_SESSION["user_info"]["userStatus"] == "doctor" ? "hidden" : "block";
$doctor = $db->getDoctorById($doctor_id)[0];
$question = $reply = $err_msg = "";
$is_error = false;
$questions = $db->getAllQuestion($doctor_id);
$ask_display = empty($questions) ? "hidden" : "block";

if (isset($_POST["ask"])) {
  $is_error = true;
  $question = $_POST["question"];
  $ask_id = genIdExcpetuser();

  if (!isset($_SESSION["user_info"])) {
    $err_msg = "You need to <a class='underline hover:text-purple-700' href='./login.php'>login</a> first!";
  } elseif (empty($question) || strlen($question) < 10) {
    $err_msg = "Fill the question input correctly!";
  } elseif (empty($questions)) {
    $is_error = false;
    $db->addQuestion($ask_id, $_SESSION["user_info"]["id"], $doctor_id, $question);
    $question = "";
    header("Location: ./askPage.php?id={$doctor_id}");
  } else {
    foreach ($questions as $q) {
      if ($q["ask_id"] == $ask_id) $id = genIdExcpetuser();
    }
    $is_error = false;
    $db->addQuestion($ask_id, $_SESSION["user_info"]["id"], $doctor_id, $question);
    $question = "";
    $_POST["question"] = "";
    header("Location: ./askPage.php?id={$doctor_id}");
    exit;
  }
}
$questions = $db->getAllQuestion($doctor_id);
$ask_display = empty($questions) ? "hidden" : "block";

if (isset($_POST["reply"])) {
  $is_error = true;
  $reply = $_POST["answer"];
  $id_for_ask = $_POST["reply"];

  if (empty($reply) || strlen($reply) < 15) {
    $err_msg = "Fill the answer input correctly";
  } else {
    $db->addAnswer($id_for_ask, $reply);
    header("Location: ./askPage.php?id={$doctor_id}");
    exit;
  }
}

$err_display = !$is_error ? "hidden" : "flex";

?>

</head>

<body class="bg-[#02081b] relative min-h-screen min-w-[97vw]">

  <?php include("../components/error_display.php"); ?>

  <div class="px-10 py-2 text-white">
    <div class="flex items-center gap-3 mb-3">
      <a href="./ask.php" class=" flex p-2 rounded-full  justify-center  items-center text-center hover:bg-white/40 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
        </svg>
      </a>
      <h1 class="uppercase text-2xl hidden md:block">Dr. <?= $doctor["username"] ?></h1>
    </div>

    <main class="px-10 py-3 w-full bg-[#02081b] flex flex-col gap-4">
      <div class="max-w-[450px] mx-auto w-full h-[100px] border border-white rounded-xl py-2 px-5 flex items-center gap-x-5">
        <div class="h-[80px] w-[80px] rounded-full overflow-hidden">
          <img src="<?= $doctor["image"] ?>" alt="" class="h-full object-cover">
        </div>

        <div>
          <p class="capitalize">Dr. <?= $doctor["username"] ?></p>
          <p class="capitalize">Doctor type: <?= $doctor["type"] ?></p>
        </div>
      </div>

      <form id="askForm" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="w-full <?= $form_display ?>">
        <textarea name="question" class="w-full rounded-md bg-[#02081b] text-white border-white border-[1px] h-[100px] p-2" placeholder="ask your question here"><?= $question ?></textarea>
        <button name="ask" type="submit" class="bg-blue-600 font-semibold mt-2 px-5 py-0.5 rounded">Ask</button>
      </form>

    </main>


    <div class="text-white 
      <?= $ask_display ?> w-full p-3">
      <?php
      foreach ($questions as $q) {
        $reply_display = isset($_SESSION["user_info"]) && $_SESSION["user_info"]["userStatus"] == "doctor" && $_SESSION["user_info"]["id"] == $doctor_id && empty($q["answer"]) ? "block" : "hidden";
        $customer = $db->getUserById($q["customer_id"])[0];
        $answer_display = !$q["answer"] ? "hidden" : "flex";
      ?>
        <div class="border-b border-b-white py-1 px-3 flex flex-col">
          <div class="flex items-center gap-x-3 mt-4">
            <div class="w-[30px] h-[30px] rounded-full overflow-hidden bg-white">
              <img src="<?= $customer["image"] ?>" alt="" class="w-[30px] h-[30px] rounded-full object-cover">
            </div>

            <p><?= $customer["username"] ?></p>
          </div>

          <p class="mt-4">
            <?= $q["ask_text"] ?>
          </p>

          <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="w-full my-3 flex items-end gap-x-4 <?= $reply_display ?>">
            <textarea name="answer" class="w-full rounded-md bg-[#02081b] text-white border-white border-[1px] md:h-[80px] sm:h-[100px] h-[120px] p-2" placeholder="Reply Here"><?= $reply ?></textarea>
            <button type="submit" name="reply" class="bg-blue-600 font-semibold py-0.5 px-3 rounded" value="<?= $q["ask_id"] ?>">Reply</button>
          </form>

          <div class="<?= $answer_display ?> mx-8 my-3 flex-col gap-y-5">
            <div class="flex items-center gap-x-3">
              <div class="w-[30px] h-[30px] rounded-full overflow-hidden bg-white">
                <img src="<?= $doctor["image"] ?>" alt="" class="w-[30px] h-[30px] rounded-full object-cover">
              </div>

              <p>Dr. <?= $doctor["username"] ?></p>
            </div>
            <p><?= $q["answer"] ?></p>
          </div>
        </div>

      <?php
      }
      ?>
    </div>

</body>

</html>