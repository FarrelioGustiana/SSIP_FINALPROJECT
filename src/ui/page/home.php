<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include("../components/head.php");
$user_info = isset($_SESSION["user_info"]) ? $_SESSION["user_info"] : null;
$admin_features_display = isset($_SESSION["user_info"]) && ($user_info["userStatus"] == "admin") ? "flex" : "hidden";
$categories_display = isset($_SESSION["user_info"]) && ($user_info["userStatus"] == "admin") ? "inline" : "hidden";
$is_sign_in_class = isset($_SESSION["user_info"]) ? "hidden" : "flex";
?>

<body class="relative bg-[#02081b] min-h-screen min-w-[97vw] text-white">
  <div class="relative w-full overflow-x-hidden">
    <img src="../assets/img1.jpg" class="w-full absolute h-[800px] object-cover">
    <div class="bg-[#020F22] w-full absolute h-[800px] opacity-70"></div>

    <?php include("../components/navBar.php") ?>

    <div class="transition-all duration-300 relative z-[100] h-[800px] w-full px-8 py-10 overflow-hidden">
      <p class="translate-y-[100%] lg:translate-y-[80%] translate-x-[5%] sm:translate-x-[10%] capitalize text-white font-logo tracking text-[50px] xl:text-[60px] font-bold whitespace-pre-line">“The first wealth
        is health.”
        <span class="text-[20px] xl:text-[30px] font-semibold tracking-wide">– Ralph Waldo Emerson</span>
      </p>
    </div>

    <main class="w-full overflow-x-hidden text-white mt-6 px-6 md:px-12 py-6">
      <!-- Sub Title -->
      <div id="sec-body" class="flex justify-center">
        <h3 class="uppercase text-2xl lg:text-[35px] font-bold">our services</h3>
      </div>

      <!-- Cards Container -->
      <div class="w-full flex flex-col gap-y-8 my-6 md:my-12">

        <!-- Card -->
        <div class="w-full flex gap-x-6 md:gap-x-12">
          <!-- image -->
          <div class="relative w-1/2 overflow-hidden rounded-md h-[200px] sm:h-[250px] md:h-[300px] lg:h-[450px]">
            <img src="../assets//img2.jpg" class="absolute transition-all w-full h-full top-0 right-0 object-cover">
            <div class="bg-[#020F22] w-full absolute h-full opacity-50"></div>
          </div>
          <!-- desc -->
          <div class="w-1/2 flex flex-col items-center justify-center">
            <div class="space-y-4">
              <h2 class="uppercase text-xl md:text-3xl text-white font-semibold sm:font-bold">ask the doctor</h2>
              <p class="text-justify text-[14px] md:text-lg">We provide you a platform that can ask many kinds of question from experienced doctor in our company.</p>
            </div>
          </div>
        </div>

        <!-- Card -->
        <div class="w-full flex flex-row-reverse gap-x-6 md:gap-x-12">
          <!-- image -->
          <div class="relative w-1/2 overflow-hidden rounded-md h-[200px] sm:h-[250px] md:h-[300px] lg:h-[450px]">
            <img src="../assets/img3.jpg" class="absolute transition-all w-full h-full top-0 right-0 object-cover">
            <div class="bg-[#020F22] w-full absolute h-full opacity-50"></div>
          </div>
          <!-- desc -->
          <div class="w-1/2 flex flex-col items-center justify-center">
            <div class="space-y-4">
              <h2 class="uppercase text-xl md:text-3xl text-white font-semibold sm:font-bold">Make appointment</h2>
              <p class="text-justify text-[14px] md:text-lg">Make your appointment with The Experienced Doctor from our company.</p>
            </div>
          </div>
        </div>

      </div>

      <div class="<?= $is_sign_in_class ?> flex-col items-center gap-y-6 md:gap-y-10 ">
        <h3 class="uppercase tracking-wide text-[20px] font-bold sm:text-[26px] md:text-[34px]">get started with bmc app now!</h3>
        <div class="space-x-3 sm:space-x-10">
          <a href="./signUp.php" class="transition-transform duration-300 bg-[#d9d9d9]/10 hover:bg-[#d9d9d9]/40 text-white text-lg md:text-2xl uppercase px-5 sm:px-[45px] font-semibold sm:py-3 py-2 rounded-lg">sign up now</a>
          </a>
          <a href="#" class="bg-blue-600 hover:bg-blue-800 transition-transform duration-300 text-white text-lg md:text-2xl uppercase px-5 sm:px-[45px] font-semibold sm:py-3 py-2 rounded-lg shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)]">get the app</a>
        </div>
      </div>

    </main>

    <footer class="relative mt-10 w-full border-t border-t-white/20 flex flex-col gap-y-5 text-white px-7 py-2 md:px-[40px] pt-10">

      <h1 class="uppercase text-2xl md:text-3xl font-bold font-logo">bayside medical Center</h1>
      <div class="lg:px-5 flex flex-row justify-between items-start w-full">
        <div class="space-y-4 w-full">
          <div class="lg:px-5 space-y-4">
            <h2 class="capitalize text-lg lg:text-xl font-semibold tracking-wider">customer complain service</h2>
            <h4 class="capitalize lg:text-lg text-[#B7B7B7]">PT Mencari Cinta Sejati</h4>
            <p class="text-[#B7B7B7] lg:text-lg">021839236923</p>
            <p class="capitalize lg:text-xl text-[#B7B7B7] whitespace-pre-line">Bishop School, East Ave, Kalyani Nagar,
              Pune, Maharashtra 411006, India</p>
          </div>
          <div class="lg:px-5 space-y-4 w-full">
            <div class="space-y-2 <?= $is_sign_in_class ?> flex-col">
              <h2 class="uppercase sm:text-xl font-semibold">get the app</h2>
              <div class="flex items-center gap-2">
                <img src="../assets/img5.webp" alt="" class="w-[110px] lg:w-[140px]">
                <img src="../assets/img6.webp" alt="" class="w-[110px] lg:w-[140px]">
              </div>
            </div>
            <div class="<?= $is_sign_in_class ?> flex-col gap-3 justify-center items-start">
              <h2 class="capitalize text-lg font-medium md:text-xl">are you a doctor?</h2>
              <a href="./doctorRegister.php" class="bg-blue-600 hover:bg-blue-800 transition-transform duration-300 text-white text-[13px] md:text-lg uppercase px-4 font-semibold py-1 rounded-lg shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)]">register</a>
            </div>
          </div>
          <a href="./categories.php" class="bg-blue-600 px-3 py-1 font-medium capitalize lg:mx-5 rounded-lg <?= $categories_display ?>">make categories</a>
        </div>

        <ul class="list-none flex flex-col gap-4 lg:gap-10 items-end w-full">
          <li class="text-[#d9d9d9] font-semibold text-lg capitalize hover:text-white cursor-pointer">FAQ</li>
          <li class="text-[#d9d9d9] font-semibold text-lg capitalize hover:text-white cursor-pointer">privacy policy</li>
          <li class="text-[#d9d9d9] font-semibold text-lg capitalize hover:text-white cursor-pointer">company</li>
          <li class="text-[#d9d9d9] font-semibold text-lg capitalize hover:text-white cursor-pointer">blog</li>
          <li class="text-[#d9d9d9] font-semibold text-lg capitalize hover:text-white cursor-pointer">terms & condition</li>
        </ul>

      </div>


      <div class="w-full px-4 md:px-[40px] flex justify-center">
        <div class="border-t border-t-white/20 w-[90%] pt-1 flex justify-center">
          <h2 class="text-center text-[12px] sm:text-[15px] tracking-wide text-[#d9d9d9]">©Bayside Medical Center, 2024. ALL RIGHTS RESERVED</h2>
        </div>
      </div>

    </footer>
    <div id="user_list_text" class="z-[10001] fixed right-20 bottom-[125px] transition-opacity duration-300 bg-gray-200 text-[#020F22] font-semibold py-0.5 px-5 rounded opacity-0">Users list</div>
    <a href="./userlist.php" id="admin_menu" class="<?= $admin_features_display ?> fixed bg-blue-100 w-[80px] h-[80px] bottom-10 right-10 z-[1000] items-center justify-center rounded-full cursor-pointer">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#020F22" class="bi bi-person-check" viewBox="0 0 16 16">
        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
        <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
      </svg>
    </a>
  </div>


  <script>
    const admin_menu_icon = document.getElementById("admin_menu");
    const user_list_text = document.getElementById("user_list_text");


    admin_menu_icon.addEventListener("mouseenter", () => {
      user_list_text.classList.add("opacity-80");
    })

    admin_menu_icon.addEventListener("mouseleave", () => {
      user_list_text.classList.remove("opacity-80");
    })
  </script>
</body>

</html>