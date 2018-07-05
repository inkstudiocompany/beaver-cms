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
    uglifycss   = require('gulp-uglifycss'),
    sass        = require('gulp-sass')
;

/**
 * Destino de los archivos.
 * @type {string}
 */
var dest = './../public/css';

/**
 * Lista de dependencias
 * @type {string[]}
 */
var thirdParty = [
    'node_modules/font-awesome/css/font-awesome.min.css',
    'node_modules/animate.css/animate.min.css',
    'node_modules/sweet-modal/dist/min/jquery.sweet-modal.min.css',
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/bootstrap/dist/css/bootstrap-grid.min.css',
    'node_modules/cropperjs/dist/cropper.min.css',
];

/**
 * Copia las librerias de terceros.
 */
gulp.task('third-party-styles', function () {
    return gulp.src(thirdParty)
        .pipe(gulp.dest(dest))
    ;
});

/**
 * Compila los archivos de backend.
 */
gulp.task('styles', ['third-party-styles'], function () {
    return gulp.src([
            './scss/cms.scss'
        ])
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('styles.css'))
        .pipe(uglifycss())
        .pipe(gulp.dest(dest))
    ;
});

/**
 * Compila los archivos de backend.
 */
gulp.task('login-styles', function () {
    return gulp.src([
        './scss/login.scss'
    ])
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('login.css'))
    .pipe(uglifycss())
    .pipe(gulp.dest(dest));
});

/**
 * Compila los archivos de backend.
 */
gulp.task('modules-styles', function () {
    return gulp.src([
        './scss/modules/*.scss'
    ])
    .pipe(sass().on('error', sass.logError))
    .pipe(uglifycss())
    .pipe(gulp.dest(dest));
});

gulp.task('backend-styles', ['styles', 'login-styles', 'modules-styles']);