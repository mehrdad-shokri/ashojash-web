module.exports = {
		path: 'tag',
		getIndexRoute(location, cb){
				require.ensure([], ()=> {
						const collections = require('../../../components/panel/tags/Tags');
						cb(null, {component: collections});
				})
		},
		getChildRoutes(location, cb){
				require.ensure([], ()=> {
						cb(null, [
								require('./createTag')
						])
				})
		}
};