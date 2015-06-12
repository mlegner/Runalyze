module.exports = function (grunt) {
    // JS FILES VAR FOR BUILD AND DEV TASK
    var jsFiles = {
                    "web/assets/js/runalyze.js": [
                        "web/vendor/jquery/dist/jquery.js",

                        "lib/jquery.form.js",
                        "lib/jquery.metadata.js",
                        "lib/jquery.tablesorter-2.18.4.js",
                        "lib/jquery.tablesorter-2.18.4.pager.js",
                        "lib/bootstrap-tooltip.js",

                        "lib/fineuploader-3.5.0.min.js",

                        "lib/jquery.datepicker.js",

                        "lib/jquery.chosen.min.js",

                        "lib/runalyze.lib.js",
                        "lib/runalyze.lib.plot.js",
                        "lib/runalyze.lib.plot.options.js",
                        "lib/runalyze.lib.plot.saver.js",
                        "lib/runalyze.lib.plot.events.js",
                        "lib/runalyze.lib.tablesorter.js",
                        "lib/runalyze.lib.log.js",
                        "lib/runalyze.lib.options.js",
                        "lib/runalyze.lib.config.js",
                        "lib/runalyze.lib.overlay.js",
                        "lib/runalyze.lib.panels.js",
                        "lib/runalyze.lib.databrowser.js",
                        "lib/runalyze.lib.statistics.js",
                        "lib/runalyze.lib.training.js",
                        "lib/runalyze.lib.feature.js",

                        "lib/flot-0.8.3/base64.js",

                        "lib/flot-0.8.3/jquery.flot.min.js",
                        "lib/flot-0.8.3/jquery.flot.resize.min.js",
                        "lib/flot-0.8.3/jquery.flot.selection.js",
                        "lib/flot-0.8.3/jquery.flot.crosshair.js",
                        "lib/flot-0.8.3/jquery.flot.navigate.min.js",
                        "lib/flot-0.8.3/jquery.flot.hiddengraphs.js",
                        "lib/flot-0.8.3/jquery.flot.stack.js",
                        "lib/flot-0.8.3/jquery.flot.textLegend.js",
                        "lib/flot-0.8.3/jquery.flot.orderBars.js",
                        "lib/flot-0.8.3/jquery.flot.canvas.js",
                        "lib/flot-0.8.3/jquery.flot.time.min.js",
                        "lib/flot-0.8.3/jquery.flot.curvedLines.js",

                        "web/vendor/leaflet/dist/leaflet.js",
                        "lib/leaflet/runalyze.leaflet.js",
                        "lib/leaflet/runalyze.leaflet.layers.js",
                        "lib/leaflet/runalyze.leaflet.routes.js",

                        "web/vendor/fontIconPicker/jquery.fonticonpicker.js",
                        
                        "web/vendor/foundation/js/foundation.min.js",
                        "web/vendor/foundation/js/foundation/foundation.magellan.js",
                        
                        "web/resources/js/main.js"
                    ],
                    "web/assets/js/libs/modernizr.min.js": [
                        "web/vendor/modernizr/modernizr.js"
                    ]
                };
    
    
    
    // read in assets from configuration
    // var assets = grunt.file.readJSON('assets.json');

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
        
        /* compiles .scss files */
        sass: {
            options: {
                includePaths: ['web/vendor/foundation/scss']
            },
            dist: {
                options: {
                  outputStyle: 'compressed',
                  sourceMap: true,
                },
                files: {
                  'web/assets/css/app.css': 'web/resources/scss/app.scss'
                }
            }
        },

//        uglify: {
//            options: {
//                report: 'min',
//                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
//            },
//            build: {
//                files: loadAssets(assets.js)
//            }
//        },
        
        
        uglify: {
            dev: {
                options: {
                    beautify: true,
                    compress: false
                },
                
                files: jsFiles
            },
            build: {
                options: {
                    beautify: false,
                    compress: true
                },
                
                files: jsFiles
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
        
        copy: {
            main: {
                files:[
                    {
                        cwd: 'web/resources/images',  // set working folder / root to copy
                        src: '**/*',           // copy all files and subfolders
                        dest: 'web/assets/images',    // destination folder
                        expand: true           // required when using cwd
                      }
                    
                ],
            },
        },
        
        watch: {
          grunt: {
            options: {
              reload: true
            },
            files: ['gruntfile.js']
          },
            
          uglify: {
            files: 'web/resources/js/**/*.js',
            tasks: ['uglify:dev']
          },

          sass: {
            files: 'web/resources/scss/**/*.scss',
            tasks: ['sass']
          }
        },

        clean: ['web/_static/*']
    });
    
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-copy');
    
    grunt.registerTask('dev', ['clean', 'less', 'sass','uglify:dev', 'copy']);
    grunt.registerTask('build', ['clean', 'less', 'sass','uglify:build', 'copy']);
    grunt.registerTask('default', ['dev','watch']);
    
    
};