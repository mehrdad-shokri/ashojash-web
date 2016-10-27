import {combineReducers} from 'redux';
import {reducer as form} from 'redux-form';
import auth from './auth_reducer';
import collections from './collections_reducer';
import modals from './modal_reducer';
import tags from './tags_reducer';
import venues from './venues_reducer';
const rootReducer = combineReducers({
		form,
		auth,
		collections,
		tags,
		venues,
		modals
});

export default rootReducer;
