import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                '30px': '30px',
                '62px': '62px',
              },
              height: {
                'calc-100vh-96px': 'calc(100vh - 96px)',
              },
              backgroundImage: {
                'banner-image': "url('/resources/images/bulding.jpg')",
                'off-banner-image': "url('/resources/images/banner/b2.jpg')",
                'banner-1-image': "url('/resources/images/latest.png')",
                'banner-2-image': "url('/resources/images/villa.png')",
                'banner-3-image': "url('/resources/images/banner/b7.jpg')",
                'banner-4-image': "url('/resources/images/banner/b4.jpg')",
                'banner-5-image': "url('/resources/images/banner/b18.jpg')",
                'newsletter-image': "url('/resources/images/banner/b14.png')",
                'custom-gradient': 'linear-gradient(rgba(227, 230, 243, 0), rgba(227, 230, 243, 1))',
              },
              flexGrow: {
                '1/10': '0.1',
              },
        },
    },
    plugins: [],
};
