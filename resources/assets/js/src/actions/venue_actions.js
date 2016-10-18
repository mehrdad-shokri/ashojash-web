import {getAuthInstance, ROOT_URL} from './webserver'
import {
		VENUE_REQUEST,
		VENUE_RESPONSE,
		VENUE_MESSAGE
}from './types';
export function getVeneues() {
		return function(dispatch) {
				dispatch(getVenuesRequest());
				getAuthInstance().post(`${ROOT_URL}/panel/venues`, null, {
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