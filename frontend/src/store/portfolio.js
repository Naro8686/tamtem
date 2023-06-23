import Axios from "axios";
const portfolio = {
  namespaced: true,
  state: {},
  mutations: {},
  getters: {},
  actions: {
    // eslint-disable-next-line no-unused-vars
    async getDataByInn({ context }, payload) {
      const axiosImplement = Axios.create({
        baseURL:
          "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/",
        timeout: 5000,
        headers: {
          "Content-Type": "application/json",
          Authorization: `Token ${payload.key}`
        }
      });
      const result = await axiosImplement.post("party", {
        query: `${payload.inn}`,
        branch_type: "MAIN"
      });
      return result;
    },
    // eslint-disable-next-line no-unused-vars
    async loadCompanies({ context }, payload) {
      const result = await Axios.get(payload);
      return result;
    }
  }
};
export default portfolio;
