'use strict'
/**
 * Gulp File
 * Version 1.0
 */

/*
 * Dependencies
 */
var gulp        = require('gulp'),
    concat      = require('gulp-concat'),
    composer    = require('gulp-uglify/composer'),
    uglifyjs    = require('uglify-es')
;

var minify = composer(uglifyjs, console);

/**
 * Destino de los archivos.
 * @type {string}
 */
var dest = '../public/bundles/beaver/js';

/**
 * Lista de dependencias
 * @type {string[]}
 */
var thirdParty = [
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    'node_modules/progressbar.js/dist/progressbar.min.js',
    'node_modules/cropperjs/dist/cropper.common.js',
    'node_modules/cropperjs/dist/cropper.min.js',
];

/**
 * Copia las librerias de terceros.
 */
gulp.task('third-party-scripts', function () {
    return gulp.src(thirdParty)
        .pipe(gulp.dest(dest))
    ;
});

/**
 * Compila los archivos de backend.
 */
gulp.task('beaver-jquery-plugins', ['third-party-scripts'], function () {
    return gulp.src([
        '../src/Beaver/BackendBundle/Resources/assets/js/jquery-plugins/*.js',
        '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/js/jquery-plugins/*.js'
    ])
    .pipe(concat('jquery.beaver.min.js'))
    .pipe(gulp.dest(dest));
});

/**
 * Compila los archivos de backend.
 */
gulp.task('javascript', ['beaver-jquery-plugins'], function () {
    return gulp.src([
        '../src/Beaver/BackendBundle/Resources/assets/js/*.js',
        '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/js/*.js'
    ])
    .pipe(concat('backend.js'))
    .pipe(gulp.dest(dest))
    ;
});

gulp.task('backend-scripts', ['javascript']);