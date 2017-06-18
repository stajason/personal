const { mix } = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');


mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/weui/dist/style/weui.min.css',
    'node_modules/photoswipe/dist/photoswipe.css',
    'node_modules/photoswipe/dist/default-skin/default-skin.css',
], 'public/assets/pc/dist/css/style.min.css');

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/angular/angular.min.js',
    'node_modules/angular-route/angular-route.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/angular-load/dist/angular-load.min.js',
    'node_modules/angular-resource/angular-resource.min.js',
    'node_modules/angular-animate/angular-animate.min.js',
    'node_modules/photoswipe/dist/photoswipe.min.js',
    'node_modules/photoswipe/dist/photoswipe-ui-default.min.js',
], 'public/assets/pc/dist/js/common.min.js');

mix.scripts([
    'public/assets/pc/src/app.js',
    'public/assets/pc/src/providers.js',
    'public/assets/pc/src/routes.js',
    'public/assets/pc/src/bootstrap.js',
    'public/assets/pc/src/helper.js',
    'public/assets/pc/src/js/controllers/*.js',
], 'public/assets/pc/dist/js/main.min.js');
