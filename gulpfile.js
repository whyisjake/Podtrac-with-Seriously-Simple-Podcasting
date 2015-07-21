var gulp = require('gulp');
var wpPot = require('gulp-wp-pot');

gulp.task('default', function () {
    return gulp.src('podtrac.php')
        .pipe(wpPot( {
            domain: 'podtrac-ss-podcasting',
            destFile:'file.pot',
            lastTranslator: 'Jake Spurlock <jake_spurlock@wired.com>',
            team: 'Jake Spurlock <jake_spurlock@wired.com>'
        } ))
        .pipe(gulp.dest('languages'));
});