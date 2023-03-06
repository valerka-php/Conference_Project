export const conferences = {
    state: () => ({
        conferences: {},
        acceptedConferences: [],
    }),

    actions: {},

    mutations: {
        joinConference(state,payload){
            state.acceptedConferences.push(payload)
        },

        leaveConference(state,payload){
           state.acceptedConferences = state.acceptedConferences.filter(id => id !== payload)
        },

        setConferences(state, payload) {
            state.conferences = payload
        },
        setAcceptedConferences(state, payload) {
            state.acceptedConferences = payload
        }
    },

    getters: {
        getConferences(state) {
            return state.conferences;
        },

        getAcceptedConferences(state) {
            return state.acceptedConferences;
        },
    },
}
