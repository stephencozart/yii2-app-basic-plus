let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
mix.options({
    //extractVueStyles: true, // Extract .vue component styling to file, rather than inline.
    //globalVueStyles: 'frontend/src/sass/_variables.scss', // Variables file to be imported in every component.
    processCssUrls: false // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
});

mix.autoload({
    jquery: ['$', 'window.jQuery']
});

let prefix = '';

if (mix.inProduction()) {
    prefix = 'prod.';
} else {
    mix.sourceMaps();
}

mix.js('build/frontend/src/js/app.js', 'web/dist/'+prefix+'app.js')
    .sass('build/frontend/src/sass/app.scss', 'web/dist/'+prefix+'app.css')
    .copy('build/frontend/src/images', 'web/dist/frontend/images');

mix.js('build/backend/src/js/backend.js', 'web/dist/'+prefix+'backend.js')
    .sass('build/backend/src/sass/backend.scss', 'web/dist/'+prefix+'backend.css')
    .copy('build/backend/src/images', 'web/dist/backend/images');

mix.browserSync({
    proxy: '127.0.0.1:8000',
    files: [
        'web/dist/*.css',
        'web/dist/*.js',
        'views/**/*.php',
        'views/**/**/*.php',
        'modules/admin/views/**/*.php'
    ]
});

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.ts(src, output); <-- Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.standaloneSass('src', output); <-- Faster, but isolated from Webpack.
// mix.fastSass('src', output); <-- Alias for mix.standaloneSass().
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
