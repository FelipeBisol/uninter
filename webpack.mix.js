const mix = require('laravel-mix');

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

mix.
    styles([
        'resources/views/assets/css/kanban.css',
    ], 'public/assets/css/kanban.css')
    .styles([
            'resources/views/assets/bootstrap/css/bootstrap.min.css'
        ], 'public/assets/css/bootstrap.min.css')
    .scripts([
        'resources/views/assets/js/jquery-1.11.2.min.js',
    ], 'public/assets/js/script.js')
    .scripts([
        'resources/views/assets/bootstrap/js/bootstrap.min.js'
    ], 'public/assets/js/bootstrap.min.js');
