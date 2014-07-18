/**
 * Grunt configuration - http://gruntjs.com
 */


module.exports = function (grunt) {
    'use strict';
    require('time-grunt')(grunt);

    // Project configuration.
    grunt.initConfig({
            pkg: grunt.file.readJSON('package.json'),

            // files to be used (minimatch syntax) - https://github.com/isaacs/minimatch
            files: {
                jshint: [
                    'Gruntfile.js',
                    'web/js/**/*.js'
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

            // https://github.com/jharding/grunt-exec
            exec: {

                'mac-paths': {
                    cmd: function (user) {
                        user = user || '_www';
                        return ('mkdir -p app/cache ' +
                            '&& mkdir -p app/log ' +
                            '&& sudo chmod +a "' + user + ' allow delete,write,append,file_inherit,directory_inherit" app/cache app/log ' +
                            '&& sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/log');
                    }
                },
                'ubuntu-paths': {
                    cmd: function (user) {
                        user = user || 'www-data';
                        return ('mkdir -p app/cache ' +
                            '&& mkdir -p app/log ' +
                            '&& sudo setfacl -R -m u:'+user+':rwx -m u:`whoami`:rwx app/cache app/log ' +
                            '&& sudo setfacl -dR -m u:'+user+':rwx -m u:`whoami`:rwx app/cache app/log ');
                    }
                },
                // https://github.com/sebastianbergmann/phpunit/
                'phpunit': {
                    cmd: 'vendor/bin/phpunit -c phpunit.xml.dist'
                },

                'phpunit-ci': {
                    cmd: 'vendor/bin/phpunit -c phpunit.xml.dist ' +
                        '--coverage-html build/coverage ' +
                        '--coverage-clover build/logs/clover.xml ' +
                        '--log-junit build/logs/junit.xml'
                },

                'phpunit-travis': {
                    cmd: 'vendor/bin/phpunit --coverage-clover build/logs/clover.xml'
                },

                // http://www.squizlabs.com/php-codesniffer
                'phpcs': {
                    cmd: function () {
                        return 'mkdir -p build/reports && vendor/bin/phpcs --report=full --report=checkstyle --report-checkstyle=build/reports/checkstyle.xml ' +
                            '--standard=PSR2 --extensions=php ' + grunt.config.data.dirs.phpcs.join(' ');
                    }
                },

                'phpcs-travis': {
                    cmd: function () {
                        return 'vendor/bin/phpcs --standard=PSR2 --extensions=php ' + grunt.config.data.dirs.phpcs.join(' ');
                    }
                },

                // http://phpmd.org/documentation/index.html
                'phpmd': {
                    cmd: function () {
                        return 'vendor/bin/phpmd ' + grunt.config.data.dirs.phpmd.join(',') + ' text phpmd.xml --suffixes=php';
                    }
                },

                'phpmd-ci': {
                    cmd: function () {
                        return 'mkdir -p build/reports && vendor/bin/phpmd ' + grunt.config.data.dirs.phpmd.join(',') + ' xml phpmd.xml --suffixes=php --reportfile build/reports/phpmd.xml';
                    }
                },

                'composer-install': {
                    cmd: 'composer --dev install'
                },

                'ci-prepare': {
                    cmd: 'curl -s https://getcomposer.org/installer | php' +
                        '&& php composer.phar --dev install' +
                        '&& rm composer.phar ' +
                        '&& mkdir -p app/log ' +
                        '&& mkdir -p app/cache ' +
                        '&& rm -rf app/cache/*'
                },

                'npm-install': {
                    cmd: 'npm install'
                },

                'bundle-install': {
                    cmd: 'bundle install'
                }
            }
        }
    )
    ;

    // Tasks from NPM
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Task aliases
    grunt.registerTask('ubuntu-paths', 'Set up log and cache paths on a Mac', 'exec:ubuntu-paths');
    grunt.registerTask('mac-paths', 'Set up log and cache paths on a Mac', 'exec:mac-paths');
    grunt.registerTask('phpunit', 'PHP Unittests', 'exec:phpunit');
    grunt.registerTask('phpunit-ci', 'PHP Unittests for CI', 'exec:phpunit-ci');
    grunt.registerTask('phpcs', 'PHP Codesniffer', 'exec:phpcs');
    grunt.registerTask('phpmd', 'PHP Mess Detector', 'exec:phpmd');
    grunt.registerTask('install', 'Install all project dependencies', ['exec:npm-install', 'exec:composer-install', 'exec:bundle-install']);
    grunt.registerTask('default', ['qa']);
    grunt.registerTask('qa', ['phpunit', 'phpcs', 'phpmd']);
    grunt.registerTask('jenkins', ['exec:ci-prepare', 'phpunit-ci', 'phpcs', 'exec:phpmd-ci']);
    grunt.registerTask('travis', ['exec:composer-install', 'exec:phpunit-travis', 'exec:phpcs-travis', 'phpmd']);
}
;
