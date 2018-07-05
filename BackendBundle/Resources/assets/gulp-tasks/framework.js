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
var dest = './../public/js';

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
    './js/Helpers/*.js'
];

/**
 * Define app scripts.
 *
 * @type {string[]}
 */
var app = [
    './js/App/*.js'
];

/**
 * Jquery Plugins.
 *
 * @type {string[]}
 */
var jqueryPlugins = [
    './js/jquery-plugins/*.js'
];

/**
 * Main App Script.
 *
 * @type {string[]}
 */
var main = [
    './js/main.js'
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