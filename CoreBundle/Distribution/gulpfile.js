'use strict'
/**
 * Gulp File
 * Version 1.0
 */

/*
 * Dependencies
 */
var
    gulp        = require('gulp'),
    options     = require('yargs').argv,
    requiredir  = require('require-dir')
;

requiredir('./gulp-tasks');

if ('dev' === options.env) {
}

gulp.task('default', ['beaver-script', 'backend-styles', 'backend-fonts']);
