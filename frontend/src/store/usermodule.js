import Axios from "axios";
import Cookies from "js-cookie";
const userModule = {
  namespaced: true,
  state: {
    profile: null,
    token: null
  },
  mutations: {
    setProfile(state, profile) {
      if (profile) {
        state.profile = profile;
      } else {
        state.profile = {};
      }
    },
    setToken(state, token) {
      if (token) {
        state.token = token;
      } else {
        state.token = null;
      }
    }
  },
  actions: {
    async setProfile(context, payload) {
      context.commit("setProfile", payload);
    },
    async setToken(context, payload) {
      context.commit("setToken", payload);
    },
    async sendLoginData({ dispatch }, payload) {
      const res = await Axios.post("/api/v1/login", payload);
      if (res.data.result) {
        // TODO save token
        Cookies.set("token", res.data.data.api_token);
        await dispatch("setToken", res.data.data.api_token);
        await dispatch("getProfile", res.data.data.api_token);
      }
      return res.data;
    },
    async getProfile({ dispatch }, payload) {
      Axios.defaults.headers = {
        Authorization: `Bearer ${payload}`
      };
      const result = await Axios.get("/api/v1/user/profile");
      if (result.data.result) {
        dispatch("setProfile", result.data.data);
      }
      return result.data;
    },
    // eslint-disable-next-line no-unused-vars
    async sendRegistrationData({ context }, payload) {
      const result = await Axios.post("/api/v1/register", payload);
      return result.data;
    },
    // eslint-disable-next-line no-unused-vars
    async resendLetter({ context }, payload) {
      const result = await Axios.post("/api/v1/repeateregistermail", payload);
      return result.data;
    },
    // eslint-disable-next-line no-unused-vars
    async passwordReset({ context }, payload) {
      const result = await Axios.post("/api/v1/passwordreset", payload);
      return result.data;
    },
    async login({ dispatch }) {
      const token = Cookies.get("token");
      if (token) {
        await dispatch("setToken", token);
        await dispatch("getProfile", token);
      }
    },
    async logout(context) {
      Cookies.remove("token");
      context.commit("setToken", null);
      context.commit("setProfile", null);
    }
  }
};
export default userModule;
