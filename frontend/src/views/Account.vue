<template lang="pug">
	section.account.container
		aside.account__aside
			asidenav
			section.aside-login(v-if="!hasAccess")
				button(@click="openForm('authorizationForm')").aside-login__btn.aside-login__btn--enter Войти
				button(@click="openForm('registrationForm')").aside-login__btn.aside-login__btn--register Регистрация
				div#yandex_rtb_R-A-506599-1
		main.account__content
			router-view
	//- section.account.container(v-else)
	//- 	div(v-if="!token") Для доступа к данному разделу необходимо 
	//- 		a.link(href="javascript:void(0);" v-on:click="$emit('showForm','authorizationForm')") авторизоваться
	//- 	div(v-else)
	//- 		| loading...
</template>
<script>
import Asidenav from "@/components/Asidenav.vue";
import { mapState } from "vuex";
export default {
  components: {
    Asidenav
  },
  computed: {
    ...mapState("user", ["token", "profile"]),
    hasAccess() {
      return !!this.token && this.profile && Object.keys(this.profile).length>0;
    }
  },
	methods: {
		openForm(form) {
			this.$root.$emit("openForm", form)
		}
	}
};
</script>
<style lang="scss" scoped>
// Просто оболочка для содержания
.account {
  display: flex;
  margin-top: 56px;
  margin-bottom: 56px;
  height: 100%;
}
.account__aside {
  flex-shrink: 0;
  max-width: 25%;
  width: 280px;
  margin-right: 40px;
  @media (max-width: 992px) {
    display: none;
  }
}
.account__content {
  flex-grow: 2;
}
.link {
  text-decoration: none;
  font: $font-bold;
  font-size: $fontsize-base;
  color: $form-links-color;
}
.aside-login {
	margin-top: 56px;
	&__btn {
		display: flex;
		width: 100%;
		justify-content: center;
		align-items: center;
		border-radius: 35px;
		height: 52px;
		padding: 0 20px;
		border: none;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		&:not(:last-child) {
			margin-bottom: 16px;
		}
		&--enter {
			background-color: $color-pale-green;
			color: $color-base-accent;
		}
		&--register {
			background-color: $color-base-accent;
			color: #fff;
		}
	}
}
.yandex_rtb_R-A-506599-1{
	border: none;
	width: 100%;
	justify-content: center;
	align-items: center;
}
</style>

