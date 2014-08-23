module.exports = function(grunt) {

    grunt.initConfig({

        locales: {
            pt: 'pt'
        },
        vars: {
            jqueryUiTheme: 'ui-lightness',
            datepickerLocales: function(prepend, append){
                return Object.keys(grunt.config.process('<%= locales %>')).map(function(locale) {
                    return prepend+locale+append;
                });
            }
        },
        jshint: {
            files: [
                'Gruntfile.js'
            ],
            options: {
                loopfunc: true,
                globals: {
                    jQuery: true,
                    console: true,
                    module: true,
                    document: true
                }
            }
        },
        concat : {
            options : {
                separator: ';' // If CSS, cleancss will remove it
            },
            update : {
                files : [
                {
                    src : [
                        'bower_components/jquery-ui/ui/core.js',
                        'bower_components/jquery-ui/ui/datepicker.js',
                    ],
                    dest : 'src/assets/js/libs/datepicker/en.js'
                }
                ]
            },
            i18n : {
                files : [
                {
                    src  : [
                        'src/assets/js/libs/datepicker/en.js',
                        '<%= vars.datepickerLocales("src/assets/js/libs/datepicker/", ".js") %>'
                    ],
                    dest : '<%= vars.datepickerLocales("src/assets/js/libs/datepicker/", ".js") %>'
                }
                ]
            }
        },
        copy : {
            update : {
                files: [
                {
                    expand: true,
                    cwd: 'bower_components/jquery-ui/themes/<%= vars.jqueryUiTheme %>/images/',
                    src: '**',
                    dest: 'public/media/img/libs/jqueryui/',
                    flatten: true,
                    filter: 'isFile',
                },
                {
                    src: '<%= vars.datepickerLocales("bower_components/jquery-ui/ui/i18n/datepicker-", ".js") %>',
                    dest: '<%= vars.datepickerLocales("src/assets/temp/", ".js") %>'
                },
                {
                    src: 'bower_components/jquery-ui/themes/<%= vars.jqueryUiTheme %>/theme.css',
                    dest: 'src/assets/temp/jquery-ui.less',
                },
                {
                    src: 'bower_components/respond/src/respond.js',
                    dest: 'src/assets/js/libs/respond.js',
                },
                {
                    expand: true,
                    cwd: 'bower_components/tinymce/',
                    src: '**',
                    dest: 'public/js/libs/tinymce/',
                    flatten: false,
                    filter: 'isFile',
                }
                ]
            },
            i18n : {
                files: [
                {
                    expand: true,
                    cwd: 'src/assets/temp',
                    src: '<%= vars.datepickerLocales("", ".js") %>',
                    dest: 'src/assets/js/libs/datepicker',
                    ext: '.js',
                    rename: function(base, src) {
                        src = src.replace(/\.js/, '');
                        return base+'/'+grunt.config.process('<%= locales %>')[src]+'.js';
                    }
                },
                ]
            }
        },
        replace: {
            update_jqueryui: {
                src: 'src/assets/temp/jquery-ui.less',
                dest: 'src/assets/temp/jquery-ui.less',
                replacements: [{
                    from: 'url(images/',
                    to: 'url(../../media/img/libs/jqueryui/'
                }]
            }
        },
        uglify: {
            options: {
                mangle: true,
                compress: true,
                beautify: false,
            },
            all: {
                files: [
                {
                    expand: true,
                    cwd: 'src/assets/js',
                    src: [
                        '**/*.js',
                        '!**/*.min.js'
                    ],
                    dest: 'public/js',
                    ext: '.min.js',
                    flatten: false,
                    filter: 'isFile'
                }
                ]
            }
        },
        less: {
            all: {
                options: {
                    cleancss: true
                },
                files: [
                {
                    expand: true,
                    cwd: 'src/assets/less',
                    src: '**/*.less',
                    dest: 'public/css',
                    ext: '.css',
                    flatten: false,
                    filter: 'isFile'
                }
                ]
            },
            update: {
                files: [
                {src: ['src/assets/temp/jquery-ui.less'], dest: 'src/assets/less/libs/jquery-ui.less'},
                ]
            }
        },
        clean : {
            update : {
                src : ["src/assets/temp"],
            }
        },
        watch: {
            less: {
                files: ['src/assets/less/**/*.less'],
                tasks: ['less:all'],
            },
            js: {
                files: [
                    'src/assets/js/**/*.js',
                    '!src/assets/js/**/*.min.js'
                ],
                tasks: ['concat', 'uglify:all'],
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-text-replace');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');
    
    grunt.registerTask('default', function() {
        grunt.task.run([
            'jshint',
            'concat',
            'uglify:all',
            'less:all'
        ]);
    });
    
    grunt.registerTask('update', 'Task to run after updating components with Bower', function() {
        grunt.task.run([
            'concat:update',
            'copy:update',
            'copy:i18n',
            'concat:i18n',
            'replace:update_jqueryui',
            'less:update',
            'clean:update'
        ]);
        grunt.task.run('default');
    });
};
