module.exports = {
		path: 'venues',
		getIndexRoute(location, cb){
				require.ensure([], ()=> {
						const venues = require('../../../components/panel/venues/Venues');
						cb(null, {component: venues});
				})
		}
};