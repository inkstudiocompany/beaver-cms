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
var dest = './../public/images';

/**
 * Copia las librerias de terceros.
 */
gulp.task('beaver-images', function () {
    return gulp.src([
            './images/**/*.*',
        ])
        .pipe(gulp.dest(dest))
    ;
});
