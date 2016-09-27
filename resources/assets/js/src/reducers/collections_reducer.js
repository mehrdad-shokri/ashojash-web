import {
		COLLECTIONS_REQUEST,
		COLLECTIONS_RESPONSE,
		COLLECTIONS_ERROR,
		COLLECTION_NAME,
		COLLECTION_DESCRIPTION,
		COLLECTION_START_TIME,
		COLLECTION_START_DATE,
		COLLECTION_END_TIME,
		COLLECTION_END_DATE,
		COLLECTION_PHOTO,
		COLLECTION_CITIES,
		SET_COLLECTION_CITY,
		SET_COLLECTION_ACTIVATION,
		GET_COLLECTION_VENUES,
		UPDATE_SELECTED_COLLECTION_VENUES,
		IS_LOADING_COLLECTION_VENUES,
		COLLECTION_CREATED,
		CREATING_COLLECTION,
		SET_COLLECTION_TYPE,
		RESET_COLLECTION_CREATION,
		RESET_COLLECTION_STATES
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		isRequesting: false,
		collections: null,
		hasCollections: false,
		hasError: false,
		collectionName: null,
		collectionDescription: null,
		collectionStartTime: null,
		collectionStartDate: null,
		collectionEndTime: null,
		collectionEndDate: null,
		collectionPhoto: null,
		collectionStep: 0,
		cities: null,
		collectionCity: null,
		isCollectionActive: true,
		collectionVenues: null,
		selectedCollectionVenues: null,
		isLoadingCollectionVenues: false,
		hasCreatedCollection: false,
		isCreatingCollection: false,
		collectionType: null
};

export default createReducer(initialState, {
		[COLLECTIONS_REQUEST]: (state, payload)=> {
				return {...state, isRequesting: true, hasError: false}
		},
		[COLLECTIONS_RESPONSE]: (state, payload)=> {
				return {...state, isRequesting: false, hasCollections: true, collections: payload, hasError: false}
		},
		[COLLECTIONS_ERROR]: (state, payload)=> {
				return {...state, isRequesting: false, hasError: true}
		},
		[COLLECTION_NAME]: (state, payload)=> {
				return {...state, collectionName: payload}
		},
		[COLLECTION_DESCRIPTION]: (state, payload)=> {
				return {...state, collectionDescription: payload}

		},
		[COLLECTION_START_TIME]: (state, payload)=> {
				return {...state, collectionStartTime: payload}

		},
		[COLLECTION_START_DATE]: (state, payload)=> {
				return {...state, collectionStartDate: payload}

		},
		[COLLECTION_END_TIME]: (state, payload)=> {
				return {...state, collectionEndTime: payload}

		},
		[COLLECTION_END_DATE]: (state, payload)=> {
				return {...state, collectionEndDate: payload}

		},
		[COLLECTION_PHOTO]: (state, payload)=> {
				return {...state, collectionPhoto: payload}
		},
		[COLLECTION_CITIES]: (state, payload)=> {
				return {...state, cities: payload}
		},
		[SET_COLLECTION_CITY]: (state, payload)=> {
				return {...state, collectionCity: payload}
		},
		[SET_COLLECTION_ACTIVATION]: (state, payload)=> {
				return {...state, isCollectionActive: payload}
		},
		[GET_COLLECTION_VENUES]: (state, payload)=> {
				return {...state, collectionVenues: payload}
		},
		[UPDATE_SELECTED_COLLECTION_VENUES]: (state, payload)=> {
				return {...state, selectedCollectionVenues: payload}
		},
		[IS_LOADING_COLLECTION_VENUES]: (state, payload)=> {
				return {...state, isLoadingCollectionVenues: payload}
		},
		[CREATING_COLLECTION]: (state, payload)=> {
				return {...state, isCreatingCollection: true, hasCreatedCollection: false}
		},
		[COLLECTION_CREATED]: (state, payload)=> {
				return {...state, isCreatingCollection: false, hasCreatedCollection: true}
		},
		[SET_COLLECTION_TYPE]: (state, payload)=> {
				return {...state, collectionType: payload}
		},
		[RESET_COLLECTION_STATES]: (state, payload)=> {
				return {
						...state,
						isCreatingCollection: false,
						hasCreatedCollection: false
				}
		},
		[RESET_COLLECTION_CREATION]: (state, payload)=> {
				return {
						...state,
						collectionName: null,
						collectionDescription: null,
						collectionStartTime: null,
						collectionStartDate: null,
						collectionEndTime: null,
						collectionEndDate: null,
						collectionPhoto: null,
						collectionStep: 0,
						cities: null,
						collectionCity: null,
						isCollectionActive: true,
						collectionVenues: null,
						selectedCollectionVenues: null,
						isLoadingCollectionVenues: false,
						collectionType: null
				}
		}
});