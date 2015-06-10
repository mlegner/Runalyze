module.exports = function (grunt) {
    // read in assets from configuration
    var assets = grunt.file.readJSON('assets.json');

    // prefix assets with 'web/'
    var loadAssets = function(config) {
        var ret = {};
        var dest = config.prod; //'web/' + config.prod;
        var files = [];

        config.dev.forEach(function(val) {
            files.push(val); //'web/' + val);
        });

        ret[dest] = files;

        return ret;
    };

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        uglify: {
            options: {
                report: 'min',
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                files: loadAssets(assets.js)
            }
        },

        less: {
            dev: {
                options: {
                    compile: true,
                    relativeUrls: true,
                    rootpath: "../../lib/less/"
                },
                files: {
                    "web/_static/runalyze.css": [
                        "lib/less/runalyze-style.less"
                    ]
                }
            },
            dist: {
                options: {
                    compile: true,
                    relativeUrls: true,
                    rootpath: "../../lib/less/",
                    compress: true,
                    cleancss: true
                },
                files: {
                    "web/_static/runalyze.min.css": [
                        "lib/less/runalyze-style.less"
                    ]
                }

            }
        },

        clean: ['web/_static/*']
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-clean');

    grunt.registerTask('default', ['clean', 'uglify', 'less']);
};