import axios from 'axios';
const env = process.env.NODE_ENV;
export let ROOT_URL;
if (env === 'production') {
		ROOT_URL = 'https://ashojash.com/api/admin';
} else {
		ROOT_URL = 'http://192.168.20.10/api/admin';
}
export function getAuthInstance(){
		return axios.create({
				baseURL: ROOT_URL,
				headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
		});
}
export const nonAuthInstance = axios;