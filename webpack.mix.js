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

mix.styles('resources/sass/admin/sendcloud.css', 'public/sendcloud/css/sendcloud.css');
mix.styles('resources/sass/admin/button.css', 'public/sendcloud/css/button.css');

mix.scripts([
    'resources/js/sendcloud.ajax.js'
], 'public/sendcloud/js/sendcloud.ajax.js');

mix.scripts([
    'resources/js/sendcloud.spinner.js'
], 'public/sendcloud/js/sendcloud.spinner.js');

mix.scripts([
    'resources/js/admin/sendcloud.configuration.js'
], 'public/sendcloud/js/sendcloud.configuration.js');

mix.scripts([
    'resources/js/admin/sendcloud.dashboard.js'
], 'public/sendcloud/js/sendcloud.dashboard.js');

mix.scripts([
    'resources/js/sendcloud.welcome.js'
], 'public/sendcloud/js/sendcloud.welcome.js');
