import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import AdminLayout from "./Layouts/AdminLayout.vue";

createInertiaApp({
    title: (title) => `RealState ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || AdminLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
});

$(document).ready(function () {
    $(".all-item-slider").slick({
        slidesToShow: 3,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 4000,
        cssEase: "linear",
        pauseOnHover: false,
        rtl: true,
    });
    $(".items-slider").slick({
        slidesToShow: 2,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 4000,
        cssEase: "linear",
        pauseOnHover: false,
        rtl: false,
    });
    $(".tabs li").click(function () {
        let $this = $(this);
        let tagid = $this.attr("data-tag");
        console.log("jhfjh");
        $(".tabs li").removeClass("active");
        $this.addClass("active");
        $(".tab-list").removeClass("hidden").addClass("hidden");
        $("#" + tagid)
            .addClass("hidden")
            .removeClass("hidden");
        $("#" + tagid)
            .find(".property-slider")
            .slick("refresh");
    });

    $(".property-slider").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrow: true,
        autoplay: true,
        prevArrow:
            '<div class="slick-prev prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
        nextArrow:
            '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
        focusOnSelect: true,
    });

    $(".sign-up").click(function () {
        $(".login-modal-container").addClass("right-panal-active");
    });
    $(".sign-in").click(function () {
        $(".login-modal-container").removeClass("right-panal-active");
    });
});
