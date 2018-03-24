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
var dest = '../public/bundles/beaver/images';

/**
 * Copia las librerias de terceros.
 */
gulp.task('beaver-images', function () {
    return gulp.src([
            '../src/Beaver/BackendBundle/Resources/assets/images/**/*.*',
            '../vendor/beaver/Beaver/BackendBundle/Resources/assets/images/**/*.*'
        ])
        .pipe(gulp.dest(dest))
    ;
});
