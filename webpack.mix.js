let mix = require('laravel-mix');

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

mix.webpackConfig({ module: { rules: [ { test: /\.scss$/, loader: 'import-glob-loader' }, ] } });

//js app
mix.js('resources/assets/js/app.js', 'public/js')

//js admin app
.js('resources/assets/js/admin/app.js', 'public/js/admin')

//sass app
.sass('resources/assets/sass/app.scss', 'public/css')

//sass admin app
.sass('resources/assets/sass/admin/app.scss', 'public/css/admin')

//sass vendor
.sass('resources/assets/sass/vendor.scss', 'public/css')

//sass admin vendor
.sass('resources/assets/sass/admin/vendor.scss', 'public/css/admin')




//prozorro specifications
//.sass('public/specifications/styles.scss', 'public/specifications')




//generate sourceMaps
//.sourceMaps(true,'source-map')

//add hash version to file {{ mix('/css/app.css') }}
.version()

//images
.copy( 'resources/assets/i', 'public/i', false )
.copy( 'resources/assets/images', 'public/images', false )

// .browserSync(
// {
//     files: ["public/**/*", "craft/config/**/*", "craft/templates/**/*"],
//     proxy: "https://sargentmetal.dev"
// }

//.setResourceRoot('/assets/')

if (mix.inProduction()) {
    //mix.version();
}