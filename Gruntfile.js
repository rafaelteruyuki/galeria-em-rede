module.exports = function(grunt) {
	grunt.initConfig({
		clean:{
			dist: {
				src: ['dist']
			}
		},
		copy: {
			public:{
				cwd: 'dev',
				src: ['**', '!assets/sass/**', '!assets/.sass-cache/**'],
				dest: 'dist',
				expand: true
			}
		},
		sass:{
			compilar:{
				options:{
					style: 'expanded'
				},
				files: [{
					expand: true,
					cwd: 'dev/assets/sass',
					src: ['*.scss'],
					dest: 'dev/assets/css',
					ext: '.css'
				}]
			}
		},
		watch:{
			sass:{
				options:{
					event: ['added', 'changed']
				},
				files: 'dev/assets/sass/**/*.scss',
				tasks: 'sass:compilar'
			},
			deployOnSave:{
				options:{
					event:'all'
				},
				files:'dev/**/*',
				tasks: ['dist', 'deploy']
			}
		},
		'ftp-deploy': {
			build: {
				auth: {
					host: '10.1.1.5',
					port: 21,
					authKey: 'key1'
				},
				src: 'dist',
				dest: '/galeriaemrede/wp-content/themes/galeriaemrede',
				exclusions: ['dist/**/.DS_Store', 'dist/**/Thumbs.db']
			}
		}
	});

	// Task Register
	grunt.registerTask('dist', ['clean', 'copy']);
	grunt.registerTask('deploy', ['ftp-deploy']);
	grunt.registerTask('server', ['watch']);


	// Task Loads
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-ftp-deploy');
};
