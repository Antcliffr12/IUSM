var fs = require('fs');
var path = require('path');
var argv = require('yargs').argv;

var gulp = require('gulp');
var plugins = require('gulp-load-plugins')(); // Load all gulp plugins
                                              // automatically and attach
                                              // them to the `plugins` object

var runSequence = require('run-sequence');    // Temporary solution until gulp 4
                                              // https://github.com/gulpjs/gulp/issues/355

var pkg = require('./package.json');
var dirs = {
    assets: '../assets',
    bundledAssets: '../assets/bundles'
};

// ---------------------------------------------------------------------
// | Helper tasks                                                      |
// ---------------------------------------------------------------------

// Create output directory for compiled assets
gulp.task('build:create_output_dir', function () {
    fs.mkdirSync(path.resolve(dirs.bundledAssets), '0755');
});

gulp.task('component:stub', function(){
    var cName = argv.name || 'newcomponent';
    var cDir = path.resolve(dirs.assets)+'/components/'+cName;
    fs.mkdirSync(cDir, '0755');
    return gulp.src([
        '../.build/stubs/component/*'
    ])
        .pipe(plugins.rename(function (path) {
            path.basename = path.basename.replace('component', cName);
        }))
        .pipe(gulp.dest(cDir));
});

gulp.task('patchfiles', function(){
    gulp.src([
        dirs.assets +'/scripts/vc_backend.min.js'
    ])
        .pipe(plugins.rename(function (path) {
            path.basename = path.basename.replace('vc_', '');
        }))
        .pipe(gulp.dest(path.resolve('../../../plugins/js_composer/assets/js/dist')));
    return true;
});

// Purge compiled files
gulp.task('clean', function (done) {
    require('del')([
        dirs.bundledAssets
    ], done);
});

gulp.task('bootstrap', function () {
    return gulp.src(dirs.assets + '/styles/bootstrap/bootstrap.less')
        .pipe(plugins.less())
        .pipe(gulp.dest(dirs.bundledAssets));
});

gulp.task('css-main', function () {
    return gulp.src([

        // Warning Banner
        '../.build/bundle-banner.css',

        // Branding
        dirs.assets + '/styles/fonts.less',
        dirs.assets + '/styles/brand.less',
        dirs.assets + '/styles/font-awesome.min.css',
        dirs.assets + '/styles/iu-colors.less',
        dirs.assets + '/styles/social-media-colors.less',

        // Base Site-Specific Config Constants
        dirs.assets + '/styles/site-config.less',

        dirs.assets + '/bundles/bootstrap.css',

        // IUSM General & Global Styles
        dirs.assets + '/styles/mixins.less',
        dirs.assets + '/styles/base.less',
        dirs.assets + '/styles/shared-elements.less',
        dirs.assets + '/styles/site.less',
        dirs.assets + '/styles/vc-style-overrides.less',

        // Slick Slider Base & Theme styles
        dirs.assets + '/scripts/slick-carousel/slick/slick.less',
        dirs.assets + '/scripts/slick-carousel/slick/slick-theme.less',

        // Component Styles
        dirs.assets + '/components/*/*.less'
    ])
        .pipe(plugins.concat('styles.less'))
        .pipe(plugins.less())
        .pipe(gulp.dest(dirs.bundledAssets));
});

gulp.task('css-admin', function () {
    return gulp.src([

        // Warning Banner
        '../.build/bundle-banner.css',
        '../theme/custom-tags-metabox/custom-tags-metabox.less',
        // Branding
        dirs.assets + '/styles/fonts.less',
        dirs.assets + '/styles/iu-colors.less',
        dirs.assets + '/styles/social-media-colors.less',

        // Base Site-Specific Config Constants
        dirs.assets + '/styles/site-config.less',

        // IUSM General & Global Styles
        dirs.assets + '/styles/mixins.less',
        '../.build/vc-backend-editor-begin-scope.css',
        dirs.assets + '/styles/shared-elements.less',
        dirs.assets + '/styles/admin.less',
        dirs.assets + '/styles/vc-style-overrides.less',


        // Component Styles
        dirs.assets + '/components/*/*.less',

        '../.build/vc-backend-editor-end-scope.css'
    ])
        .pipe(plugins.concat('styles-admin.less'))
        .pipe(plugins.less())
        .pipe(gulp.dest(dirs.bundledAssets));
});

gulp.task('css', ['css-main', 'css-admin']);

gulp.task('js-main', function () {
    return gulp.src([

        // Warning Banner
        '../.build/bundle-banner.js',

        // Base Libraries
        dirs.assets + '/scripts/enquire.min.js',

        // Bootstrap v3 Framework Components
        dirs.assets + '/scripts/bootstrap/affix.js',
        dirs.assets + '/scripts/bootstrap/alert.js',
        dirs.assets + '/scripts/bootstrap/button.js',
        dirs.assets + '/scripts/bootstrap/scrollspy.js',
        dirs.assets + '/scripts/bootstrap/tab.js',
        dirs.assets + '/scripts/bootstrap/carousel.js',
        dirs.assets + '/scripts/bootstrap/collapse.js',
        dirs.assets + '/scripts/bootstrap/dropdown.js',
        dirs.assets + '/scripts/bootstrap/tooltip.js',
        dirs.assets + '/scripts/bootstrap/transition.js',
        dirs.assets + '/scripts/bootstrap/modal.js',
        dirs.assets + '/scripts/bootstrap/popover.js',
        dirs.assets + '/scripts/jquery-ui.min.js',


        // dirs.assets + '/scripts/copyToClipboard.js',

        // Slick Slider Scripts
        dirs.assets + '/scripts/slick-carousel/slick/slick.min.js',

        // Event Page Script
        //dirs.assets + '/scripts/event.js',
        //dirs.assets + '/scripts/moreevent.js',

        // Main IUSM Namespace and Global Scripts
        dirs.assets + '/scripts/main.js',

        dirs.assets + '/scripts/shrinkingHeader.js',

        // IUSM Components
        dirs.assets + '/components/*/*.js',

        dirs.assets + '/scripts/subscribe-to-category-mods.js',

        // Final initialization tasks
        dirs.assets + '/scripts/onload.js'
    ])
        .pipe(plugins.concat('scripts.js'))
        .pipe(gulp.dest(dirs.bundledAssets));
});


gulp.task('js-admin', function(){
    return gulp.src([
        dirs.assets + '/scripts/metaBoxImage.js',
        dirs.assets + '/scripts/sectionLevelBannerTitleControls.js',
        '../theme/custom-tags-metabox/custom-tags-metabox.js'
    ])
        .pipe(plugins.concat('admin-scripts.js'))
        .pipe(gulp.dest(dirs.bundledAssets));
});


gulp.task('js', ['js-main', 'js-admin']);


// ---------------------------------------------------------------------
// | Main tasks                                                        |
// ---------------------------------------------------------------------

gulp.task('build', function (done) {
    runSequence(
        'bootstrap',
        'css',
        'js',
        'patchfiles',
        done);
});

gulp.task('init', function (done) {
    runSequence(
        'clean',
        'build:create_output_dir',
        done);
});

gulp.task('watch', function () {
    var w1 = gulp.watch([
        dirs.assets+'/components/**/*.js',
        dirs.assets+'/scripts/**/*.js'
    ], ['js']);
    var w2 = gulp.watch([
        dirs.assets+'/components/**/*.less',
        dirs.assets+'/styles/**/*.less'
    ], ['css']);
});

// gulp.task('default', ['build']);
gulp.task('default', ['build']);

gulp.task('default-watch', ['build', 'watch']);
