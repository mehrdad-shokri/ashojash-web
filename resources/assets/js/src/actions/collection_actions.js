import {getAuthInstance, ROOT_URL} from './webserver'
import {
    COLLECTIONS_RESPONSE,
    COLLECTIONS_REQUEST,
    COLLECTION_NAME,
    COLLECTION_DESCRIPTION,
    COLLECTION_START_DATE,
    COLLECTION_START_TIME,
    COLLECTION_END_TIME,
    COLLECTION_END_DATE,
    COLLECTION_PHOTO,
    COLLECTION_STEP,
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
}from './types';
export function getCollectionsRequest() {
    return function (dispatch) {
        dispatch({type: COLLECTIONS_REQUEST});
    }
}
export function getCollections() {
    return function (dispatch) {
        // dispatch(getPermissionsRequest());
        dispatch(getCollectionsRequest());
        getAuthInstance().post(`${ROOT_URL}/panel/collections`, null, {
            transformResponse: function (data) {
                return JSON.parse(data);
            }
        }).then(response => {
            dispatch({
                type: COLLECTIONS_RESPONSE,
                payload: response.data
            });
        });
    }
}
export function setCollectionStep(step) {

    return function (dispatch) {
        dispatch({
            type: COLLECTION_STEP,
            payload: step
        });
    }
}
export function setCollectionName(name) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_NAME,
            payload: name
        });
    }
}
export function setCollectionDescription(description) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_DESCRIPTION,
            payload: description
        });
    }
}
export function setCollectionStartTime(startTime) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_START_TIME,
            payload: startTime
        });
    }
}
export function setCollectionStartDate(startDate) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_START_DATE,
            payload: startDate
        });
    }
}
export function setCollectionEndTime(endTime) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_END_TIME,
            payload: endTime
        });
    }
}
export function setCollectionEndDate(endDate) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_END_DATE,
            payload: endDate
        });
    }
}
export function setCollectionPhoto(file) {
    return function (dispatch) {
        dispatch({
            type: COLLECTION_PHOTO,
            payload: file
        });
    }
}
export function getCollectionCities() {
    return function (dispatch) {
        getAuthInstance().get(`${ROOT_URL}/panel/collections/city/all`, {
            transformResponse: function (data) {
                var json = JSON.parse(data);
                return json;
            }
        }).then(response => {
            dispatch({type: COLLECTION_CITIES, payload: response.data});
        });
    }
}
export function setCollectionCity(value) {
    return function (dispatch) {
        dispatch({type: SET_COLLECTION_CITY, payload: value})
    }
}
export function setCollectionActivation(isActive) {
    return function (dispatch) {
        dispatch({type: SET_COLLECTION_ACTIVATION, payload: isActive})
    }
}
export function getCollectionVenues(slug, query) {
    return function (dispatch) {
        dispatch(setIsLoadingCollectionVenues(true));
        getAuthInstance().post(`${ROOT_URL}/panel/collections/venue/search`, {slug, query}, {
            transformResponse: function (data) {
                var json = JSON.parse(data);
                var venues = json.map((venue)=> {
                    return {
                        name: venue.name,
                        slug: venue.slug,
                        address: venue.location.address
                    }
                });
                return venues;
            }
        }).then(response => {
            dispatch({type: GET_COLLECTION_VENUES, payload: response.data});
            dispatch(setIsLoadingCollectionVenues(false));
        });
    }
};
export function setSelectedCollectionVenues(value) {
    return function (dispatch) {
        dispatch({type: UPDATE_SELECTED_COLLECTION_VENUES, payload: value});
    }
}
export function setIsLoadingCollectionVenues(isLoading) {
    return function (dispatch) {
        dispatch({type: IS_LOADING_COLLECTION_VENUES, payload: isLoading})
    }
}
export function newCollection(collectionName, collectionDescription, collectionType, citySlug, collectionPhoto, venueSelect, startDate, startTime, endDate, endTime, isActive) {
    return function (dispatch) {
        dispatch({type: CREATING_COLLECTION});
        getAuthInstance().post(`${ROOT_URL}/panel/collections/store`,
            {
                collectionName,
                collectionDescription,
                collectionType,
                citySlug,
                venueSelect,
                startDate,
                startTime,
                endDate,
                endTime,
                isActive
            }).then(response => {
            let data = new FormData();
            data.append('slug', response.data.slug);
            data.append('file', collectionPhoto);
            getAuthInstance().post(`${ROOT_URL}/panel/collection/uploadPhoto`, data)
                .then(()=> {
                    dispatch({type: COLLECTION_CREATED});
                });
        })
    }
}
export function setCollectionType(type) {
    return function (dispatch) {
        dispatch({type: SET_COLLECTION_TYPE, payload: type});
    }
}
export function resetCollectionCreation() {
    return function (dispatch) {
        dispatch({type: RESET_COLLECTION_CREATION});
    }
}
export function resetCollectionStates() {
    return function (dispatch) {
        dispatch({type: RESET_COLLECTION_STATES})
    }
}