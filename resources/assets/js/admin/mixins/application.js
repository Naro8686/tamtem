import Echo from "laravel-echo";
import Cookies from "js-cookie";
var mixins = {
  data() {
    return {
      profile: null,
      loadError: false
    };
  },

  created() {
    axios.interceptors.response.use(
      config => {
        return config;
      },
      error => {
        if (error.response.status == 401) {
          window.location = "/login";
        }

        if (error.response.status == 403) {
          this.showError("Действие запрещено. Недостаточно прав.");
        }
        if (error.response.status == 405) {
          this.showError("Метод не найден");
        }

        if (error.response.status == 404) {
          this.goToNotFound();
        }

        if (error.response.status == 419) {
          this.showError("Сессия истекла.");
        }

        if (error.response.status == 422) {
          this.messageFormError();
        }

        return Promise.reject(error);
      }
    );

    axios
        .get("/admin/api/profile")
        .then(resp => {
          if (resp.data.user && resp.data.permissions) {
            this.profile = resp.data;
            this.initLaravelEcho();
            this.listenForNotifications();
            this.$mount("#app");

          } else {
            this.loadError = true;
            this.$mount("#app");
          }

        })
        .catch(error => {
          this.loadError = true;
        });
  },

  methods: {
    listenForNotifications() {
      if (this.$root.profile) {
        window.Echo.private("admin-notification." + this.$root.profile.user.id).listen(
            "NotifyAdmin",(e) => {
              this.$message({
                message: e.message,
                type: "success",
                showClose: true
              });
            });
      }
    },
    initLaravelEcho(self) {
      if (this.$root.profile) {
        if (!window.Echo) {
          try {
            window.Echo = new Echo({
              broadcaster: "socket.io",
              host: window.location.hostname + ":6001",
              encrypted: false,
              auth: {
                headers: {
                  Authorization: "Bearer " + Cookies.get("api_token")
                }
              }
            });
            window.User = this.$root.profile.user;
          } catch (e) {
            console.log(e);
          }
        }
        if (this.$root.profile) {
          setInterval(() => {

          }, 1000 * 20);
        }


      }

      window.EchoPublic = new Echo({
        broadcaster: "socket.io",
        host: window.location.hostname + ":6001"
      });
    },
  }
};

export default mixins;
