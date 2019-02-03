import BaseService from '@/services/BaseService';
import Utils from '@/services/Utils';

class ProgramService extends BaseService {
    public getPrograms() {
        return this.get('program');
    }

    public getProgram(slug: string, include='') {
        return this.get('program/' + slug, {include: include});
    }

    public searchProgram(search : string) {
        return this.get('program', {search : search});
    }
}

export default new ProgramService();