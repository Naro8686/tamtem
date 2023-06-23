import Vue from "vue";
import Vuex from "vuex";
import userModule from "./usermodule.js";
import profile from "./profile.js";
import portfolio from "./portfolio.js";
Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    user: userModule,
    profile: profile,
    portfolio: portfolio
  },
  state: {
    width: window.innerWidth
  },
  mutations: {
    setWidth(state, payload) {
      state.width = payload;
    }
  },
  actions: {
    setWidth(context) {
      window.addEventListener("resize", () => {
        const width = window.innerWidth;
        context.commit("setWidth", width);
      });
    }
  }
});
