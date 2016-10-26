module.exports = {
		path: 'collections',
		getIndexRoute(location, cb){
				require.ensure([], ()=> {
						const collections = require('../../../components/panel/collections/Collections');
						cb(null, {component: collections});
				})
		},
		getChildRoutes(location, cb){
				require.ensure([], ()=> {
						cb(null, [
								require('./createCollection')
						])
				})
		}
};