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
    pump        = require('pump'),
    uglifycss   = require('gulp-uglifycss'),
    sass        = require('gulp-sass')
;

/**
 * Destino de los archivos.
 * @type {string}
 */
var dest = '../public/bundles/beaver/css';

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
gulp.task('third-party-styles', () => {
    gulp.src(thirdParty)
    .pipe(gulp.dest(dest))
;
});

/**
 * Compila los archivos de backend.
 */
gulp.task('styles', ['third-party-styles'], (response) => {
    pump([
             gulp.src([
            '../src/Beaver/BackendBundle/Resources/assets/scss/cms.scss',
            '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/scss/css.scss'
        ]),
             sass().on('error', sass.logError),
             concat('styles.css'),
             uglifycss(),
             gulp.dest(dest)
         ], response);
});

/**
 * Compila los archivos de backend.
 */
gulp.task('login-styles', function () {
    return gulp.src([
        '../src/Beaver/BackendBundle/Resources/assets/scss/login.scss',
        '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/scss/login.scss'
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
        '../src/Beaver/BackendBundle/Resources/assets/scss/modules/*.scss',
        '../vendor/inkstudio/beaver/BackendBundle/Resources/assets/scss/modules/*.scss'
    ])
        .pipe(sass().on('error', sass.logError))
        .pipe(uglifycss())
        .pipe(gulp.dest(dest));
});

gulp.task('backend-styles', ['styles', 'login-styles', 'modules-styles']);