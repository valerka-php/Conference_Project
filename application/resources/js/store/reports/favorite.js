export const favorite = {
    state: () => ({
        favorite: []
    }),

    mutations: {
        setFavorite(state, payload) {
            state.favorite = payload
        },

        addToFavorites(state, payload) {
            state.favorite.push(payload)
        },

        removeFromFavorites(state, payload) {
            state.favorite = state.favorite.filter(id => id !== payload)
        },
    },

    getters: {
        getFavorite(state) {
            return state.favorite;
        },

    },
}
