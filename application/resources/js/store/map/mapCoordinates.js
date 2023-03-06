export const coordinates = {
    state: () => ({
        defaultCoordinates: {
            lat: 50.005713790088826,
            lng: 36.22918089550667,
        },

        currentCoordinates: {
            lat: null,
            lng: null,
        },
    }),

    actions: {},

    mutations: {
        saveCoordinates(state, payload) {
            state.currentCoordinates.lat = payload.lat
            state.currentCoordinates.lng = payload.lng
        },

        saveLatitude(state, payload){
            if (state.currentCoordinates.lat >= 3){
                state.currentCoordinates.lat = payload
            }else {
                state.currentCoordinates.lat = payload
            }
        },

        saveLongitude(state, payload){
            state.currentCoordinates.lng = payload
        },

        clearCoordinates(state){
            state.currentCoordinates.lng = null
            state.currentCoordinates.lat = null
        }
    },

    getters: {
        getDefaultCoordinates(state) {
            return state.defaultCoordinates
        },

        getCurrentCoordinates(state) {
            return state.currentCoordinates
        },

        getCurrentLatitude(state) {
            if (!state.currentCoordinates.lat){
                return state.defaultCoordinates.lat
            }
            return state.currentCoordinates.lat
        },

        getCurrentLongitude(state) {
            if (!state.currentCoordinates.lng){
                return state.defaultCoordinates.lng
            }
            return state.currentCoordinates.lng
        }
    }


}
