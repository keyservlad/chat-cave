export default {
    state: {
        email: null
    },
    getters: {
        EAMIL: state => state.email
    },
    mutations: {
        SET_EAMIL: (state, payload) => state.email = payload
    },
    actions: {}
}