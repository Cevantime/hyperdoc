import BaseService from "@/services/BaseService";

class ProfileService extends BaseService {
    getProfile(){
        return this.get('profile');
    }
}

export default new ProfileService();