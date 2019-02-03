import BaseService from "@/services/BaseService";
import AuthService from "@/services/AuthService";

class ProfileService extends BaseService {
    getProfile(){
        if( ! AuthService.getAccessToken()) {
            return Promise.resolve();
        }
        return this.get('profile');
    }
}

export default new ProfileService();