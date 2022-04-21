<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fr.allfont.net/allfont.css?fonts=comic-sans-ms" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>comics_project</title>
</head>
<body class=" relative flex flex-col items-center text-white work-sans leading-normal text-base">
    <!--Nav-->
    <nav id="header" class="nav w-full h-44 z-30 top-0 py-1">
        <div class="w-full h-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-6 py-3">
            <label for="menu-toggle" class="cursor-pointer md:hidden block">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
                    <title>menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </label>
            <input class="hidden" type="checkbox" id="menu-toggle" />
            <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
                <nav>
                    <ul class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0">
                        <li><a class="inline-block no-underline text-white hover:text-red-700 hover:underline py-2 px-4" href="../index.php">Home</a></li>
                        <li><a class="inline-block no-underline text-white hover:text-red-700 hover:underline py-2 px-4" href="../about.php">About</a></li>
                    </ul>
                </nav>
            </div>
            <div class="order-1 md:order-2">
                <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-white text-2xl " href="#">
                    MARVEL COMICS SHOP
                </a>
            </div>
            <div class="order-2 md:order-3 flex items-center" id="nav-content">
                <a class="pl-3 inline-block no-underline hover:text-red-700" href="../cart.php">
                    <span class="relative inline-block">
                        <svg class="fill-current hover:text-red-700" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
                            <path d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z" />
                            <circle cx="10.5" cy="18.5" r="1.5" />
                            <circle cx="17.5" cy="18.5" r="1.5" />
                        </svg>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"><?=$quantity = in_array($_SESSION['cart'], $_SESSION)? sizeof($_SESSION['cart']) : 0?></span>
                    </span>
                </a>
            </div>
        </div>
    </nav>