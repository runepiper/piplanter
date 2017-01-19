
module.exports = function(grunt) {
    // configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        jshint: {
            options: {
                'jshintrc': true
            },
            files: [
                'Gruntfile.js',
                'assets/javascripts/source/*.js'
            ]
        },
        uglify: {
            target: {
                files: {
                    'assets/javascripts/combined.min.js': [
                        'assets/javascripts/source/*.js'
                    ]
                }
            }
        },
        sass: {
            target: {
                files: {
                    'assets/stylesheets/combined.min.css': [
                        'assets/stylesheets/styles.scss'
                    ],
                    'assets/stylesheets/above-the-fold.min.css': [
                        'assets/stylesheets/above-the-fold.scss'
                    ]
                }
            }
        },
        autoprefixer: {
            target: {
                files: {
                    'assets/stylesheets/combined.min.css': [
                        'assets/stylesheets/combined.min.css'
                    ],
                    'assets/stylesheets/above-the-fold.min.css': [
                        'assets/stylesheets/above-the-fold.min.css'
                    ]
                }
            }
        },
        cssmin: {
            target: {
                files: {
                    'assets/stylesheets/combined.min.css': [
                        'assets/stylesheets/combined.min.css'
                    ],
                    'assets/stylesheets/above-the-fold.min.css': [
                        'assets/stylesheets/above-the-fold.min.css'
                    ]
                }
            }
        },
        watch: {
            styleSheets: {
                options: {
                    spawn: false
                },
                files: [
                    'assets/stylesheets/**/*.scss'
                ],
                tasks: [
                    'sass',
                    'autoprefixer',
                    'cssmin'
                ],
            },
            javaScripts: {
                options: {
                    spawn: false
                },
                files: [
                    'assets/javascripts/**/*.js'
                ],
                tasks: [
                    'jshint',
                    'uglify'
                ]
            }
        }
    });

    // load plugins
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    // default task
    grunt.registerTask('default', ['jshint', 'uglify', 'sass', 'autoprefixer', 'cssmin']);
};
