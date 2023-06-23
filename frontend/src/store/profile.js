import Axios from "axios";

const profile = {
  namespaced: true,
  state: {},
  mutations: {},
  getters: {},
  actions: {
    // eslint-disable-next-line no-unused-vars
    async fileCreate({context}, url){
      const blob = await Axios(url,{responseType: 'arraybuffer'});
      return new File([blob.data],"file");
    },
    // eslint-disable-next-line no-unused-vars
    async profileUpdate({context},payload){
      const result = await Axios.post(
        `/api/v1/users/${payload.id}`,payload.data,{
          headers: { "Content-Type": "multipart/form-data" }
        }
        )
        return result
      },
    // eslint-disable-next-line no-unused-vars
    async updatePassword({context},payload){
      return await Axios.post(`/api/v1/passwordchange`,payload)
    },
    async generateLink(){
      return await Axios.post('/api/v1/user/refgenerateforme')
    }
  }
};
export default profile;
