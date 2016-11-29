import {getAuthInstance, ROOT_URL} from './webserver'
import {
		VENUE_REQUEST,
		VENUE_RESPONSE,
		VENUE_MESSAGE,
		VENUE_TAGS_RESPONSE,
		IS_LOADING_VENUE_TAGS,
		VENUE_TAGS_SEARCH_RESPONSE
}from './types';
export function getVenues() {
		return function(dispatch, getState) {
				dispatch(getVenuesRequest());
				let venuesUrl = getState().venues.nextPageUrl;
				if (venuesUrl === null)  venuesUrl = `${ROOT_URL}/panel/venues`;
				getAuthInstance().post(venuesUrl, null, {
						transformResponse: function(data) {
								return JSON.parse(data);
						}
				}).then(response => {
						dispatch({
								type: VENUE_RESPONSE,
								payload: response.data
						});
				}).catch(e => {
						dispatch(venueMessage("مشکلی رخ داد، دوباره تلاش کنید"));
				});
		}
}
function getVenuesRequest() {
		return function(dispatch) {
				dispatch({type: VENUE_REQUEST});
		}
}
export function venueMessage(message) {
		return function(dispatch) {
				dispatch({type: VENUE_MESSAGE, payload: message});
		}
}
export function getVenueTags(slug) {
		return function(dispatch) {
				dispatch(getVenuesRequest());
				getAuthInstance().post(`${ROOT_URL}/panel/venues/${slug}/tags`, null, {
						transformResponse: function(data) {
								return JSON.parse(data);
						}
				}).then(response => {
						dispatch({type: VENUE_TAGS_RESPONSE, payload: response.data});
				}).catch(e => {
						dispatch(venueMessage("مشکلی رخ داد، دوباره تلاش کنید"));
				});
		}
}
export function setIsLoadingTags(isLoading) {
		return function(dispatch) {
				dispatch({type: IS_LOADING_VENUE_TAGS, payload: isLoading});
		}
}
export function searchTags(query, slug) {
		return function(dispatch) {
				dispatch(setIsLoadingTags(true));
				getAuthInstance().post(`${ROOT_URL}/panel/venues/${slug}/tags/search`, {query}, {
						transformResponse: function(data) {
								var json = JSON.parse(data);
								var tags = json.map((tag)=> {
										return {
												name: tag.name,
										}
								});
								return tags;
						}
				}).then(response => {
						dispatch({type: VENUE_TAGS_SEARCH_RESPONSE, payload: response.data});
						dispatch(setIsLoadingTags(false));
				});
		}
}
export function addTag(name, weight, slug) {
		return function(dispatch) {
				dispatch(getVenuesRequest());
				getAuthInstance().post(`${ROOT_URL}/panel/venues/${slug}/tags/add`, {name, weight}).then(response => {
						dispatch(getVenueTags(slug));
				}).catch(e => {
						dispatch(venueMessage("مشکلی رخ داد، دوباره تلاش کنید"));
				});
		}
}