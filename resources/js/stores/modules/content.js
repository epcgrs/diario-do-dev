import ContentService from '../../services/modules/Content'

export default {
    namespaced: true,
    state: {
        contents: null
    },
    actions: {
        homeContent({commit}, page = 1) {
            return ContentService.homeContent(page).then(
                contentResponse => {

                    if(contentResponse.status) {
                        commit('setContent', contentResponse)
                    }

                    return Promise.resolve(contentResponse)
                },
                error => {
                    return Promise.reject(error)
                }
            )
        },
    },
    getters: {
        contentHome: (state) => {
            return state.contents
        },
    },
    mutations: {
        setContent(state, contents) {
            state.contents = contents;
        },
    }

}
