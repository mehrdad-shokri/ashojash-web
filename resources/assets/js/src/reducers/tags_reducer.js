import {
		STORE_TAG,
		TAGS_RESPONSE,
		TAGS_REQUEST,
		STORING_TAG,
		TAG_ERROR,
		RESET_TAG_STATUS
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		isRequesting: false,
		tags: null,
		hasTags: false,
		hasError: false,
		isCreatingTag: false,
		createdTag: false,
		errorMessage: null
};

export default createReducer(initialState, {
		[TAGS_REQUEST]: (state, payload)=> {
				return {...state, isRequesting: true, hasError: false}
		},
		[TAGS_RESPONSE]: (state, payload)=> {
				return {...state, isRequesting: false, hasTags: true, tags: payload, hasError: false}
		},
		[TAG_ERROR]: (state, payload)=> {
				return {...state, isCreatingTag: false, isRequesting: false, hasError: true, errorMessage: payload}
		},
		[STORING_TAG]: (state, payload)=> {
				return {...state, isCreatingTag: true, createdTag: false, hasError: false}
		},
		[STORE_TAG]: (state, payload)=> {
				return {...state, isCreatingTag: false, createdTag: true, hasError: false}
		},
		[RESET_TAG_STATUS]: (state, payload)=> {
				return {
						...state,
						createdTag: false,
						hasError: false,
						isRequesting: false,
						isCreatingTag: false,
						errorMessage: null
				}
		}
});