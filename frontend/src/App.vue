<template lang="pug">
	div#app.app
		.app-wrapper.sdaasd
			Header(@showForm="showForm")
			Infobar
			div.content-wrap
				router-view(@showForm="showForm")
			transition(name="fade-modal")
				modal-wrapper(v-if="isModalVisible" @close="isModalVisible=false")
					component(
						:is="activeComponent"
						@close="isModalVisible=false"
						:closeOnOverlayClick="true"
						@showForm="showForm"
					)
			Footer
			div.cookie-note(:class="{'cookie-note--active' : showCookie}")
				.container.cookie-note__container
					.cookie-note__box
						p.cookie-note__message Сайт tamtem.ru использует файлы #[a(href="/files/politic.doc")  cookie], чтобы сделать пользование сайтом проще.
						button.cookie-note__btn(@click.prevent="saveCookies") Ок
</template>
<script>
import Header from "@/components/layout/Header.vue";
import Infobar from "@/components/layout/Infobar.vue";
import Footer from "@/components/layout/Footer.vue";
import modalWrapper from "@/components/modalWrapper.vue";
import authorizationForm from "@/components/authorizationComponents/authorizationForm.vue";
import registrationForm from "@/components/authorizationComponents/registrationForm.vue";
import forgotForm from "@/components/authorizationComponents/forgotForm.vue";
import successRegistrationForm from "@/components/authorizationComponents/successRegistrationForm.vue";
import { mapState } from "vuex";
import Cookies from "js-cookie";
export default {
  components: {
    Header,
    Footer,
		Infobar,
    modalWrapper,
    authorizationForm,
    registrationForm,
    forgotForm,
    successRegistrationForm
  },
  data() {
    return {
      showCookie: false,
      isModalVisible: false,
      activeComponent: "authorizationForm",
      componentsList: [
        "authorizationForm",
        "registrationForm",
        "forgotForm",
        "successRegistrationForm"
      ]
    };
  },
  created() {
		this.$root.$on('openForm',(payload)=>{
			this.showForm(payload)
		});
      this.checkCookies();
   },
	beforeDestroy(){
		this.$root.$off('openForm');
	},
  computed: {
    ...mapState("user", ["profile", "token"]),
    isAuth() {
      return !!this.token && !!this.profile;
    },
		
  },
  methods: {
    saveCookies() {
      Cookies.set("cookiesInfo", true,{expires: 365});
      this.checkCookies();
    },
    checkCookies() {
      this.showCookie = !Cookies.get("cookiesInfo");
      if (!this.showCookie){
        Cookies.set("cookiesInfo", true,{expires: 365});
      }
    },
    showForm(formName) {
      this.activeComponent = formName;
      this.isModalVisible = true;
    }
  }
};
</script>
<style lang="scss">
@import url("https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic");
@import "./assets/scss/_normalize.scss";
@import "./assets/scss/_general.scss";
@import "./assets/scss/_animation.scss";
.app {
  display: flex;
  &-wrapper {
    flex: 1 1 auto;
    overflow-x: hidden;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    max-width: 100%;
    position: relative;
  }
}
.container {
  width: 100%;
}
.body-overlay {
  overflow: hidden;
  &::before {
    content: "";
    position: fixed;
    width: 100%;
    height: 100vh;
    z-index: 5;
    background: transparentize(#000, 0.4);
  }
  &--transparent {
    &::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100vh;
      z-index: 2;
      background: transparent;
    }
  }
}
.label_39 {
	z-index: 1 !important;
}
</style>
<style lang="scss" scoped>
.cookie-note {
	position: fixed;
	bottom: 0;
	width: 100%;
	background: #f6f6f6;
	font-family: $font-family;
	z-index: 5;
	height: 0;
	overflow: hidden;
	transform: translateY(-100%);
	transition: 0.3s;
	&--active {
		height: auto;
		transform: translateY(0);
	}
	&__box {
		display: flex;
		align-items: center;
		padding: 10px 0;
	}
	&__message {
		font-size: 14px;
		line-height: 19px;
		margin-right: 30px;

		@media (max-width: 425px) {
			font-size: 11px;
			line-height: 16px;
		}
		a {
			color: $color-base-accent;
			text-decoration: underline;
			@media (max-width: 768px) {
				margin-top: 8px;
				display: inline-block;
			}
		}
	}
	&__btn {
		display: flex;
		color: #ffffff;
		background-color: $color-base-accent;
		border-radius: 32px;
		width: 93px;
		height: 43px;
		justify-content: center;
		align-items: center;
		margin-left: auto;
		flex-shrink: 0;
		border: none;
		@media (max-width: 425px) {
			font-size: 12px;
			height: 27px;
			width: 57px;
		}
	}
}
.content-wrap {
	flex-grow: 2; 
}
.fade-modal-enter {
	transform: translateY(-50px);
	opacity: 0;
}
.fade-modal-enter-active {
	transition: transform 0.5s, opacity 0.2s;
	transition-delay: 0.2s;
}

.fade-modal-leave-active {
	transition: 0.2s;
}
.fade-modal-leave-to {
	opacity: 0;
	transform: translateY(-100px);
}
</style>
