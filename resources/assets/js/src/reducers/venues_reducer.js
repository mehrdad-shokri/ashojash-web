import {
		VENUE_MESSAGE,
		VENUE_REQUEST,
		VENUE_RESPONSE
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		isRequesting: false,
		venues: null,
		hasVenues: false,
		hasMessage: false,
		message: null,
};

export default createReducer(initialState, {
		[VENUE_REQUEST]: (state, payload)=> {
				return {...state, isRequesting: true, hasMessage: false}
		},
		[VENUE_RESPONSE]: (state, payload)=> {
				return {...state, isRequesting: false, hasVenues: true, venues: payload, hasMessage: false}
		},
		[VENUE_MESSAGE]: (state, payload)=> {
				return {
						...state,
						isRequesting: false,
						hasMessage: true,
						message: payload,
				}
		},
});