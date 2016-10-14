import {getAuthInstance, ROOT_URL} from './webserver'
import {
		STORE_TAG,
		TAGS_RESPONSE,
		TAGS_REQUEST,
		TAG_MESSAGE,
		STORING_TAG,
		RESET_TAG_STATUS,
		UPLOADING_TAG_PHOTO,
		TAG_PHOTO_UPLOADED
}from './types';
export const TAG_EXISTS_ERROR = "تگ قبلا انتخاب شده";
export function getTags() {
		return function(dispatch) {
				dispatch(getTagsRequest());
				getAuthInstance().post(`${ROOT_URL}/panel/tags`, null, {
						transformResponse: function(data) {
								return JSON.parse(data);
						}
				}).then(response => {
						dispatch({
								type: TAGS_RESPONSE,
								payload: response.data
						});
				}).catch(e => {
						dispatch(tagMessage("مشکلی رخ داد، دوباره تلاش کنید"));
				});
		}
}
function getTagsRequest() {
		return function(dispatch) {
				dispatch({type: TAGS_REQUEST});
		}
}
export function tagMessage(message) {
		return function(dispatch) {
				dispatch({type: TAG_MESSAGE, payload: message});
		}
}
export function newTag(name, level) {
		return function(dispatch) {
				dispatch({type: STORING_TAG});
				getAuthInstance().post(`${ROOT_URL}/panel/tags/store`,
						{
								name,
								level
						}).then(() => {
						dispatch({type: STORE_TAG});
				}).catch(e => {
						dispatch(tagMessage(JSON.parse(e.response.data.message).name[0]));
				});
		}
}
export function resetTagStatus() {
		return function(dispatch) {
				dispatch({type: RESET_TAG_STATUS});
		}
}
export function uploadFile(file, id) {
		return function(dispatch) {
				dispatch({type: UPLOADING_TAG_PHOTO});
				let data = new FormData();
				data.append('id', id);
				data.append('file', file);
				getAuthInstance().post(`${ROOT_URL}/panel/tags/uploadPhoto`, data)
						.then(()=> {
								dispatch({type: TAG_PHOTO_UPLOADED});
								dispatch(tagMessage("فایل آپلود شد"));
						}).catch(e => {
						dispatch(tagMessage("خطایی هنگام آپلود رخ داد"));
				});
		}
}
