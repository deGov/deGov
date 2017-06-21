var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var Eyeglass = require('eyeglass').Eyeglass;
var path = require('path');
var webpackConfig = require('./webpack.config');
var webpack = require('webpack-stream');
var del = require('del');
var reporter    = require('postcss-reporter');
var syntaxScss = require('postcss-scss');
var stylelint   = require('stylelint');


var watchOptions = {
  debounceDelay: 50,
  mode: 'poll'
};

var styleOptions = new Eyeglass({
  sassOptions: {
    errLogToConsole: true,
    outputStyle: 'expanded'
  },
  eyeglass: {
    enableImportOnce: false
  },
  importer: function(uri, prev, done) {
    done($.sass.compiler.types.NULL);
  }
});

// Stylelint config rules
var stylelintOptions = {
  "rules": {
    "block-no-empty": true,
    "color-no-invalid-hex": true,
    "declaration-colon-space-after": "always",
    "declaration-colon-space-before": "never",
    "function-url-quotes": "double",
    "media-feature-colon-space-after": "always",
    "media-feature-colon-space-before": "never",
    "media-feature-name-no-vendor-prefix": true,
    "max-nesting-depth": 4,
    "number-no-trailing-zeros": true,
    "property-no-vendor-prefix": true,
    "declaration-block-no-duplicate-properties": true,
    "block-no-single-line": true,
    "selector-no-id": true,
    "string-quotes": "double",
    "value-no-vendor-prefix": true,
    "stylelint-disable-reason": "always-after",
    "unit-no-unknown": true
  }
}
var postcssProcessors = [
  stylelint(stylelintOptions),
  reporter({
    clearMessages: true,
    throwError: true
  })
];

function handleError (err) {
  $.util.log('\n', $.util.colors.red(err), '\n');
  this.emit('end');
};


/**
 * Format SASS code
 */
gulp.task('sass:format', function() {
  // formatting sass code
  return gulp.src(['./source/sass/**/*.scss'])
    .pipe($.cached('sassFormat'))
    .pipe($.debug({title: 'Formatting SASS file:'}))
    .pipe($.plumber({ errorHandler: handleError }))
    .pipe($.cssfmt())
    .pipe($.csscomb())
    .pipe($.postcss(postcssProcessors, { syntax: syntaxScss }))
    .pipe(gulp.dest('./source/sass'));
});

/**
 * Compiling SASS code with sourcemaps and eyeglass modules and autoprefixing
 */
gulp.task('sass', function() {
  return gulp.src(['./source/sass/**/*.scss'])
    .pipe($.sassGlob())
    .pipe($.cached('sassCode'))
    .pipe($.progeny())
    .pipe($.debug({title: 'Compiling SASS file:'}))
    .pipe($.sourcemaps.init())
    .pipe($.sourcemaps.write({includeContent: false, sourceRoot: '.'}))
    .pipe($.sourcemaps.init({loadMaps: true}))
    .pipe($.sass(styleOptions).on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 3 version', '> 1%'],
      cascade: false
    }))
    .pipe($.sourcemaps.write({
      includeContent: false,
      sourceRoot: '../../source/sass'
    }))
    .pipe(gulp.dest('./public/css'))
    .pipe($.livereload());
});

/**
 * Handles Images
 * Copies over any files in ./source/images
 * Runs them through imagemin for optimisations
 */
gulp.task('img', function() {
  return gulp.src(['./source/images/**'])
    .pipe($.cached('img'))
    .pipe($.debug({title: 'Copying image file:'}))
    .pipe($.plumber({ errorHandler: handleError }))
    .pipe($.imagemin({
      progressive: true,
      svgo$: [{removeViewBox: false}]
    }))
    .pipe(gulp.dest('./public/images'))
    .pipe($.livereload());
});

/**
 * Handles fonts
 * Copies over any files in ./source/fonts
 */
gulp.task('font', function() {
  return gulp.src(['./source/fonts/**'])
    .pipe($.cached('font'))
    .pipe($.debug({title: 'Copying font file:'}))
    .pipe($.plumber({ errorHandler: handleError }))
    .pipe(gulp.dest('./public/fonts'))
    .pipe($.livereload());
});

/**
 * Handles JS
 * Runs JS code through webpack compilation
 */
gulp.task('lint', function() {
  return gulp.src(['./source/js/**/*.js'])
    .pipe($.plumber({ errorHandler: handleError }))
    .pipe($.cached('js'))
    .pipe($.debug({title: 'Linting JS file:'}))
    .pipe($.eslint())
    .pipe($.eslint.format())
    .pipe($.eslint.failAfterError());
});

gulp.task('js', function() {
  return gulp.src('./source/js/main.js')
    .pipe($.debug({title: 'Compiling JS bundle:'}))
    .pipe(webpack(webpackConfig))
    .pipe(gulp.dest('./public/js'))
    .pipe($.livereload());
});

/**
 * Cleans out ./public directory
 */
gulp.task('clean', function(cb) {
  del([
    './public/images/*',
    './public/fonts/*',
    './public/css/*',
    './public/js/*'
  ]);
  if (cb) {
    cb();
  }
});

/**
 * Start watch tasks and livereloading server
 */
gulp.task('watch', function() {
  $.livereload.listen()
  gulp.watch(['./source/sass/**'], watchOptions, ['sass'])
  gulp.watch(['./source/js/**'], watchOptions, ['lint', 'js'])
  gulp.watch(['./source/images/**'], watchOptions, ['img'])
  gulp.watch(['./source/fonts/**'], watchOptions, ['font'])
});

/**
 * Gulp default task:
 * - Clean ./public
 * - Handle SASS
 * - Handle JS
 * - Handle images
 * - Handle fonts
 * - Start watch task
 */
gulp.task('default', ['clean'], function() {
  gulp.start('sass');
  gulp.start('lint');
  gulp.start('js');
  gulp.start('img');
  gulp.start('font');
  gulp.start('watch');
});
