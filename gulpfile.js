var gulp = require('gulp');
var less = require('gulp-less');
var minify = require('gulp-minify-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('create-css', function() {
    gulp.src('wp-content/themes/churchathome/css/*.less')
        .pipe(less({style:'compress'}))
        .pipe(minify())
        .pipe(gulp.dest('wp-content/themes/churchathome/'));
});

gulp.task('create-js', function() {
    gulp.src('wp-content/themes/churchathome/js/edit/*.js')
        .pipe(concat('master.js'))
        .pipe(uglify())
        .pipe(gulp.dest('wp-content/themes/churchathome/js/gen'));
});

gulp.task('default', function() {
    gulp.run('create-css');
    gulp.run('create-js');

    gulp.watch('wp-content/themes/churchathome/css/*.less', function() {
        gulp.run('create-css');
    });
    gulp.watch('wp-content/themes/churchathome/js/edit/*.js', function() {
        gulp.run('create-js');
    });
});