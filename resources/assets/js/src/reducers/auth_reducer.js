import {
		AUTH_LOGIN,
		AUTH_LOGIN_REQUEST,
		UNAUTH_USER,
		AUTH_LOGIN_ERROR,
		AUTH_PERMISSIONS,
		AUTH_PERMISSIONS_REQUEST,
		AUTH_AUTHENTICATED,
		AUTH_REQUEST,
		TOKEN_EXPIRED
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		token: null,
		hasPermissions: false,
		isFetchingPermissions: false,
		isSubmitting: false,
		isSuccess: false,
		errorMessage: null,
		authenticated: false,
		knowIfAuthenticated: false,
		isAuthenticating: false
};

export default createReducer(initialState, {
		[AUTH_LOGIN]: (state, payload)=> {
				return {...state, authenticated: true, token: payload, isSuccess: true, isSubmitting: false, isError: false};
		},
		[AUTH_LOGIN_REQUEST]: (state, payload)=> {
				return {...state, isSuccess: false, isSubmitting: true, isError: false};
		},
		[AUTH_LOGIN_ERROR]: (state, payload)=> {
				return {...state, errorMessage: payload, isSuccess: false, isSubmitting: false, isError: true};
		},
		[UNAUTH_USER]: (state, payload)=> {
				return {...state, authenticated: false};
		},
		[AUTH_PERMISSIONS_REQUEST]: (state, payload)=> {
				return {...state, isFetchingPermissions: true}
		},
		[AUTH_PERMISSIONS]: (state, payload)=> {
				return {...state, permissions: payload, isFetchingPermissions: false, hasPermissions: true}
		},
		[AUTH_REQUEST]: (state)=> {
				return {...state, isAuthenticating: true}
		},
		[TOKEN_EXPIRED]: (state)=> {
				return {...state, isSuccess: false}
		},
		[AUTH_AUTHENTICATED]: (state, payload)=> {
				return {...state, authenticated: payload, isAuthenticating: false, knowIfAuthenticated: true}
		}
})
