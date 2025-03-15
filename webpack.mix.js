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

mix.js('resources/js/app.js', 'public/js')
    .scripts([
        'public/js/datatable.js'
    ], 'public/js/datatable.js')
    .scripts([
        'public/js/template.js',
    ], 'public/js/template.js')
    .scripts([
        'public/js/plugins.js',
    ], 'public/js/plugins.js')
    .styles([
        'public/css/datatable.css'
    ], 'public/css/datatable.css')
    .styles([
        'public/css/plugins.css'
    ], 'public/css/plugins.css')
    .styles([
        'public/css/template.css'
    ], 'public/css/template.css')
    .react();