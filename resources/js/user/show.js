import { getUserInfo } from "../utils/getUserInfo";

const apiUrl = 'http://127.0.0.1:8000/api';
const accessToken = localStorage.getItem('accessToken');

const userInfo = await getUserInfo(apiUrl, accessToken);

if (userInfo.rol !== 'admin') {
    window.location.href = '/';
}
