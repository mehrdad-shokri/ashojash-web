import {combineReducers} from 'redux';
import {reducer as form} from 'redux-form';
import auth from './auth_reducer';
import collections from './collections_reducer';
import modals from './modal_reducer';
const rootReducer = combineReducers({
		form,
		auth,
		collections,
		modals
});

export default rootReducer;
