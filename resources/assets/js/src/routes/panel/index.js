module.exports = {
    path: 'panel',
    getComponent(nextState, cb){
        require.ensure([], ()=> {
            const requireAuthWithPermission = require('../../components/hoc/RequireAuthWithPermission');
            const panel = require('../../components/hoc/Panel');
            cb(null, requireAuthWithPermission(panel, ['manage-collection']));
        });
    },
    getIndexRoute(location, cb){
        require.ensure([], ()=> {
            const home = require('../../components/panel/Home');
            cb(null, {component: home});
        });
    },
    getChildRoutes(location, cb)
    {
        require.ensure([], ()=> {
            cb(null, [
                require('./collections'),
                require('./tags')
            ])
        })
    }
};