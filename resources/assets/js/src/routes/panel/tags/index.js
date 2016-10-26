module.exports = {
		path: 'tags',
		getIndexRoute(location, cb){
				require.ensure([], ()=> {
						const collections = require('../../../components/panel/tags/Tags');
						cb(null, {component: collections});
				})
		}
};