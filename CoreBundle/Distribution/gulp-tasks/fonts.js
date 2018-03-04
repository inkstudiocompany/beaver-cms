'use strict'
/**
 * Gulp File
 * Version 1.0
 */

/*
 * Dependencies
 */
var gulp        = require('gulp');

/**
 * Destino de los archivos.
 * @type {string}
 */
var dest = '../public/bundles/beaver/fonts';

/**
 * Lista de dependencias
 * @type {string[]}
 */
var thirdParty = [
    'node_modules/font-awesome/fonts/**/*.*',
];

/**
 * Copia las librerias de terceros.
 */
gulp.task('third-party-fonts', function () {
    return gulp.src(thirdParty)
        .pipe(gulp.dest(dest))
    ;
});

/**
 * Compila los archivos de backend.
 */
gulp.task('fonts', ['third-party-fonts'], function () {
    return gulp.src([])
        .pipe(gulp.dest(dest))
});

gulp.task('backend-fonts', ['fonts']);