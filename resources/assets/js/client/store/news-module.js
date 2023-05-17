import Axios from "axios";

const newsModule = {
    namespaced: true,
    state: {
        adminNews: [],
    },
    mutations: {
        setNews(state, payload) {
            state.adminNews = [...payload];
        },
    },
    getters: {
        getAdminNews(state) {
            return state.adminNews
        }
    },
    actions: {
        async loadAdminNews(context) {
            const result = await Axios.get("/api/v1/admin-news");
            if (result.status === 200 && result.data.result) {
                context.commit("setNews", result.data.data);
            }
        }
    }
};
export default newsModule;