import { AxiosInstance, AxiosRequestConfig } from 'axios';
import Vue from 'vue';
import AuthService from '@/services/AuthService';
import Utils from '@/services/Utils';

export default class BaseService {
    protected axios: AxiosInstance;
    constructor() {
        this.axios = Vue.$axios;
    }

    async get(endpoint: string, data : any | undefined = undefined, config: AxiosRequestConfig | undefined = undefined) {
        if(data !== undefined){
            endpoint += '?' + Utils.serialize(data);
        }
        return this.axios.get(endpoint, await this.addTokenToConfig(config)).then((rep : any) => {return rep.data});
    }

    async delete(endpoint: string, data : any | undefined = undefined, config: AxiosRequestConfig | undefined = undefined) {
        if(data !== undefined){
            endpoint += '?' + Utils.serialize(data);
        }
        return this.axios.delete(endpoint, await this.addTokenToConfig(config));
    }

    protected async addTokenToConfig(config: AxiosRequestConfig | undefined = undefined) {
        await AuthService.refreshToken();
        if (config === undefined) {
            config = {
                headers: {}
            };
        }
        config.headers.Authorization = AuthService.getAccessToken();
        return config;
    }
}