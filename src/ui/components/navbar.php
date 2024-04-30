<?php

$user_info = isset($_SESSION["user_info"]) ? $_SESSION["user_info"] : null;
$button_display = isset($_SESSION["user_info"]) ?  "hidden" : "flex";
$profile_display = isset($_SESSION["user_info"]) ? "flex" : "hidden";
$doc_nav_display =
  isset($_SESSION["user_info"]) && ($user_info["userStatus"] == "doctor") ? "flex" : "hidden";
$not_doctor_display = isset($_SESSION["user_info"]) && ($user_info["userStatus"] == "doctor") ? "hidden" : "flex";
$inbox_display = !$user_info ? "hidden" : "block";
?>

<div class="fixed top-4 inset-x-0 z-[999] w-full px-10">
  <nav class="bg-white/5 z-[998] backdrop-blur-md  rounded-xl border border-[#FFFFFF]/[0.16] px-5 py-3">
    <!-- For Small screen -->
    <div class="relative flex justify-between items-center xl:hidden">
      <div class="<?= $profile_display ?> items-center cursor-pointer">
        <p class="text-white font-semibold text-xl">Hello, <?= $user_info["username"] ?></p>
      </div>
      <a href="../page/home.php" class="mx-2 font-bold uppercase text-white text-lg sm:text-xl font-logo <?= $button_display ?>">Bayside Medical Center</a>

      <div id="menu-icon">
        <div class="flex flex-col justify-center cursor-pointer">
          <div class="h-1 w-6 bg-white rounded-full"></div>
          <div class="h-1 w-6 bg-white rounded-full my-1"></div>
          <div class="h-1 w-6 bg-white rounded-full"></div>
        </div>
      </div>
    </div>

    <!-- For Big Screen -->
    <div class="relative hidden justify-between items-center w-full xl:flex">

      <div class="flex justify-between items-center w-[50%]">
        <ul class="list-none flex items-center gap-6">
          <li class="transition-all duration-300 text-[#a7a7a7] hover:text-white cursor-pointer font-semibold text-[16px]"><a href="../page/home.php">Home</a></li>
          <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-lg <?= $profile_display ?>">
            <a href="../page/editProfile.php">Profile</a>
          </li>
          <li class="transition-all duration-300 text-[#a7a7a7] hover:text-white cursor-pointer font-semibold text-[16px] flex"><a href="../page/ask.php">Ask Doctor</a></li>
          <li class="transition-all duration-300 text-[#a7a7a7] hover:text-white cursor-pointer font-semibold text-[16px] <?= $not_doctor_display ?>"><a href="../page/appointment.php">Make Your Appointment</a></li>
          <li class="transition-all duration-300 text-[#a7a7a7] hover:text-white cursor-pointer font-semibold text-[16px] <?= $doc_nav_display ?>"><a href="../page/appointmentForm.php">Appointment</a></li>
          <li class="transition-all duration-300 text-[#a7a7a7] hover:text-white cursor-pointer font-semibold text-[16px] <?= $inbox_display ?>"><a href="../page/inbox.php">Inbox</a></li>
        </ul>

        <a href="../page/home.php" class="font-bold text-white text-lg sm:text-2xl ml-3 font-logo tracking-widest">BMC</a>
      </div>


      <div class="<?= $button_display ?> items-center flex-row-reverse gap-x-5">
        <a href="../page/login.php" class="bg-blue-600 hover:bg-blue-800 transition-transform duration-300 text-white capitalize px-[35px] font-semibold py-1 rounded-3xl">login</a>
        <a href="../../ui/page/signUp.php" class="transition-all duration-300 text-[#939393] hover:text-white capitalize px-3 font-semibold py-1">sign up</a>
      </div>

      <div class="<?= $profile_display ?> flex gap-x-3 relative items-center cursor-pointer">
        <p class="text-white font-semibold text-xl">
          Hello, <?= $user_info["username"] ?>
        </p>
      </div>
    </div>
  </nav>
</div>

<!-- Menu links for small screen -->
<div id="menu-links-small" class="fixed bg-black h-screen w-full z-[1000] delay-50 duration-1000 transition-all text-white xl:hidden flex flex-col gap-y-8 px-8 py-12 -mt-[10000px]">
  <div class="flex items-center justify-between">
    <a href="../page/home.php" class="uppercase font-bold text-white text-lg sm:text-xl font-logo <?= $profile_display ?>">Bayside Medical Center</a>
    <div class="<?= $button_display ?> items-center gap-x-5">
      <a href="../page/login.php" class="bg-blue-600 hover:bg-blue-800 transition-transform duration-300 text-white capitalize px-[35px] font-semibold py-1 rounded-3xl">login</a>
      <a href="../../ui/page/signUp.php" class="transition-all duration-300 text-[#939393] hover:text-white capitalize px-3 font-semibold py-1">sign up</a>
    </div>
    <div class="transition-transform delay-75 duration-500 relative cursor-pointer mr-10" id="close-menu-links">
      <div>
        <div class="absolute h-1 w-6 bg-white transform rotate-45"></div>
        <div class="absolute h-1 w-6 bg-white transform -rotate-45"></div>
      </div>
    </div>
  </div>

  <ul class="list-none flex flex-col items-center gap-12 mt-10">
    <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-xl"><a href="../page/home.php">Home</a></li>
    <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-xl <?= $profile_display ?>">
      <a href="../page/editProfile.php">Profile</a>
    </li>
    <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-xl flex"><a href="../page/ask.php">Ask Doctor</a></li>
    <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-xl <?= $not_doctor_display ?>"><a href="../page/appointment.php">Make Your Appointment</a></li>
    <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-xl <?= $doc_nav_display ?>"><a href="../page/appointmentForm.php">Appointment</a></li>
    <li class="transition-all duration-300 text-[#939393] hover:text-white cursor-pointer font-semibold text-xl <?= $inbox_display ?>"><a href="../page/inbox.php">Inbox</a></li>
  </ul>

</div>

<script>
  const sec_body = document.getElementById("sec-body");
  const body = document.querySelector("body");
  const menu_icon = document.getElementById('menu-icon');
  const menu_links_small = document.getElementById("menu-links-small")
  const menu_close = document.getElementById("close-menu-links")

  menu_icon.addEventListener('click', () => {
    menu_links_small.classList.remove("-mt-[10000px]");
    sec_body.classList.add("overflow-y-hidden");
    body.classList.add("overflow-y-hidden");
  })

  menu_close.addEventListener("click", () => {
    menu_links_small.classList.add("-mt-[10000px]");
    sec_body.classList.remove("overflow-y-hidden");
    body.classList.remove("overflow-y-hidden");
  })

  window.addEventListener("resize", () => {
    menu_links_small.classList.add("-mt-[10000px]");
    sec_body.classList.remove("overflow-y-hidden");
    body.classList.remove("overflow-y-hidden");
  })
</script>