<template>
  <header class="main-header">
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">b<b>2</b>b</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>b2b</span>
    </a>
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="javascript:void(0)" @click.prevent="openNotifications"  class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" id="notificationsCount">{{notSeen}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Уведомления</li>
              <li  v-if="notifications.length">
                <ul class="menu">
                  <li class="notification-item"  v-for="notification in notifications" v-html="notification.message">

                  </li>
                  <li class="footer" v-if="notifications.length >= 10"><a href="javascript:void(0)" @click.prevent="getNotifications" v-on:click.stop >Show more</a></li>
                </ul>
              </li>
              <li class="text-center footer" v-else>
                Пусто
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img
                src="/images/admin/avatar.png"
                class="user-image"
                alt="User Image"
              />
              <span class="hidden-xs">{{ getUserName }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img
                  src="/images/admin/avatar.png"
                  class="img-circle"
                  alt="User Image"
                />
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a
                    class="btn btn-default btn-flat"
                    href="/logout"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                  >
                    Выйти
                  </a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>
<script>
export default {
  name: "MainHeader",
  data() {
    return {
      notifications: [],
      notSeen: null,
      offset: 0,
    }
  },

  computed: {
    getUserName() {
      return this.$root.profile.user.name;
    }
  },
  created() {
    this.getNotifications();
  },
  methods: {
    getNotifications() {
      axios
          .get("/admin/api/notifications?offset=" + this.offset)
          .then(resp => {
            this.notifications.push(...resp.data.notifications);
            this.notSeen = resp.data.notSeen;
          })
          .catch(error => {
            this.loadError = true;
          });

      this.offset = this.offset + 10;
    },
    openNotifications() {
      axios
          .post("/admin/api/notifications/seen")
          .then(resp => {
            this.notSeen = resp.data.notSeen
          })
          .catch(error => {
            this.loadError = true;
          });
    }
  }
};
</script>

<style scoped></style>
