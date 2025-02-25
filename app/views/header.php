<!DOCTYPE html>
<html lang="hr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo APP_NAME ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="<?php echo BASE_PATH ?>/public/assets/img/logo_spcp.png" type="image/png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
  <style>
    body {
      padding-top: 4rem;
      /* Kompenzacija za fiksirani header */
    }

    .sticky-nav {
      position: fixed;
      top: 0;
      z-index: 1000;
      width: 100%;
    }

    .dark {
      --tw-bg-opacity: 1;
      background-color: rgba(36, 37, 38, var(--tw-bg-opacity));
      color: white;
    }
  </style>
</head>

<body>

  <header class="bg-white sticky-nav">
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?php echo BASE_PATH ?>/home" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="<?php echo BASE_PATH ?>/public/assets/img/logo_spcp.png" class="h-8" alt="Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Programiranje</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
          <?php if (isset($_SESSION['user_id'])): ?>
            <a class="block rounded-md px-5 py-2 text-sm font-medium text-white bg-blue-800 hover:bg-blue-900 transition" href="<?php echo BASE_PATH ?>/profile">Profil</a>
          <?php else: ?>
            <a class="block rounded-md bg-blue-800 px-5 py-2 text-sm font-medium text-white transition hover:bg-blue-900" href="<?php echo BASE_PATH ?>/login">Prijava</a>
            <a class="hidden rounded-md bg-blue-100 px-5 py-2 text-sm font-medium text-blue-800 transition hover:text-blue-800/75 sm:block" href="<?php echo BASE_PATH ?>/register">Registracija</a>
          <?php endif; ?>
          <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
          </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-default">
          <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
            <li>
              <a href="<?php echo BASE_PATH ?>/home" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Početna</a>
            </li>
            <li>
              <a href="<?php echo BASE_PATH ?>/spcp" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Lekcije</a>
            </li>
            <!--<li>
              <a href="<?php echo BASE_PATH ?>/spcp" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Teorijski</a>
            </li>
            <li>
              <a href="<?php echo BASE_PATH ?>/spcp" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Zadaci</a>
            </li>-->
          </ul>
        </div>
      </div>
    </nav>

  </header>

  <script>
    function toggleMenu() {
      var menu = document.getElementById('menu');
      menu.classList.toggle('hidden');
    }
  </script>
</body>

</html>