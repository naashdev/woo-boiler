/* --------------------------------
 | Project Gulpfile
 * ------------------------------*/

var gulp = require('gulp'),
    gutil = require('gulp-util'),
    streamify = require('gulp-streamify'),
    source = require('vinyl-source-stream'),
    browserify = require('browserify'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer')
    mmq = require('gulp-merge-media-queries'),
    csso = require('gulp-csso'),
    browsersync = require('browser-sync');

gulp.task('css', function() {
    gulp.src('sass/*.sass')
        .pipe(sass({
            outputStyle: 'expanded',
            sourcemap: false
        })
        .on('error', sass.logError))
        .pipe(mmq({
            log: true
        }))
        .pipe(autoprefixer({
            browsers: ['>1%', 'ie 9']
        }))
        .pipe(csso())
        .pipe(gulp.dest('css'));
});

gulp.task('js', function() {
    browserify('js/src/build.js')
        .bundle()
        .on('error', err => {
            gutil.log("Browserify Error", gutil.colors.red(err.message));
            this.emit('end');
        })
        .pipe(source('build.min.js'))
        .pipe(streamify(uglify()))
        .pipe(gulp.dest('js/dist'));
});

gulp.task('watch', function() {

    // Start BrowserSync Server
    browsersync.init({
        server: {
            baseDir: "./"
        }
    });

    // Watch Files
    gulp.watch('sass/**/*.sass', ['css']);
    gulp.watch('js/src/**/*.js', ['js']);
    gulp.watch('css/master.css').on('change', browsersync.reload);
    gulp.watch('js/dist/build.min.js').on('change', browsersync.reload);
    gulp.watch("index.html").on('change', browsersync.reload);

});
