import Utils from '@/services/Utils';
import Axios from 'axios';
import TokenService from '@/services/TokenService';

class AuthService {

    public login() {
        window.location.href = process.env.VUE_APP_OAUTH_DOMAIN + '/authorize?' + Utils.serialize({
            response_type: 'code',
            client_id: process.env.VUE_APP_OAUTH_CLIENT_ID,
            redirect_uri: process.env.VUE_APP_BASE_URL + '/callback',
            state: 'front-state' // to generate
        });
    }

    public getParameter(name: string, url?: string) {
        if (url === undefined) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    public getAccessTokenFromCode() {
        const code = this.getParameter('code');
        let params = {
            code: code,
            grant_type: 'authorization_code',
            client_secret: process.env.VUE_APP_OAUTH_CLIENT_SECRET,
            client_id: process.env.VUE_APP_OAUTH_CLIENT_ID,
            redirect_uri: process.env.VUE_APP_BASE_URL + '/callback'
        };
        return Axios.post(process.env.VUE_APP_OAUTH_DOMAIN + '/access-token', Utils.serialize(params)).then((response: any) => {
            const data = response.data;
            if (data.error === undefined && typeof data.access_token === 'string') {
                localStorage.setItem("access_token", data.access_token);
                localStorage.setItem("expires_at", (String)(new Date().getTime() / 1000 + data.expires_in - 100));
                localStorage.setItem("refresh_token", data.refresh_token);
            }
        });
    }

    public getAccessToken() {
        return localStorage.getItem("access_token");
    }

    async logout() {
        const token = localStorage.getItem('access_token');
        if(token === null) {
            return;
        }
        await TokenService.revokeToken(token);
        localStorage.removeItem("access_token");
        localStorage.removeItem("expires_at");
        localStorage.removeItem("refresh_token");
        window.location.href = process.env.VUE_APP_BASE_URL + '/' ;
    }

    refreshToken(): PromiseLike<{}> {
        if (localStorage.getItem("expires_at") === null != (Number)(localStorage.getItem("expires_at")) < new Date().getTime() / 1000) {
            return Axios.post(process.env.VUE_APP_OAUTH_DOMAIN + '/access-token', Utils.serialize({
                grant_type: 'refresh_token',
                client_id: process.env.VUE_APP_OAUTH_CLIENT_ID,
                client_secret: process.env.VUE_APP_OAUTH_CLIENT_SECRET,
                refresh_token: localStorage.getItem("refresh_token")
            })).then((response) => {
                const data = response.data;
                if (data.error === undefined && typeof data.access_token === 'string') {
                    localStorage.setItem("access_token", data.access_token);
                    localStorage.setItem("expires_at", (String)((new Date().getTime() / 1000) + data.expires_in - 1000));
                    localStorage.setItem("refresh_token", data.refresh_token);
                }
                return response;
            }).catch((e) => {
                // this.logout();
                return e;
            });
        }
        return Promise.resolve({});
    }

    protected saveIfExistsAsParameter(key: string, name: string) {
        let value = this.getParameter(name);
        if (value !== null) {
            localStorage.setItem(key, value);
        }
    }
}

export default new AuthService();