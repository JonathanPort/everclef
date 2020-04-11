const Mix = require('laravel-mix');

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

Mix.js('resources/js/app/app.js', 'public/js')
   .sass('resources/sass/app/app.scss', 'public/css')
   .js('resources/js/auth/auth.js', 'public/js')
   .sass('resources/sass/auth/auth.scss', 'public/css')
   .copyDirectory('resources/images', 'public/images');
