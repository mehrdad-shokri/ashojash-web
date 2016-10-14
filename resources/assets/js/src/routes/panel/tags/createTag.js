module.exports = {
		path: 'tag',
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../../../components/panel/tags/CreateTag'))
				});
		},
};