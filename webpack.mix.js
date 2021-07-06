const mix = require('laravel-mix');
const path = require('path');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Site Application
mix.combine([
    'resources/js/site/theme/css/bootstrap.min.css',
    'resources/js/site/theme/plugins/fontawesome/css/fontawesome.min.css',
    'resources/js/site/theme/plugins/fontawesome/css/all.min.css',
    'resources/js/site/theme/css/owl.carousel.min.css',
    'resources/js/site/theme/css/owl.theme.default.min.css',
    'resources/js/site/theme/css/style.css',
], 'public/css/site-theme.css');
mix.sass('resources/js/site/sass/app.scss', 'public/css/site.css');
mix.js('resources/js/site/app.js', 'public/js/site.js');
// Admin Application
mix.sass('resources/js/admin/sass/app.scss', 'public/css/admin.css');
mix.js('resources/js/admin/app.js', 'public/js/admin.js');
// Instructor Application
mix.sass('resources/js/instructor/sass/app.scss', 'public/css/instructor.css');
mix.js('resources/js/instructor/app.js', 'public/js/instructor.js');

mix.vue({version: 2});

if(mix.inProduction()){
    mix.version();
}

mix.webpackConfig(webpack => {
    return {
        resolve: {
            extensions: ["*", ".js", ".vue"],
            alias: {
                '@': path.resolve(__dirname, 'resources/js/')
            }
        },
    }
})
