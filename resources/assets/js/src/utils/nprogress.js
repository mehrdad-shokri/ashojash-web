var NProgress = require('nprogress');

var ProgressMixin = {
		componentWillMount: function() {
				NProgress.start();
		},

		componentDidMount: function() {
				NProgress.done();
		}
};