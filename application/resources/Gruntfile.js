/*global module:false*/

module.exports = function(grunt) {
  "use strict";

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),

    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) Qihoo 360 <%= grunt.template.today("yyyy") %>; */\n',

    // Task configuration.
    watch: {
      options: {
        livereload: false
      },
      gurntfile: {
        files: 'Gruntfile.js',
        tasks: ['jshint:gruntfile']
      },
      less: {
        files: ['src/css/**/*.less'],
        tasks: ['less:dev', 'copy:deploy']
      },
      javascript: {
        files: ['src/js/*'],
        tasks: ['concat:dev','copy:build','copy:deploy']
      }
    },

    clean: ['dist'],

    copy: {
      build: {
        files: [
          { expand: true, cwd: 'src/', src: '*.{ico,txt}', dest: 'dist/' },
          { src: 'bower_components/modernizr/modernizr.js', dest: 'dist/js/modernizr.js' },
          { src: 'bower_components/requirejs/require.js', dest: 'dist/js/require.js' },
          { src: 'bower_components/jquery/jquery.js', dest: 'dist/js/jquery.js' },
          { src: 'bower_components/jquery-ui/jquery-ui.js', dest: 'dist/js/jquery-ui.js' },
          { src: 'bower_components/underscore/underscore.js', dest: 'dist/js/underscore.js' },
          { src: 'bower_components/bootstrap/js/bootstrap-modal.js', dest: 'dist/js/bootstrap-modal.js' },
          { expand: true, cwd: 'bower_components/bootstrap/js/', src: ['fonts/**'], dest: 'dist/' },
          { expand: true, cwd: 'bower_components/bootstrap/', src: ['img/**' , 'js/*'], dest: 'dist/' },
          { expand: true, cwd: 'bower_components/jquery-ui/themes/redmond', src: ['**'], dest: 'dist/css' },
          { expand: true, cwd: 'src/', src: ['fonts/**'], dest: 'dist/' },
          { expand: true, cwd: 'src/', src: ['js/*'], dest: 'dist/' },
          { expand: true, cwd: 'src/', src: ['js/*'], dest: 'dist/' },
          { expand: true, cwd: 'bower_components/bootstrap/', src: ['img/*'], dest: 'dist/' }
        ]
      },
      deploy: {
        files: [
          { expand: true, cwd: 'dist/', src: '**/*', dest: '../../public/' }
        ]
      }
    },

    less: {
      options: {
        paths: ['bower_components']
      },
      dev: {
        options: {},
        files: {
          'dist/css/bootstrap.css': ['src/css/bootstrap/bootstrap.less'],
          'dist/css/app.css': ['src/css/app.less']
        }
      },
      release: {
        options: {
          cleancss: true,
          report: 'min'
        },
        files: {
          'dist/css/bootstrap.css': ['src/css/bootstrap/bootstrap.less'],
          'dist/css/app.css': ['src/css/app.less']
        }
      }
    },

    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dev: {
        files: {
          'dist/js/bootstrap.js': [
            'bower_components/bootstrap/js/bootstrap-transition.js',
            'bower_components/bootstrap/js/bootstrap-dropdown.js',
            'bower_components/bootstrap/js/bootstrap-button.js',
            'bower_components/bootstrap/js/bootstrap-modal.js'
          ],
          'dist/js/app.js': [
            'src/js/app.js'
          ]
        }
      },
      release: {
        files: {
          'dist/js/bootstrap.js': [
            'bower_components/bootstrap/js/bootstrap-transition.js',
            'bower_components/bootstrap/js/bootstrap-dropdown.js',
            'bower_components/bootstrap/js/bootstrap-button.js',
            'bower_components/bootstrap/js/bootstrap-modal.js'
          ],
          'dist/js/app.js': ['src/js/app.js']
        }
      }
    },

    uglify: {
      options: {
        banner: '<%= banner %>',
        mangle: {
          except: []
        },
        preserveComments: false
      },
      app: {
        files: {
          'dist/js/modernizr.js': 'dist/js/modernizr.js',
          'dist/js/underscore.js': 'dist/js/underscore.js',
          'dist/js/bootstrap.js': 'dist/js/bootstrap.js',
          'dist/js/app.js': 'dist/js/app.js'
        }
      }
    }

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');

  // Default task.
  grunt.registerTask('default', ['clean', 'copy:build', 'less:dev', 'concat:dev', 'copy:deploy']);
  grunt.registerTask('release', ['clean', 'copy:build', 'less:release', 'concat:release', 'uglify', 'copy:deploy']);

};
