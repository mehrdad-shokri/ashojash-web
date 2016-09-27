module.exports = {
		path: 'login',
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../../components/auth/Login'))
				});
		},
};