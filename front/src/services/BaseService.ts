import Axios, { AxiosRequestConfig } from 'axios';

export default class BaseService {
    private api: string = process.env.API_URL;

    get(endpoint : string, config : AxiosRequestConfig | undefined = undefined) {
        return Axios.get(endpoint,config);
    }
}