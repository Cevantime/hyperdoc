import BaseService from "@/services/BaseService";

class TokenService extends BaseService {
    revokeToken(token: string) {
        return this.delete('revoke', {'token' : token });
    }
}

export default new TokenService();