import api from './Api'
/**
 * AuthService
 *
 * @module ContentService
 *
 */
class ContentService {

    homeContent(page = 1) {
        return api
            .get(`contents/home?page=${page}`)
            .then(response => {
                return response;
            });
    }

}

export default new ContentService();
