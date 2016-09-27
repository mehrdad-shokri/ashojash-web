module.exports = {
		path: 'auth',
		getIndexRoute(nextState, cb){
				require.ensure([], ()=> {
						cb(null, {component: require('../../components/errors/Error')})
				});
		},
		getChildRoutes(partialNextState, cb)
		{
				require.ensure([], ()=> {
						cb(null, [
								require('./signin'),
								// require('./register'),
						]);
				})
		}
		/*getComponent(location, cb){
		 require.ensure([], ()=> {
		 cb(null, require('../../components/Collections'))
		 });
		 },*/
}