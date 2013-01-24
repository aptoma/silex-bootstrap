/**
 * Grunt configuration - http://gruntjs.com
 */


module.exports = function (grunt) {
    'use strict';

    // Project configuration.
    grunt.initConfig({
            pkg: grunt.file.readJSON('package.json'),

            // files to be used (minimatch syntax) - https://github.com/isaacs/minimatch
            files: {
                jshint: [
                    'Gruntfile.js',
                    'web/js/**/*.js'
                ],
                phplint: [
                    'app/*.php',
                    'src/*.php',
                    'tests/*.php'
                ]
            },

            dirs: {
                phpcs: [
                    'app/*.php',
                    'src',
                    'tests'
                ],
                phpmd: [
                    'src',
                    'tests'
                ],
                pdepend: [
                    'src',
                    'tests'
                ],
                phpcpd: [
                    'src',
                    'tests'
                ]
            },

            // https://github.com/gruntjs/grunt-contrib-jshint
            jshint: {
                options: {
                    jshintrc: '.jshintrc'
                },
                files: {
                    src: '<%= files.jshint %>'
                }
            },

            phplint: {
                files: {
                    src: '<%= files.phplint %>'
                }
            },

            // https://github.com/jharding/grunt-exec
            exec: {

                'mac-paths': {
                    cmd: function (options) {
                        var user = options.cli.options.user || '_www';
                        return ('mkdir -p app/cache ' +
                            '&& mkdir -p app/log ' +
                            '&& sudo chmod +a "' + user + ' allow delete,write,append,file_inherit,directory_inherit" app/cache app/log ' +
                            '&& sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/log');
                    }
                },

                // https://github.com/sebastianbergmann/phpunit/
                'phpunit': {
                    cmd: 'vendor/bin/phpunit -c phpunit.xml.dist'
                },

                // http://www.squizlabs.com/php-codesniffer
                'phpcs': {
                    cmd: function () {
                        return 'mkdir -p build/reports/php-codesniffer && vendor/bin/phpcs --report=full --report=checkstyle --tab-width=4 --report-checkstyle=build/reports/php-codesniffer/checkstyle.xml ' +
                            '--standard=PSR2 ' + grunt.config.data.dirs.phpcs.join(' ');
                    }
                },

                // http://phpmd.org/documentation/index.html
                'phpmd': {
                    cmd: function () {
                        //xml ../pmd-rules.xml --suffixes=php --reportfile ../../../build/reports/pmd/pmd.xml';
                        return 'vendor/bin/phpmd ' + grunt.config.data.dirs.phpmd.join(',') + ' text phpmd.xml --suffixes=php';
                    }
                },

                // http://pdepend.org/
                'pdepend': {
                    cmd: function () {
                        return 'mkdir -p build/reports/php-depend && vendor/bin/pdepend --jdepend-xml=build/reports/php-depend/jdepend.xml --jdepend-chart=build/reports/php-depend/dependencies.svg ' +
                            '--overview-pyramid=build/reports/php-depend/overview-pyramid.svg --coderank-mode=method --suffix=php ' + grunt.config.data.dirs.pdepend.join(',');
                    }
                },

                // https://github.com/sebastianbergmann/phpcpd
                'phpcpd': {
                    cmd: function () {
                        // TODO: get phpcpd installed with Composer and stop using the the global phpcpd command
                        return 'phpcpd --log-pmd build/reports/pmd-cpd/pmd-cpd.xml ' + grunt.config.data.dirs.phpcpd.join(' ');
                    }
                },

                // https://github.com/visionmedia/stats
                'jsloc': {
                    cmd: function () {
                        return 'node_modules/stats/bin/stats -T ' + grunt.config.data.dirs.amd.join(' ');
                    }
                },

                'composer-install': {
                    cmd: 'composer --dev install'
                },

                'npm-install': {
                    cmd: 'npm install'
                }
            }
        }
    )
    ;

    // Tasks from NPM
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Task aliases
    grunt.registerTask('mac-paths', 'Set up log and cache paths on a Mac', 'exec:mac-paths');
    grunt.registerTask('phpunit', 'PHP Unittests', 'exec:phpunit');
    grunt.registerTask('phpcs', 'PHP Codesniffer', 'exec:phpcs');
    grunt.registerTask('phpmd', 'PHP Mess Detector', 'exec:phpmd');
    grunt.registerTask('pdepend', 'PHP Depend', 'exec:pdepend');
    grunt.registerTask('phpcpd', 'Copy/Paste Detector (CPD) for PHP code', 'exec:phpcpd');
    grunt.registerTask('jsloc', 'JavaScript source statistics', 'exec:jsloc');
    grunt.registerTask('install', 'Install all project dependencies', ['exec:npm-install', 'exec:composer-install']);
    grunt.registerTask('default', ['jshint']);
    grunt.registerTask('jenkins', ['phpunit', 'phpcs', 'phpmd']);
}
;
