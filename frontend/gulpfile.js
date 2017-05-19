const gulp = require('gulp'), sass = require('gulp-sass'), browserify = require('browserify'),
  concat = require('gulp-concat'), glob = require('glob'), uglify = require('gulp-uglify'),
  source = require('vinyl-source-stream'), buffer = require('vinyl-buffer'), sourcemaps = require('gulp-sourcemaps'),
  gutil = require('gulp-util'), babelify = require('babelify'), rename = require("gulp-rename"),
  watch = require('gulp-watch'), yargs = require('yargs'), gulpif = require('gulp-if');

let args = yargs.argv;
let isProd = !!(args.prod);

let _compileScripts = () => {
  gutil.log(gutil.colors.blue("Compiling Scripts"));
  let files = ['./vendor.js'];
  files = [...files, ...glob.sync('./src/scripts/**/*.js')];

  return browserify({ entries: files, debug: true })
    .transform(babelify, { presets: ['env'], sourceMaps: true })
    .bundle()
    .on('error', (err) => {
      gutil.log('Browerserify Error', gutil.colors.red(err.message))
    })
    .pipe(source('main.min.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadmaps: true }))
    .pipe(gulpif(isProd, uglify()))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('../web/dist/js'));
};

let _compileStyles = () => {
  gutil.log(gutil.colors.blue("Compiling Styles"));
  return gulp.src('./src/styles/main.scss')
    .pipe(rename('main.min.css'))
    .pipe(sourcemaps.init())
    .pipe(gulpif(isProd, sass({outputStyle: 'compressed'}).on('error', (err) => gutil.colors.red(err.message))))
    .pipe(gulpif(!isProd, sass().on('error', (err) => gutil.colors.red(err.message))))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('../web/dist/css'));
}

gulp.task('default', () => {
  _compileStyles();
  _compileScripts();
});

gulp.task('watch', () => {
  watch(['vendor.js', 'src/scripts/**/*.js'], { ignoreInitial: false }, () => { _compileScripts() });
  watch('src/styles/**/*.scss', { ignoreInitial: false }, () => { _compileStyles() });
});

gulp.task('scripts', () => {
  return _compileScripts();
});

gulp.task('styles', () => {
  return _compileStyles();
});