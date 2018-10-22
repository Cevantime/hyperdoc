import BaseService from '@/services/BaseService';
import Utils from '@/services/Utils';

class ProgramService extends BaseService {
    public getPrograms() {
        return this.get('program');
    }

    public getProgram(slug: string, include='') {
        return this.get('program/' + slug, {include: include});
    }
}

export default new ProgramService();