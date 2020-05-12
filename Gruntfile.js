
/**
 * Grunt File
 *
 *
 * @package WordPress
 * @subpackage Reflexion 1.0
 * @since 2.0
 */
atomicPartsHeader = 'Include files recursively...';
module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        /* Concatenate scripts */
        concat: {
            options: {
                separator: '\n'
            },
            dist: {
                files: [{
                    src: ['assets/js/custom/_*.js', 'templates/module/**/*.js', 'assets/js/custom/main.js'],
                    dest: 'assets/js/app.js'
                }, {
                    src: ['assets/js/lib/*.js'],
                    dest: 'assets/js/lib.js'
                }],
            }
        },
        /* Compress (Uglify) compiled assets */
        uglify: {
            min: {
                files: {
                    'assets/js/app.js': ['assets/js/app.js'],
                    'assets/js/lib.js': ['assets/js/lib.js'],
                    'assets/js/module.js': ['assets/js/module.js']
                }
            }
        },
        /* SASS-Globbing allows for compiling scss files in subfolders */
        // WE will ignore bootstrap for this purpose though
        sass_globbing: {
            your_target: {
                files: {
                    'assets/scss/modules/modules.scss': 'assets/scss/modules/_*.scss',
                    'assets/scss/vendor/vendor.scss': 'assets/scss/vendor/_*.scss'
                },
                options: {
                    useSingleQuotes: true,
                    signature: '/* ' + atomicPartsHeader + ' */'
                }
            }
        },
        /* Compile styelsheets */
        sass: {
            dev: {
                options: {
                    outputStyle: 'expanded',
                    sourceMap: true
                },
                files: {
                    'assets/css/app.css': ['assets/scss/app.scss']
                }
            },
            dist: {
                options: {
                    outputStyle: 'compressed',
                    sourceMap: false
                },
                files: {
                    'assets/css/app.css': ['assets/scss/app.scss']
                }
            }
        },
        /* Make sure JS isn't poorly written */
        jshint: {
            options: {
                "node": true,
                "expr": true,
                "globals": {
                    "$": true,
                    "jquery": true,
                    "angular": false
                },
            },
            files: ['assets/js/app.js']
        },
        /* Split the CSS if IE 9 thinks there are too many selectors */
        csssplit: {
            dist: {
                src: ['assets/css/app.css'],
                dest: 'assets/css/app_ie.css',
                options: {
                    suffix: '_'
                }
            },
        },
        /* Watch certain directories/files for changes */
        watch: {
            options: {
                livereload: true
            },
            scripts: {
                files: ['assets/js/**/*.js', 'templates/module/**/module-scripts.js'],
                tasks: ['concat', 'jshint']
            },
            sass: {
                files: ['assets/scss/*.scss', 'assets/scss/**/*.scss', 'components/style-guide/scss/style-guide.scss'],
                tasks: ['sass_globbing', 'sass:dev'],
                options: {
                    outputStyle: 'expanded',
                    sourceMap: true
                }
            },
        },
    });
    /* Load NPM tasks */
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass-globbing');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-csssplit');
    grunt.loadNpmTasks('grunt-sass-globbing');
    /* Register tasks */
    grunt.registerTask('prod', ['concat', 'uglify', 'sass_globbing', 'sass']);
    grunt.registerTask('dev', ['concat', 'jshint', 'sass_globbing', 'sass:dev', 'watch']);
    /* Default task (run with "grunt" command) */
    grunt.registerTask('default', function(arg) {
        var msg = 'Running default grunt task...';
        grunt.log.writeln(msg['yellow'].bold);
        grunt.log.writeln('\nNOTE: Use "grunt debug" for dev-mode (sourcemaps, prettier code, etc..)' ['white'].white);
        grunt.task.run('prod');
    });
    /* Debug task (run with "grunt debug" command) */
    grunt.registerTask('debug', function(arg) {
        var msg = 'Running grunt in dev-mode...';
        grunt.log.writeln(msg['yellow'].bold);
        grunt.task.run('dev');
    });
};