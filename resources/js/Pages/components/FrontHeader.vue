<template>
    <header class="sticky top-0 z-40">
        <div class="top-header bg-[#088178] text-white text-center py-1">
            <p>Welcome offer on first Purchase. use code WELCOME24 ti avial grap this offer</p>
        </div>
        <nav
            class="p-4 bg-[#e3e6f3] text-[#1a1a1a] fixed w-full top-[30px] left-0 right-0 z-50 shadow-[0_5px_15px_rgba(0,0,0,0.06)]">
            <div class="flex justify-between items-center">
                <div class="flex items-center md:pl-8">
                    <i class="text-2xl fas fa-campground"></i>
                    <h1 class="font-serif tracking-wide font-bold text-xl pl-4">Logo</h1>
                </div>
                <div class="md:hidden block absolute top-4 right-8 fixed">
                    <button aria-label="navigation" type="button"
                        class="md:hidden text-[#1a1a1a] transition duration-300 focus:outline-none"><i
                            class="fas fa-bars text-3xl" id="bars"></i> </button>
                </div>
                <div class="hidden md:flex">
                    <ul class="hidden md:flex">
                        <li class="text-lg pr-8 relative "><a href="javascript:void(0)"
                                class="transition duration-300  focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178] font-semibold link-after active">Home</a>
                        </li>
                        <li class="text-lg pr-8 relative"><a href="javascript:void(0)"
                                class="transition duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178] font-semibold link-after">About</a>
                        </li>
                        <li class="text-lg pr-8 relative"><a href="javascript:void(0)"
                                class="transition duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178] font-semibold link-after">Property</a>
                        </li>
                        <li class="text-lg pr-8 relative"><a href="javascript:void(0)"
                                class="transition duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178] font-semibold link-after">Blog</a>
                        </li>
                        <li class="text-lg pr-8 relative"><a href="javascript:void(0)"
                                class="transition duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178] font-semibold link-after">Contact</a>
                        </li>
                        <li class="text-lg pr-8 relative"><a href="javascript:void(0)" data-modal-target="login-modal"
                                data-modal-toggle="login-modal"
                                class="transition duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178] font-semibold link-after">Login</a>
                        </li>
                    </ul>
                </div>

                <div class="hidden md:flex">
                    <a href="#"><i
                            class="fab fa-facebook text-2xl pr-8 transition duration-300 focus:text-[#088178] hover:text-[#088178]"></i></a>
                    <a href="#"><i
                            class="fab fa-linkedin text-2xl pr-8 transition duration-300 focus:text-[#088178] hover:text-[#088178]"></i></a>
                    <a href="#"><i
                            class="fab fa-instagram text-2xl pr-8 transition duration-300 focus:text-[#088178] hover:text-[#088178]"></i></a>
                    <a href="#"><i
                            class="fab fa-twitter text-2xl pr-8 transition duration-300 focus:text-[#088178] hover:text-[#088178]"></i></a>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div id="mobileMenu" class="hidden flex w-full mx-auto py-8 text-center">
                <div class="flex flex-col justify-center items-center w-full">
                    <a href="#"
                        class="block text-[#1a1a1a] cursor-pointer py-3 transition font-semibold duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178]">Home</a>
                    <a href="#"
                        class="block text-[#1a1a1a] cursor-pointer mt-1 py-3 transition font-semibold duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178]">About</a>
                    <a href="#"
                        class="block text-[#1a1a1a] cursor-pointer mt-1 py-3 transition font-semibold duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178]">Blog</a>
                    <a href="#"
                        class="block text-[#1a1a1a] cursor-pointer mt-1 py-3 transition font-semibold duration-300 focus:outline-none focus:text-[#088178] focus:underline  hover:text-[#088178]">Contact</a>
                </div>
            </div>
        </nav>
    </header>
</template>