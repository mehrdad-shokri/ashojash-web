module.exports = {
		path: 'new',
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../../../components/panel/collections/createCollection/CreateCollection'))
				});
		},
};