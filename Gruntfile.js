/**
 * - Installare Node.js
 * - Installare grunt: "npm install -g grunt-cli"
 *
 * Nel progetto:
 * - "npm install"
 * - "grunt" o "grunt build"
 */
module.exports = function( grunt ) {
	grunt.initConfig( {
		pkg: grunt.file.readJSON( "package.json" ),
		sass: {
			options: {
				loadPath: require( "node-bourbon" ).includePaths,
				style: "compressed"
			},
			dist: {
				files: {
					"assets/css/admin.css" : "assets/css/scss/admin.scss"
				}
			}
		},
		uglify: {
			dist: {
				files: {
					"assets/js/min/admin.min.js": [
						"assets/js/admin.js"
					]
				}
			}
		},
		notify_hooks: {
			options: {
				enabled: true,
				max_jshint_notifications: 3
			}
		},
		notify: {
			watch: {
				options: {
					message: "OK",
				}
			}
		},
		watch: {
			css: {
				files: [ "assets/css/scss/*.scss" ],
				tasks: [ "sass", "notify" ]
			},
			js: {
				files: "assets/js/*.js",
				tasks: [ "uglify", "notify" ]
			}
		}
	} );

	grunt.loadNpmTasks( "grunt-contrib-sass" );
	grunt.loadNpmTasks( "grunt-contrib-watch" );
	grunt.loadNpmTasks( "grunt-contrib-uglify" );
	// grunt.loadNpmTasks( "grunt-contrib-concat" );
	// grunt.loadNpmTasks( "grunt-string-replace" );
	grunt.loadNpmTasks( "grunt-contrib-csslint" );
	grunt.loadNpmTasks( "grunt-notify" );

	grunt.task.run( "notify_hooks" );

	grunt.registerTask( "default", [ "watch" ] );
	grunt.registerTask( "build", [ "sass", "uglify", "notify" ] );
};