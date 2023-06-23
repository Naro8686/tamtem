<template lang="pug">
	ul.aside__navigation.asidenav
		li.asidenav__item
			router-link(to="/profile" v-if="isAuth").asidenav__link 
				i.asidenav__icon
					iconProfile(:color="iconColor")
				span.asidenav__text Профиль
			a(href="javascript:void(0)" v-else @click="openForm('authorizationForm')").asidenav__link 
				i.asidenav__icon
					iconProfile(:color="iconColor")
				span.asidenav__text Профиль
		li.asidenav__item
			router-link(to="/portfolio" v-if="isAuth").asidenav__link 
				i.asidenav__icon
					iconPortfolio(:color="iconColor")
				span Портфель компаний
			a(href="javascript:void(0)" v-else @click="openForm('authorizationForm')").asidenav__link.asidenav__link 
				i.asidenav__icon
					iconPortfolio(:color="iconColor")
				span Портфель компаний
		li.asidenav__item
			router-link(to="/status" v-if="isAuth").asidenav__link
				i.asidenav__icon
					iconStatus(:color="iconColor")
				span Статус
				p(v-if="isAuth").asidenav__link-inner {{(profile.points+profile.points_from_agents)|pluralizeRus('балл')}}
			a(href="javascript:void(0)" v-else @click="openForm('authorizationForm')").asidenav__link.asidenav__link
				i.asidenav__icon
					iconStatus(:color="iconColor")
				span Статус
		li.asidenav__item
			router-link(to="/balance" v-if="isAuth").asidenav__link 
				i.asidenav__icon
					iconBalance(:color="iconColor")
				span Баланс
				p(v-if="isAuth").asidenav__link-inner {{profile.ballance|priceFormat}} ₽
			a(href="javascript:void(0)" v-else @click="openForm('authorizationForm')").asidenav__link.asidenav__link 
				i.asidenav__icon
					iconBalance(:color="iconColor")
				span Баланс
				p(v-if="isAuth").asidenav__link-inner {{profile.ballance|priceFormat}} ₽
		div#yandex_rtb_R-A-506599-1
		//- li.asidenav__item
			router-link(to="/finance" :class="{'asidenav__link--disable' : !isAuth}").asidenav__link 
				i.asidenav__icon
					iconFinance(:color="iconColor")
				span Финансовые операции
		//- li.asidenav__item
			router-link(to="/notifications" :class="{'asidenav__link--disable' : !isAuth}").asidenav__link 
				i.asidenav__icon
					iconNotification(color="#707070")
				span Уведомления
</template>
<script>
import iconProfile from '@/components/icons/asidemenu/iconProfile.vue'
import iconPortfolio from '@/components/icons/asidemenu/iconPortfolio.vue'
import iconStatus from '@/components/icons/asidemenu/iconStatus.vue'
import iconBalance from '@/components/icons/asidemenu/iconBalance.vue'
import iconNotification from '@/components/icons/asidemenu/iconNotification.vue'
import iconFinance from '@/components/icons/asidemenu/iconFinance.vue'
import { mapState } from 'vuex'
export default {
	components: {
		iconProfile,
		iconPortfolio,
		iconStatus,
		iconBalance,
		iconNotification,
		iconFinance
	},
	computed:{
		...mapState("user", ["profile", "token"]),
		isAuth() {
			return !!this.token && this.profile && Object.keys(this.profile).length>0;
		},
		iconColor() {
			if(this.isAuth) {
				return '#2fc06e'
			} else {
				return '#707070'
			}
		}
	},
	methods: {
		openForm(form) {
			this.$root.$emit("openForm", form)
		}
	}
}
</script>
<style lang="scss" scoped>
.asidenav {
	list-style: none;
	padding: 0;
	border: solid 1px #ececec;
	border-radius: 10px;
	overflow: hidden;
	&__link {
		display: flex;
		align-items: center;
		padding: 20px 20px;
		color: $color-text-gray;
		text-decoration: none;
		transition: 0.2s;
		&:hover {
			color: $color-text-light;
			background-color: $color-base-accent;
			.asidenav__icon {
				& /deep/ svg {
					stroke: $color-text-light;
					path, circle, rect {
						stroke: $color-text-light;
					}
				}
			}
		}
		&--disable {
			pointer-events: none;
		}
	}
	&__link-inner {
		margin-left: auto;
	}
	&__icon {
		margin-right: 25px;
		display: flex;
		justify-content: center;
		width: 25px;
	}
}
.yandex_rtb_R-A-506599-1{
	border: none;
	width: 100%;
	justify-content: center;
	align-items: center;
}
</style>

