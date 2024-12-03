<template>
<div class="property-banner">
        <div class="relative h-[calc(100vh-333px)] mb-8">
            <img src="../../../images/bulding.jpg" alt="bulding" class="w-full object-cover h-full">
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-70">
                <h1 class="text-3xl md:text-4xl font-bold text-white text-center">
                    Search and Buy Real Estate in
                    <span class="text-[#088178]">Jaipur</span>
                </h1>
            </div>
        </div>
    </div>
    <section class="property-tabbing mb-11">
        <div class="container mx-auto">
            <h3 class="text-center font-semibold text-[#088178] text-4xl my-8">Property For Sale</h3>
            <div class="tabs-container w-full">
                <ul class="tabs flex gap-5 ">
                    <li class="group/item active grow" data-tag="one">
                        <div
                            class="cursor-pointer relative my-1 flex items-center justify-between bg-[#f3f3f3] rounded-xl p-4 hover:bg-[#e3e6f3] group-[.active]/item:bg-[#e3e6f3]">
                            <div class="flex gap-4 items-center">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full object-cover" src="../../../images/property-type/popular.png" />
                                </div>
                                <div class="w-full text-sm leading-6">
                                    <p class="m-0 text-slate-500">Most Popular</p>
                                </div>
                            </div>
                            <i class="fa fa-angle-right text-[16px] text-slate-500 group-[.active]/item:transform group-[.active]/item:rotate-90"></i>
                        </div>
                    </li>
                    <li class="group/item grow" data-tag="two">
                        <div
                            class="cursor-pointer relative my-1 flex items-center justify-between bg-[#f3f3f3] rounded-xl p-4 hover:bg-[#e3e6f3] group-[.active]/item:bg-[#e3e6f3]">
                            <div class="flex gap-4 items-center">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full object-cover" src="../../../images/property-type/buy-budget.png" />
                                </div>
                                <div class="w-full text-sm leading-6">
                                    <p class="m-0 text-slate-500">By Budget</p>
                                </div>
                            </div>
                            <i class="fa fa-angle-right text-[16px] text-slate-500 group-[.active]/item:transform group-[.active]/item:rotate-90"></i>
                        </div>
                    </li>
                    <li class="group/item grow" data-tag="three">
                        <div
                            class="cursor-pointer relative my-1 flex items-center justify-between bg-[#f3f3f3] rounded-xl p-4 hover:bg-[#e3e6f3] group-[.active]/item:bg-[#e3e6f3]">
                            <div class="flex gap-4 items-center">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full object-cover" src="../../../images/property-type/property-type.jpg" />
                                </div>
                                <div class="w-full text-sm leading-6">
                                    <p class="m-0 text-slate-500">By Property Type</p>
                                </div>
                            </div>
                            <i class="fa fa-angle-right text-[16px] text-slate-500 group-[.active]/item:transform group-[.active]/item:rotate-90"></i>
                        </div>
                    </li>
                    <li class="group/item grow" data-tag="four">
                        <div
                            class="cursor-pointer relative my-1 flex items-center justify-between bg-[#f3f3f3] rounded-xl p-4 hover:bg-[#e3e6f3] group-[.active]/item:bg-[#e3e6f3]">
                            <div class="flex gap-4 items-center">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full object-cover" src="../../../images/property-type/by-location.png" />
                                </div>
                                <div class="w-full text-sm leading-6">
                                    <p class="m-0 text-slate-500">By Location</p>
                                </div>
                            </div>
                            <i class="fa fa-angle-right text-[16px] text-slate-500 group-[.active]/item:transform group-[.active]/item:rotate-90"></i>
                        </div>
                    </li>
                </ul>
                <div class="tab-container flex-grow ">
                    <div id="one" class="tab-list">
                        <div class="property-slider">
                            <div class="mx-2 relative">
                                <a href="#" class="block">
                                    <img class="h-[250px] w-full object-cover" src="../../../images/products/f1.jpg"/>
                                    <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                                </a>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Independent House</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f3.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f4.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f5.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f6.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                        </div>
                    </div>
                    <div id="two" class="tab-list hidden">
                        <div class="property-slider">
                            <div class="mx-2 relative">
                                <a href="#" class="block">
                                    <img class="h-[250px] w-full object-cover" src="../../../images/products/f1.jpg"/>
                                    <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                                </a>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f3.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f4.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f5.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f6.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                        </div>
                    </div>
                    <div id="three" class="tab-list hidden">
                        <div class="property-slider">
                            <div class="mx-2 relative">
                                <a href="#" class="block">
                                    <img class="h-[250px] w-full object-cover" src="../../../images/products/f1.jpg"/>
                                    <div class="slider-bottom-content bg-custom-gradient"><p>Independent House</p></div>
                                </a>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Villa</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f3.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Residential Land / Plots</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f4.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Independent House</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f5.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Plots</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f6.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Villa</p></div>
                            </div>
                        </div>
                    </div>
                    <div id="four" class="tab-list hidden">
                        <div class="property-slider">
                            <div class="mx-2 relative">
                                <a href="#" class="block">
                                    <img class="h-[250px] w-full object-cover" src="../../../images/products/f1.jpg"/>
                                    <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                                </a>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f3.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f4.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f5.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                            <div class="mx-2 relative">
                                <img class="h-[250px] w-full object-cover" src="../../../images/products/f6.jpg"/>
                                <div class="slider-bottom-content bg-custom-gradient"><p>Budget within 2 crores</p></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>