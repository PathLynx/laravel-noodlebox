import axios from "axios";
import AuthService from "./AuthService";
// create an axios instance
const ApiService = axios.create({
    baseURL: "/admin", // url = base url + request url
    // withCredentials: true, // send cookies when cross-domain requests
    timeout: 0, // request timeout
});

// request interceptor
ApiService.interceptors.request.use(
    async config => {
        // console.log(config);
        // do something before request is sent
        // let token = document.head.querySelector('meta[name="csrf-token"]');
        // if (token) {
        //     //config.headers["Authorization"] = "Bearer " + token;
        //     config.headers['X-CSRF-TOKEN'] = token.content;
        // }
        config.headers["Authorization"] = "Bearer " + AuthService.getToken();
        return config;
    },
    error => {
        // do something with request error
        console.log("Request Error:", error); // for debug
        return Promise.reject(error);
    },
);

// response interceptor
ApiService.interceptors.response.use(
    /**
     * If you want to get http information such as headers or status
     * Please return  response => response
     */

    /**
     * Determine the request status by custom code
     * Here is just an example
     * You can also judge the status by HTTP Status Code
     */
    response => {
        const res = response.data;
        //console.log(res);

        // if the custom code is not 20000, it is judged as an error.
        if (res.code) {
            if (res.code === 401) {
                AuthService.removeToken();
            }
            return Promise.reject(new Error(res.message || "Error"));
        } else {
            return res;
        }
    },
    error => {
        //console.log('err:' , error) // for debug
        return Promise.reject(error.response.data);
    },
);

export default ApiService;
