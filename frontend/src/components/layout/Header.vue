<template lang="pug">
header.mainheader
	.container.mainheader__container
		section.logo
			router-link(to="/")
				img(src="../../assets/img/logo/mainlogo.svg" alt="Tamtem Agent")
		nav.mainmenu
			a.mainmenu__burger(@click="showModalmenu()")
				svg(xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 91 91")
					g(fill="#ffffff")
						path(d="M85.713 12.142H5.861c-2.305 0-4.174-1.869-4.174-4.176 0-2.305 1.869-4.174 4.174-4.174h79.852c2.305 0 4.174 1.869 4.174 4.174 0 2.307-1.869 4.176-4.174 4.176zM85.713 49.858H5.861c-2.305 0-4.174-1.869-4.174-4.175 0-2.307 1.869-4.176 4.174-4.176h79.852c2.305 0 4.174 1.869 4.174 4.176 0 2.306-1.869 4.175-4.174 4.175zM85.713 87.571H5.861c-2.305 0-4.174-1.869-4.174-4.176s1.869-4.176 4.174-4.176h79.852c2.305 0 4.174 1.869 4.174 4.176s-1.869 4.176-4.174 4.176z")
			ul.mainmenu__list.notablet
				li.mainmenu__item
					a.mainmenu__link.animation-link-underline(href="https://tamtem.ru" target="_blank") Заказы
				li.mainmenu__item
					a(href="/about").mainmenu__link.animation-link-underline О сервисе
				li.mainmenu__item
					//-a(href="/faq" @click.prevent="linkToFAQ();").mainmenu__link.animation-link-underline С чего начать?
					a(href="/faq").mainmenu__link.animation-link-underline С чего начать?
				li.mainmenu__item
					a(href="http://blog.tamtem.ru/" target="_blank").mainmenu__link.animation-link-underline Блог
			section.modalmenu(
				:class="{'modalmenu--active' : modalmenuShow}"
			)
				header.modalmenu__header
					a(href="/").modalmenu__logo(@click="hideModalmenu()")
						Logo(variant="newmodal")
					.modalmenu__close(@click="hideModalmenu()")
						svg(xmlns="http://www.w3.org/2000/svg" width="15.557" height="15.556" viewBox="0 0 15.557 15.556")
							g(fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2")
								path(d="M14.142 1.414L1.414 14.1419")
								path(d="M1.414 1.414l12.728 12.7279")
				section(v-if='isAuth').modalmenu__user.modalmenu__user--logged
					.modalmenu__user-box
						p.modalmenu__userpic
						div.modalmenu__userinfo
							b.modalmenu__username {{profile.name}}
							router-link(to="/profile").modalmenu__userlink Личный кабинет
				section(v-if='!isAuth').modalmenu__user.modalmenu__user--unlogged
					.modalmenu__user-box
						p.modalmenu__userpic
							iconUserpicThumb(variant="modal-unlogged")
						div.modalmenu__userinfo
							b.modalmenu__username Мой аккаунт
							div.modalmenu__enterbox
								a(href="javascript:void(0);" @click="clickActionLink('authorizationForm')").modalmenu__enterlink Войти | 
								a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").modalmenu__enterlink Регистрация
				nav.modalmenu__navigation
					ul.modalmenu__menu-list
						li.modalmenu__menu-item
							a(href="https://tamtem.ru" target="_blank").modalmenu__menu-link Заказы
						li.modalmenu__menu-item
							a(href="/about").modalmenu__menu-link О сервисе
						li.modalmenu__menu-item
							a(href="/faq" @click.prevent="linkToFAQ();").modalmenu__menu-link С чего начать?
						li.modalmenu__menu-item
							a(href="http://blog.tamtem.ru/" target="_blank").modalmenu__menu-link Блог
				footer.modalmenu__footer
					ul.modalmenu__footer-list
						li.modalmenu__footer-item
							a(href="https://tamtem.ru/contact" target="_blank").modalmenu__footer-link Контакты
						li.modalmenu__footer-item
							a(href="mailto:team@tamtem.ru").modalmenu__footer-link team@tamtem.ru
						li.modalmenu__footer-item
							a(href="tel:+79307202300").modalmenu__footer-link +7 930 720 23 00
		section.createorder.mainheader__createorder
			a.createorder__btn(
				href="javascript:void(0);" 
				@click="linkToPortfolio()"
				v-if="isAuth"
			) Добавить компанию
			//- router-link(
			//- 	href="javascript:void(0)"
			//- 	to="/portfolio"
			//- ).createorder__btn 
			router-link(
				href="javascript:void(0)"
				to="/portfolio"
				v-if="isAuth"
			).createorder__plus
				<svg xmlns="http://www.w3.org/2000/svg" width="12.826" height="12.826" viewBox="0 0 12.826 12.826">
					<g id="Group_15218" data-name="Group 15218" transform="translate(1.5 1.5)">
						<path id="Shape" d="M0,0V9.826" transform="translate(4.913 0)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"/>
						<path id="Shape-2" data-name="Shape" d="M0,0H9.826" transform="translate(0 4.913)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"/>
					</g>
				</svg>
			a(
				href="javascript:void(0)"
				@click="openForm('authorizationForm')"
				v-if="!isAuth"
			).createorder__btn Добавить компанию
			a(
				href="javascript:void(0)"
				@click="openForm('authorizationForm')"
				v-if="!isAuth"
			).createorder__plus
				<svg xmlns="http://www.w3.org/2000/svg" width="12.826" height="12.826" viewBox="0 0 12.826 12.826">
					<g id="Group_15218" data-name="Group 15218" transform="translate(1.5 1.5)">
						<path id="Shape" d="M0,0V9.826" transform="translate(4.913 0)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"/>
						<path id="Shape-2" data-name="Shape" d="M0,0H9.826" transform="translate(0 4.913)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"/>
					</g>
				</svg>
		section(:class="{'profile--logged' : isAuth}").mainheader__profile.profile
			.profile__section
				section.profilemodal(
					:class="[isAuth ? 'profilemodal--logged' : 'profilemodal--unlogged', {'profilemodal--active' : modalprofileShow}]"
				)
					.profilemodal__box.profilemodal__enter.entermodal(v-if='!isAuth')
						a(href="javascript:void(0)" @click="clickActionLink('authorizationForm')").entermodal__link Войти 
						a(href="javascript:void(0)" @click="clickActionLink('registrationForm')").entermodal__link Регистрация
					.profilemodal__box.profilemodal__accountmenu.accountmenu(v-if='isAuth')
						.accountmenu__profile
							.accountmenu__userpic
							.accountmenu__profile-content
								b.accountmenu__name {{profile.name}}
								//- .accountmenu__company company
								router-link(:to="{name: 'profile'}").accountmenu__office Личный кабинет
						ul.accountmenu__list
							router-link.accountmenu__item(to="/portfolio")
									.accountmenu__icon
										iconPortfolio(color="#707070")
									.accountmenu__link Портфель компаний
							router-link(to="/status").accountmenu__item
								.accountmenu__icon
									iconStatus(color="#707070")
								.accountmenu__link Статус
								p.accountmenu__scores {{(profile.points+profile.points_from_agents)|pluralizeRus('балл')}}
							router-link(to="/balance").accountmenu__item
								.accountmenu__icon
									iconBalance(color="#707070")
								.accountmenu__link Баланс
								.accountmenu__value {{profile.ballance|priceFormat}}&nbsp;&#8381;
							//router-link(to="/notifications").accountmenu__item
								.accountmenu__icon
									iconNotification(color="#707070")
								.accountmenu__link Уведомления
							a(@click="logout").accountmenu__item.accountmenu__item--logout
								.accountmenu__icon
									iconLogout(color="#707070")
								.accountmenu__link Выход
				div.profile__box(v-if='!isAuth')
					p(@click="toggleProfile").profile__pic.profile__pic--unlogged
						iconUserpicThumb(variant="base-unlogged")
					div.profile__content.notablet
						b.profile__title Мой аккаунт
						div.profile__enter-box
							a(href="javascript:void(0);" @click="clickActionLink('authorizationForm')").profile__enter Войти 
							span | 
							a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").profile__enter Регистрация
				div.profile__box.profile__box-hover(v-if='isAuth' @click="toggleProfile")
					p(
						:class="{'profile__pic--notice': false}"
					).profile__pic.profile__pic--logged
					div.profile__content.notablet
						b.profile__title {{profile.name || 'Пользователь'}}
</template>
<style lang="scss" scoped>
.mainheader {
	background-color: $color-base-accent;
	padding: 17px 0;
	font: $font-regular;
	font-size: 15px;
	@media (max-width: 768px) {
		// position: relative;
		height: 87px;
	}
	&__container {
		display: flex;
		align-items: center;
	}
	&__createorder {
		margin-left: auto;
		order: 3;
	}
	&__profile {
		order: 4;
		margin-left: 1.6%;
		@media (max-width: 768px) {
			margin-left: auto;
		}
	}
	.logo {
		width: 156px;
		// height: 30px;
		order: 1;
		@media (max-width: 768px) {
			order: 2;
		}
		a {
			width: 100%;
		}
		svg {
			width: 100%;
			height: auto;
		}
	}
	.mainmenu {
		margin-left: 3.5%;
		margin-right: 10px;
		order: 2;
		@media (max-width: 768px) {
			margin-left: 0;
			order: 1;
		}
		&__list {
			list-style: none;
			display: flex;
			flex-wrap: wrap;
		}
		&__item {
			margin-top: 5px;
			margin-bottom: 5px;
			&:not(:last-child) {
				margin-right: 30px;
			}
		}
		&__link {
			font: $font-medium;
			font-size: 15px;
			line-height: 19px;
			color: $color-text-light;
			text-decoration: none;
			padding-bottom: 3px;
			&::before {
				background-color: #fff;
			}
		}
		&__burger {
			display: none;
			@media (max-width: 768px) {
				display: block;
			}
		}
	}
	.modalmenu {
		transform: translateX(-200%);
		flex-direction: column;
		position: absolute;
		top: 0;
		left: 0;
		background: #fff;
		height: 100vh;
		width: 48%;
		z-index: 5;
		transition: transform 0.5s;
		a {
			text-decoration: none;
			color: $color-text-dark;
		}
		@media (max-width: 620px) {
			width: 67%;
		}
		@media (max-width: 425px) {
			width: 100%;
		}
		&--active {
			transform: translateX(0);
		}
		&__header {
			padding-top: 20px;
			padding-bottom: 20px;
			padding-left: 40px;
			padding-right: 15px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			box-shadow: 0 2px 6px 0 rgba(69, 91, 99, 0.18);
		}
		&__logo {
			max-width: 137px;
			@media(max-width: 320px) {
				max-width: 127px;
			}
			& /deep/ svg {
				width: 100%;
				height: auto;
			}
		}
		&__close {
			cursor: pointer;
		}
		&__enterlink {
			color: $color-text-dark;
		}
		&__enterbox {
			margin-top: 5px;
		}
		&__user {
			padding-left: 40px;
			padding-right: 15px;
			padding-top: 20px;
			padding-bottom: 20px;
			&--logged {
				// temporary
				.modalmenu__userpic {
					width: 49px;
					height: 49px;
					border-radius: 50%;
					background: #2fc06e;
					background: url(../../assets/img/login_thumb.png) no-repeat;
					background-size: cover;
					background-position: center;
				}
				.modalmenu__userlink {
					display: inline-block;
					margin-top: 5px;
					// margin-left: 58px;
				}
			}
			&--unlogged {
				.modalmenu__userpic {
					width: 49px;
					height: 49px;
					border-radius: 50%;
					border: 3px solid #82d9a8;
					background: #82d9a8;
					display: flex;
					justify-content: center;
					align-items: center;
					& /deep/ div {
						display: flex;
						justify-content: center;
						align-items: center;
					}
					& /deep/ svg {
						width: 60%;
						height: auto;
					}
				}
			}
		}
		&__menu-list {
			list-style: none;
		}
		&__menu-item {
			&:not(:last-child) {
				border-bottom: 1px solid #e6e6e6;
			}
		}
		&__menu-link {
			display: flex;
			font-size: 17px;
			line-height: 20px;
			padding: 15px 15px 15px 50px;
			color: $color-text-dark;
		}
		&__user-box {
			display: flex;
		}
		&__userinfo {
			display: flex;
			flex-direction: column;
			justify-content: center;
			margin-left: 10px;
		}
		&__footer {
			margin-top: 25px;
		}
		&__footer-list {
			list-style: none;
		}
		&__footer-link {
			display: flex;
			font-size: 14px;
			line-height: 18px;
			padding: 15px 15px 15px 50px;
			color: $color-text-dark;
			span {
				color: $color-base-accent;
			}
		}
	}

	.createorder {
		color: $color-text-light;
		&__btn {
			color: $color-text-light;
			background-color: #0078ff;
			text-decoration: none;
			text-align: center;
			padding: 10px 22px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 32px;
			font-size: 15px;
			max-height: 44px;
			&:hover {
				background-color: #0079b2;
			}
			@media (max-width: 768px) {
				display: none;
			}
		}
		&__plus {
			display: none;
			@media (max-width: 768px) {
				display: flex;
				justify-content: center;
				align-items: center;
				text-decoration: none;
				position: fixed;
				// @include w-h(76px);
				@include w-h(45px);
				background-color: #0078ff;
				box-shadow: 0 1px 14px 0 rgba(0, 120, 255, 0.55);
				border-radius: 50%;
				color: #fff;
				font-size: 45px;
				// right: 4%;
				// bottom: 4%;
				right: 31px;
				bottom: 100px;
				z-index: 3;
			}
		}
	}
	.profile {
		color: $color-text-light;
		position: relative;
		&--logged {
			@media (max-width: 768px) {
				position: static;
			}
		}
		&__box {
			display: flex;
			padding: 7px;
			border-radius: 10px;
			background-color: $color-base-accent;
		}
		&__box-hover {
			@media(min-width: 768px) {
				&:hover {
					background-color: #329b78;
				}
			}
		}
		&__content {
			display: flex;
			flex-direction: column;
			justify-content: center;
			margin-left: 10px;
			min-width: 120px;
		}
		&__title {
			font: $font-semibold;
			color: $color-text-light;
			font-size: 13px;
			line-height: 16px;
			margin-bottom: 3px;
		}
		&__pic {
			cursor: pointer;
			&--notice {
				position: relative;
				&::after {
					content: "";
					position: absolute;
					display: block;
					width: 10px;
					height: 10px;
					border-radius: 50%;
					background: #ff2626;
					right: 0;
					top: 0;
				}
			}
		}
		&__enter-box {
			span {
				margin: 0 2px;
			}
		}
		&__enter {
			cursor: pointer;
			color: white;
			font-weight: 500;
			text-decoration: none;
			&:hover {
				color: #0a5f87;
			}
		}
		&__enter,
		&__company {
			font-size: 13px;
			line-height: 16px;
		}
		&__pic--logged {
			width: 37px;
			height: 37px;
			border-radius: 50%;
			background-color: #f6f6f6;
			background: url(../../assets/img/login_thumb.png) no-repeat;
			background-size: cover;
			background-position: center;
		}
	}
	.profilemodal {
		position: absolute;
		// pointer-events: none;
		top: 57px;
		transition: opacity 0.5s;
		opacity: 0;
		height: 0;
		overflow: hidden;
		z-index: 3;
		&--active {
			opacity: 1;
			height: auto;
			overflow: visible;
		}
		&--logged {
			@media (min-width: 769px) {
				left: -119px;
			}
			@media (max-width: 768px) {
				top: 87px;
				right: 0;
				opacity: 1;
				height: calc(100vh - 87px);
				background: #fff;
				transform: translateX(200%);
				transition: transform 0.5s;
				&.profilemodal--active {
					opacity: 1;
					height: calc(100vh - 87px);
					transform: translateX(0);
				}
				.profilemodal__box {
					border-radius: 0;
					height: 100%;
				}
				.profilemodal__box::before {
					display: none;
				}
			}
			@media (max-width: 425px) {
				width: 95%;
				.profilemodal__box {
					width: 100%;
				}
			}
		}
		&--unlogged {
			left: -79px;
			@media (max-width: 768px) {
				left: -158px;
			}
		}
		&__box {
			background: #fff;
			padding: 0 10px;
			border-radius: 16px;
			box-shadow: 0 2px 6px 0 rgba(69, 91, 99, 0.18);
			&::before {
				content: "";
				position: absolute;
				top: -8px;
				right: 50%;
				margin-right: -10px;
				display: block;
				width: 0;
				height: 0;
				border-style: solid;
				border-width: 0 10px 12px 10px;
				border-color: transparent transparent rgb(255, 255, 255) transparent;
				@media (max-width: 768px) {
					right: 15px;
					margin-right: 0;
				}
			}
		}
		.entermodal {
			width: 210px;
			display: flex;
			flex-direction: column;
			&__link {
				padding: 15px 0;
				color: $color-text-dark;
				width: 100%;
				&:not(:last-child) {
					border-bottom: 1px solid #e6e6e6;
				}
			}
		}
		.accountmenu {
			width: 289px;
			color: $color-text-dark;
			padding-top: 20px;
			font-size: 14px;
			@media (max-width: 425px) {
				width: 100%;
			}
			&__profile {
				display: flex;
			}
			&__profile-content {
				display: flex;
				flex-direction: column;
				margin-left: 10px;
			}
			&__name {
				font: $font-semibold;
				font-size: 14px;
				line-height: 18px;
			}
			&__company {
				font-size: 14px;
				line-height: 18px;
			}
			&__userpic {
				width: 65px;
				height: 65px;
				border-radius: 50%;
				background: $color-base-accent;
				background: url(../../assets/img/login_thumb.png) no-repeat;
				background-size: cover;
				background-position: center;
			}
			&__office {
				margin-top: 15px;
				color: $color-base-accent;
			}
			&__list {
				list-style: none;
				margin-top: 20px;
			}
			&__item {
				display: flex;
				align-items: center;
				border-top: 1px solid #e6e6e6;
				padding: 10px 0;
				text-decoration:none;
				&--logout{
					cursor: pointer;
				}
			}
			&__icon {
				width: 50px;
				display: flex;
				justify-content: center;
				margin-right: 15px;
			}
			&__link {
				padding: 10px 0;
				color: $color-text-dark;
				font-size: 14px;
				text-decoration: none;
			}
			&__value {
				background-color: $color-base-accent;
				color: $color-text-light;
				border-radius: 25px;
				padding: 5px 25px;
				margin-left: auto;
			}
			&__scores {
				margin-left: auto;
				font-size: 14px;
				line-height: 24px;
				color: #000;
			}
			&__notification {
				display: flex;
				justify-content: center;
				align-items: center;
				border-radius: 50%;
				background-color: #0078ff;
				font-size: 13px;
				width: 31px;
				height: 31px;
				color: $color-text-light;
			}
		}
	}

	.notablet {
		@media (max-width: 768px) {
			display: none;
		}
	}
	// development
	.hide {
		display: none;
	}
}
</style>
<script>
import Logo from "@/components/Logo.vue";
import footerLogo from "@/components/logo/footerLogo.vue";
import iconUserpicThumb from "@/components/icons/iconUserpicThumb.vue";
import iconProfile from "@/components/icons/asidemenu/iconProfile.vue";
import iconPortfolio from "@/components/icons/asidemenu/iconPortfolio.vue";
import iconStatus from "@/components/icons/asidemenu/iconStatus.vue";
import iconBalance from "@/components/icons/asidemenu/iconBalance.vue";
import iconNotification from "@/components/icons/asidemenu/iconNotification.vue";
import iconLogout from "@/components/icons/iconLogout.vue";
import { mapState, mapActions } from "vuex";

export default {
	components: {
		Logo,
		footerLogo,
		iconUserpicThumb,
		iconProfile,
		iconPortfolio,
		iconStatus,
		iconBalance,
		iconNotification,
		iconLogout
	},
	data() {
		return {
			isProfileNoty: false,
			modalmenuShow: false,
			modalprofileShow: false
		};
	},
	created() {
		window.addEventListener("click", event => {
			this.clickListen(event);
		});
	},
	watch: {
		$route: {
			handler: function(newVal, oldVal) {
				if (newVal !== oldVal) {
					this.hideAll();
				}
			}
		}
	},
	computed: {
		...mapState("user", ["profile", "token"]),
		isAuth() {
			return !!this.token && !!this.profile;
		}
	},
	methods: {
		linkToPortfolio(){
			this.yandexReachGoal('dobavit_companiyu');
			this.googleReachGoal('dobavit_companiyu');
			this.$router.push('/portfolio').catch(()=>{});
		},
		linkToFAQ(){
			this.yandexReachGoal('agent_faq');
			// this.$router.push('/faq').catch(()=>{});
			location.href = '/faq';
		},
		openForm(form) {
			this.$root.$emit("openForm", form)
		},
		clickActionLink(payload) {
			if (payload == 'registrationForm'){
				this.yandexReachGoal('agent_registration');
				this.googleReachGoal('agent_registration');
			}
			if (payload == 'authorizationForm'){
				this.yandexReachGoal('vhod_agent');
				this.googleReachGoal('vhod_agent');
			}
			this.$emit("showForm", payload);
			this.hideAll();
		},
		clickListen(event) {
			if (event.target.classList.contains("body-overlay") || event.target.classList.contains("body-overlay--transparent")) {
				this.hideAll();
			}
		},
		...mapActions("user", ["logout"]),
		showModalmenu() {
			this.modalmenuShow = true;
			this.modalprofileShow = false;
			document.body.classList.add("body-overlay");
			document.scrollingElement.style.overflow = "hidden";
		},
		hideModalmenu() {
			this.modalmenuShow = false;
			document.body.classList.remove("body-overlay");
			document.scrollingElement.style.overflow = "visible";
		},
		toggleProfile() {
			document.body.classList.toggle("body-overlay--transparent");
			this.modalprofileShow = !this.modalprofileShow;
			this.modalmenuShow = false;
			if(this.isAuth) {
				if(document.scrollingElement.style.overflow == 'hidden') {
					document.scrollingElement.style.overflow = "visible";
				} else {
					document.scrollingElement.style.overflow = "hidden";
				}
			}
		},
		hideAll() {
			document.body.classList.remove("body-overlay");
			document.body.classList.remove("body-overlay--transparent");
			document.scrollingElement.style.overflow = "visible";
			this.modalmenuShow = false;
			this.modalprofileShow = false;
		},
		hideProfileModal() {
			this.modalprofileShow = false;
		}
	}
};
</script>