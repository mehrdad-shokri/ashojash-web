module.exports = {
		path: 'error',
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../../components/errors/Error'))
				});
		},
		path: '*',
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../../components/errors/Error'))
				});
		},
}