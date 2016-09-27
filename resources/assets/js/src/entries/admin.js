import React from 'react';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import {Router, browserHistory} from 'react-router';
import reducers from '../reducers';
import routes from '../routes';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import injectTapEventPlugin from 'react-tap-event-plugin';
import {teal500, tealA400} from 'material-ui/styles/colors';
import reduxThunk from 'redux-thunk';
require('css-skeleton');
require('../../../sass/shared/fonts.scss');
require('../../../sass/shared/styles.scss');

const createStoreWithMiddleware = applyMiddleware(reduxThunk)(createStore);
const store = createStoreWithMiddleware(reducers);

injectTapEventPlugin();
const muiTheme = getMuiTheme({
		timePicker: {
				accentColor: tealA400,
				headerColor: teal500
		},
		datePicker: {
				selectColor: teal500
		},
		isRtl: true,
		fontFamily: 'nazanin'
});
ReactDOM.render(
		<MuiThemeProvider muiTheme={muiTheme}>
				<Provider store={store}>
						<Router history={browserHistory} routes={routes}/>
				</Provider>
		</MuiThemeProvider>
		, document.getElementById('appContainer'));
