import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store/store.js";
import { mapActions } from "vuex";
import "./registerServiceWorker";
import Message from "vue-m-message";
import VeeValidate, { Validator } from "vee-validate";
import MessagesMixins from "./mixins/messages.js";
import globalMethods from './mixins/global.methods.js'
import VeeValidateRu from "vee-validate/dist/locale/ru.js";
import mask from "vue-the-mask";
import filters from "./filters";
import validationRules from './mixins/validation.rules';

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
Validator.localize({
  ru: VeeValidateRu
});
Vue.use(mask);
Vue.use(VeeValidate, {
  locale: "ru",
  events: "input|blur"
});

Vue.use(validationRules);

Vue.use(Message);
Vue.use(filters);

Vue.mixin(globalMethods);
Vue.mixin(MessagesMixins);
Vue.config.productionTip = false;

Vue.prototype.$dadataKey = "f91af2fd3ec6b628f49c9a5208bb0713568cea54";

new Vue({
  router,
  store,
  render: h => h(App),
  created() {
    this.setWidth();
    this.login().catch(err => {
      console.log(err.response ? err.response : err.status);
      this.logout();
    });
  },
	computed: {
		fullPath() {
			if(process.env.NODE_ENV=='production') {
				return process.env.VUE_APP_BACKEND_PROD
			} else {
				return process.env.VUE_APP_BACKEND_DEV
			}
		}
	},
  methods: {
    ...mapActions("user", ["login", "logout"]),
    ...mapActions(["setWidth"])
  }
}).$mount("#app");
