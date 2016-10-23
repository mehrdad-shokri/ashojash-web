module.exports = {
		path: ':slug',
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../../../components/panel/venues/Venue/Venue'))
				});
		},
};