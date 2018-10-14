import BaseService from '@/services/BaseService';

class ProgramService extends BaseService {
    public getPrograms() {
        return this.get('/program');
    }
}

export const programService = new ProgramService;