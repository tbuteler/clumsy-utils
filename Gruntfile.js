module.exports = function(grunt) {

    grunt.initConfig({

        locales: {
            pt: 'pt'
        },
        vars: {
            jqueryUiTheme: 'ui-lightness',
            uiLocales: function(prepend, append){
                return Object.keys(grunt.config.process('<%= locales %>')).map(function(locale) {
                    return prepend+locale+append;
                });
            }
        },
        jshint: {
            files: [
                'Gruntfile.js',
                'src/assets/js/*.js',
                '!src/assets/js/chosen.js',
                '!src/assets/js/iris.js',
                '!src/assets/js/vue.js',
                '!src/assets/js/sweetalert.js'
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
                    dest : 'src/assets/js/datepicker/en.js'
                },
                {
                    src : [
                        'bower_components/jquery-ui/themes/<%= vars.jqueryUiTheme %>/jquery-ui.css',
                        'bower_components/jquery-ui/themes/<%= vars.jqueryUiTheme %>/theme.css',
                    ],
                    dest : 'src/assets/temp/jquery-ui.less'
                },
                {
                    src : [
                        'bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.js',
                        'bower_components/jqueryui-timepicker-addon/dist/jquery-ui-sliderAccess.js',
                    ],
                    dest : 'src/assets/js/timepicker/en.js'
                }
                ]
            },
            i18n : {
                files : [
                {
                    src  : [
                        'src/assets/js/datepicker/en.js',
                        '<%= vars.uiLocales("src/assets/js/datepicker/", ".js") %>'
                    ],
                    dest : '<%= vars.uiLocales("src/assets/js/datepicker/", ".js") %>'
                },
                {
                    src  : [
                        'src/assets/js/timepicker/en.js',
                        '<%= vars.uiLocales("src/assets/js/timepicker/", ".js") %>'
                    ],
                    dest : '<%= vars.uiLocales("src/assets/js/timepicker/", ".js") %>'
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
                    dest: 'public/media/img/jqueryui/',
                    flatten: true,
                    filter: 'isFile'
                },
                {
                    src: '<%= vars.uiLocales("bower_components/jquery-ui/ui/i18n/datepicker-", ".js") %>',
                    dest: '<%= vars.uiLocales("src/assets/temp/datepicker/", ".js") %>'
                },
                {
                    src: '<%= vars.uiLocales("bower_components/jqueryui-timepicker-addon/src/i18n/jquery-ui-timepicker-", ".js") %>',
                    dest: '<%= vars.uiLocales("src/assets/temp/timepicker/", ".js") %>'
                },
                {
                    src: 'bower_components/jqueryui-timepicker-addon/src/jquery-ui-timepicker-addon.css',
                    dest: 'src/assets/less/timepicker.less'
                },
                {
                    src: 'bower_components/chosen/chosen.jquery.min.js',
                    dest: 'src/assets/js/chosen.js'
                },
                {
                    src: 'bower_components/chosen/chosen.min.css',
                    dest: 'src/assets/less/chosen.less'
                },
                {
                    expand: true,
                    src: ['bower_components/chosen/*.png'],
                    dest: 'public/media/img/chosen/',
                    filter: 'isFile',
                    flatten: true
                },
                {
                    src: 'bower_components/iris-color-picker/dist/iris.js',
                    dest: 'src/assets/js/iris.js'
                },
                {
                    src: 'bower_components/iris-color-picker/src/iris.css',
                    dest: 'src/assets/less/iris.less'
                },
                {
                    src: 'bower_components/vue/dist/vue.js',
                    dest: 'src/assets/js/vue.js'
                },
                {
                    // Add a non-minified version of Vue for local development
                    src: 'bower_components/vue/dist/vue.js',
                    dest: 'public/js/vue.js'
                },
                {
                    src: 'node_modules/sweetalert/dist/sweetalert.css',
                    dest: 'public/css/sweetalert.css'
                },
                {
                    src: 'node_modules/sweetalert/dist/sweetalert-dev.js',
                    dest: 'src/assets/js/sweetalert.js'
                }
                ]
            },
            i18n : {
                files: [
                {
                    expand: true,
                    cwd: 'src/assets/temp/datepicker',
                    src: '<%= vars.uiLocales("", ".js") %>',
                    dest: 'src/assets/js/datepicker',
                    ext: '.js',
                    rename: function(base, src) {
                        src = src.replace(/\.js/, '');
                        return base+'/'+grunt.config.process('<%= locales %>')[src]+'.js';
                    }
                },
                {
                    expand: true,
                    cwd: 'src/assets/temp/timepicker',
                    src: '<%= vars.uiLocales("", ".js") %>',
                    dest: 'src/assets/js/timepicker',
                    ext: '.js',
                    rename: function(base, src) {
                        src = src.replace(/\.js/, '');
                        return base+'/'+grunt.config.process('<%= locales %>')[src]+'.js';
                    }
                }
                ]
            }
        },
        replace: {
            update_jqueryui: {
                src: 'src/assets/temp/jquery-ui.less',
                dest: 'src/assets/less/jquery-ui.less',
                replacements: [{
                    from: 'url("images/',
                    to: 'url("../media/img/jqueryui/'
                }]
            },
            update_chosen: {
                src: 'src/assets/less/chosen.less',
                dest: 'src/assets/less/chosen.less',
                replacements: [{
                    from: "url(chosen-sprite",
                    to: "url(../media/img/chosen/chosen-sprite"
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
                    cleancss: true,
                    compress: true
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
            }
        },
        clean : {
            update : {
                src : ["src/assets/temp"],
            }
        },
        shell: {
            test: {
                options: {
                    stdout: true
                },
                command: 'phpunit'
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
            },
            php: {
                files: [
                    'src/**/*.php',
                    'tests/**/*.php'
                ],
                tasks: ['shell:test'],
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
    grunt.loadNpmTasks('grunt-shell');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', function() {
        grunt.task.run([
            'jshint',
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
            'replace:update_chosen',
            'clean:update'
        ]);
        grunt.task.run('default');
    });
};
