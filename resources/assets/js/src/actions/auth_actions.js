import {
		AUTH_LOGIN,
		AUTH_LOGIN_REQUEST,
		AUTH_LOGIN_ERROR,
		UNAUTH_USER,
		AUTH_PERMISSIONS,
		AUTH_PERMISSIONS_REQUEST,
		AUTH_AUTHENTICATED,
		AUTH_REQUEST
} from './types';
import {getAuthInstance, nonAuthInstance, ROOT_URL} from './webserver'
export function signinUserRequest() {
		return {type: AUTH_LOGIN_REQUEST};
}
export function signinUser(login, password) {
		return function(dispatch) {
				dispatch(signinUserRequest());
				nonAuthInstance.post(`${ROOT_URL}/auth/login`, {login, password}, {
						transformResponse: function(data) {
								var json = JSON.parse(data);
								return json;
						}
				}).then(response => {
						const token = response.data;
						localStorage.setItem('token', token.token);
						localStorage.setItem('ttl', token.ttl);
						localStorage.setItem('exp', token.exp);
						dispatch({type: AUTH_LOGIN, payload: response.data});
				}).catch(e => {
						dispatch({type: AUTH_LOGIN_ERROR, payload: e.response.data.message});
				});
		}
}

export function signoutUser() {
		localStorage.removeItem('token');
		return {type: UNAUTH_USER};
}
export function getPermissionsRequest() {
		return {
				type: AUTH_PERMISSIONS_REQUEST
		}
}
export function getPermissions() {
		return function(dispatch) {
				let token = localStorage.getItem('token');
				dispatch(getPermissionsRequest());

				getAuthInstance().post(`${ROOT_URL}/auth/permissions`, null, {
						transformResponse: function(data) {
								var json = JSON.parse(data);
								var array = json.map((item)=> {
										return item.name;
								});
								return array;
						}
				}).then(response => {
						dispatch({
								type: AUTH_PERMISSIONS,
								payload: response.data
						});
				});
		}
}
export function authenticationRequest(isAuthenticating) {
		return function(dispatch) {
				return dispatch({type: AUTH_REQUEST, payload: isAuthenticating});
		}
}
function refreshToken() {
		return function(dispatch) {
				getAuthInstance().post(`${ROOT_URL}/auth/refreshToken`, null, {  //refresh token and check if valid
						transformResponse: function(data) {
								var json = JSON.parse(data);
								return json;
						}
				}).then(response => {
						const token = response.data;
						localStorage.setItem('token', token.token);
						localStorage.setItem('ttl', token.ttl);
						localStorage.setItem('exp', token.exp);
						dispatch({type: AUTH_AUTHENTICATED, payload: true});
						dispatch(authenticationRequest(false));
				}).catch(() => {
						localStorage.removeItem('token');
						localStorage.removeItem('ttl');
						localStorage.removeItem('exp');
						dispatch({type: AUTH_AUTHENTICATED, payload: false});
						dispatch(authenticationRequest(false));
				});
		}
}
export function refreshTokenIfNecessary() {
		return function(dispatch) {
				var exp = localStorage.getItem('exp');
				var token = localStorage.getItem('token');
				var now = new Date().getTime() / 1000;
				if (!exp || !token || exp < now) {
						dispatch(authenticationRequest(false));
						return dispatch({type: AUTH_AUTHENTICATED, payload: false});
				}
				const ONE_DAY = 24 * 60 * 60;
				if (exp - now < ONE_DAY && exp - now > 0) {
						refreshToken();
				}
		}
}
export function authenticateUser() {
		return function(dispatch) {
				dispatch(authenticationRequest(true));
				var token = localStorage.getItem('token');
				var exp = localStorage.getItem('exp');
				if (!token) {
						dispatch(authenticationRequest(false));
						return dispatch({type: AUTH_AUTHENTICATED, payload: false});
				}
				dispatch(refreshToken());
		}
}
