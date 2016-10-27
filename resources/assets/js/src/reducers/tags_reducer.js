import {
		STORE_TAG,
		TAGS_RESPONSE,
		TAGS_REQUEST,
		STORING_TAG,
		TAG_MESSAGE,
		RESET_TAG_STATUS,
		UPLOADING_TAG_PHOTO,
		TAG_PHOTO_UPLOADED
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		isRequesting: false,
		tags: null,
		hasTags: false,
		hasMessage: false,
		isCreatingTag: false,
		createdTag: false,
		message: null,
		uploadingTagPhoto: false,
		uploadedTagPhoto: false,
};

export default createReducer(initialState, {
		[TAGS_REQUEST]: (state, payload)=> {
				return {...state, isRequesting: true, hasMessage: false}
		},
		[TAGS_RESPONSE]: (state, payload)=> {
				return {...state, isRequesting: false, hasTags: true, tags: payload, hasMessage: false}
		},
		[TAG_MESSAGE]: (state, payload)=> {
				return {
						...state,
						isCreatingTag: false,
						isRequesting: false,
						hasMessage: true,
						message: payload,
						uploadingTagPhoto: false
				}
		},
		[STORING_TAG]: (state, payload)=> {
				return {...state, isCreatingTag: true, createdTag: false, hasMessage: false}
		},
		[STORE_TAG]: (state, payload)=> {
				return {...state, isCreatingTag: false, createdTag: true, hasMessage: false}
		},
		[UPLOADING_TAG_PHOTO]: (state, payload)=> {
				return {...state, uploadingTagPhoto: true, uploadedTagPhoto: false}
		},
		[TAG_PHOTO_UPLOADED]: (state, payload)=> {
				return {...state, uploadingTagPhoto: false, uploadedTagPhoto: true, message: payload}
		},
		[RESET_TAG_STATUS]: (state, payload)=> {
				return {
						...state,
						createdTag: false,
						hasMessage: false,
						isRequesting: false,
						isCreatingTag: false,
						uploadingTagPhoto: false,
						uploadedTagPhoto: false,
						message: null
				}
		}
});