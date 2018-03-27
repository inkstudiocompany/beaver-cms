'use strict';

/**
 * Gulp Dependencies.
 * @type {Gulp|*}
 */
var gulp        = require('gulp'),
    concat      = require('gulp-concat'),
    composer    = require('gulp-uglify/composer'),
    uglifyjs    = require('uglify-es')
;

var minify = composer(uglifyjs, console);

/**
 * Public path.
 *
 * @type {string}
 */
var dest = '../public/bundles/beaver/js';

/**
 * Define third party dependencies.
 *
 * @type {string[]}
 */
var required = [
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'node_modules/progressbar.js/dist/progressbar.js',
    'node_modules/sweet-modal/dist/dev/jquery.sweet-modal.js',
];

/**
 * Define helpers for framework.
 *
 * @type {string[]}
 */
var helpers = [
    '../src/Beaver/BackendBundle/Resources/assets/js/Helpers/*.js',
    '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/js/Helpers/*.js',
];

/**
 * Define app scripts.
 *
 * @type {string[]}
 */
var app = [
    '../src/Beaver/BackendBundle/Resources/assets/js/App/*.js',
    '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/js/App/*.js',
];

/**
 * Jquery Plugins.
 *
 * @type {string[]}
 */
var jqueryPlugins = [
    '../src/Beaver/BackendBundle/Resources/assets/js/jquery-plugins/*.js',
    '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/js/jquery-plugins/*.js'
];

/**
 * Main App Script.
 *
 * @type {string[]}
 */
var main = [
    '../src/Beaver/BackendBundle/Resources/assets/js/main.js',
    '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/js/main.js'
];

/**
 * Compile files.
 */
gulp.task('beaver-script', function () {
    return gulp.src(required.concat(helpers).concat(jqueryPlugins).concat(app).concat(main))
        .pipe(concat('beaver.min.js'))
        .pipe(gulp.dest(dest))
;
});