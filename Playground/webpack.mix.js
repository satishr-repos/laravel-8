const mix = require('laravel-mix'), assetsDir = 'resources/', distDir = 'public/dist/';

mix.js( assetsDir + 'js/app.js', distDir + 'js/app.js')
    .sass(assetsDir + 'scss/app.scss', distDir + 'css/app.css');

if (mix.inProduction()) {
  mix.version();
}
