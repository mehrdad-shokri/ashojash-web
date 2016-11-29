import {
		VENUE_MESSAGE,
		VENUE_REQUEST,
		VENUE_RESPONSE,
		VENUE_TAGS_RESPONSE,
		IS_LOADING_VENUE_TAGS,
		VENUE_TAGS_SEARCH_RESPONSE
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		isRequesting: false,
		venues: null,
		hasVenues: false,
		hasMessage: false,
		message: null,
		venueTags: null,
		hasVenueTags: false,
		isLoadingVenueTags: false,
		venueTagsSearch: null,
		nextPageUrl: null,
};

export default createReducer(initialState, {
		[VENUE_REQUEST]: (state, payload)=> {
				return {...state, isRequesting: true, hasMessage: false}
		},
		[VENUE_RESPONSE]: (state, payload)=> {
				payload.data.push.apply(payload.data, state.venues)
				return {
						...state,
						isRequesting: false,
						hasVenues: true,
						venues: payload.data,
						hasMessage: false,
						nextPageUrl: payload.meta.pagination.links.next
				}
		},
		[VENUE_MESSAGE]: (state, payload)=> {
				return {
						...state,
						isRequesting: false,
						hasMessage: true,
						message: payload,
				}
		},
		[VENUE_TAGS_RESPONSE]: (state, payload)=> {
				return {
						...state,
						isRequesting: false,
						venueTags: payload
				}
		},
		[IS_LOADING_VENUE_TAGS]: (state, payload)=> {
				return {
						...state,
						isLoadingVenueTags: payload
				}
		},
		[VENUE_TAGS_SEARCH_RESPONSE]: (state, payload)=> {
				return {
						...state,
						venueTagsSearch: payload
				}
		}
});