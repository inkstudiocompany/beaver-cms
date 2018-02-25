'use strict'
/**
 * Gulp File
 * Version 1.0
 */

/*
 * Dependencies
 */
var gulp        = require('gulp'),
    pump        = require('pump')
;

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
gulp.task('third-party-fonts', () => {
    gulp.src(thirdParty)
        .pipe(gulp.dest(dest))
    ;
});

/**
 * Compila los archivos de backend.
 */
gulp.task('fonts', ['third-party-fonts'], (response) => {
    pump([
        gulp.src([]),
        gulp.dest(dest)
    ], response);
});

gulp.task('backend-fonts', ['fonts']);