import React from 'react';
import Entry from '../components/Entry';
import AuthWithPermission from '../components/hoc/RequireAuthWithPermission';
const rootRoute = {
		path: 'admin',
		indexRoute: {component: AuthWithPermission(Entry, ['see-admin-panel'])},
		getComponent(nextState, cb){
				require.ensure([], ()=> {
						cb(null, require('../components/App'))
				});
		},
		getChildRoutes(partialNextState, cb)
		{
				require.ensure([], ()=> {
						cb(null, [
								require('./panel'),
								require('./auth'),
								require('./errors')
						]);
				})
		}
};
export default rootRoute;
