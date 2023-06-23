<template lang="pug">
	section.userstatus(v-if="isAuth")
		h1.userstatus__title Программа статусов
		section.userstatus__status
			.no-desktop.userstatus__bars
				div.userstatus__statebar.userstatus-col
					i
						img(src="../assets/img/cap-status.png")
					p Статус
					b {{userData.profile.privilege.name}}
				div.userstatus__scorebar.userstatus__scorebar--bright.userstatus-col {{(userData.profile.points+userData.profile.points_from_agents)|pluralizeRus('балл')}}
			h2.userstatus__cap Ваш статус
			.userstatus-row
				p.userstatus__field.userstatus-col Доход от сделки #[b.userstatus__att {{userData.profile.privilege.procent}}%]
				div.no-mobile.userstatus__statebar.userstatus-col
					i
						img(src="../assets/img/cap-status.png")
					p Статус
					b {{userData.profile.privilege.name}}
			.userstatus-row
				p.userstatus__field.userstatus-col Содержание компаний в портфеле #[b.userstatus__att {{(Math.floor(userData.profile.privilege.duration_months/12))|pluralizeRus('год')}} ]
				div.no-mobile.userstatus__scorebar.userstatus__scorebar--bright.userstatus-col {{(userData.profile.points+userData.profile.points_from_agents)|pluralizeRus('балл')}}
			//- ul.userstatus__stats
				li.userstatus__orders.userstatus__stats-item Заказов #[span 12]
				li.userstatus__offers.userstatus__stats-item Предложений #[span 15]
		//-section.userstatus__description
			h2.userstatus__cap Программа статусов
			div.userstatus-row
				p.userstatus__field.userstatus-col Бронзовый статус
				p.userstatus__scorebar.userstatus__scorebar--pale.userstatus-col 500 баллов
			div.userstatus-row
				p.userstatus__field.userstatus-col Серебряный статус
				p.userstatus__scorebar.userstatus__scorebar--pale.userstatus-col 5 000 баллов
			div.userstatus-row
				p.userstatus__field.userstatus-col Золотой статус 
				p.userstatus__scorebar.userstatus__scorebar--pale.userstatus-col 15 000 баллов
			div.userstatus-row
				p.userstatus__field.userstatus-col Платиновый статус 
				p.userstatus__scorebar.userstatus__scorebar--pale.userstatus-col 50 000 баллов
	section(v-else)
		p Чтобы пользоваться личным кабинетом, нужно авторизоваться
</template>

<style lang="scss" scoped>
.userstatus {
	&__title {
		@include blocktitle;
	}
	&__status {
		@include contentbox;
		margin-bottom: 55px;
	}
	&__description {
		@include contentbox;
	}
	&__statebar {
		@include statebar;
		max-width: 224px;
		@media(max-width: 425px) {
			font-size: 12px;
		}
		p {
			width: auto;
		}
		b {
			margin-left: auto;
		}
	}
	&__scorebar {
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 5px 20px;
		border-radius: 32px;
		font-size: 17px;
		font-weight: 500;
		min-height: 43px;
		text-align: center;
		max-width: 224px;
		@media(max-width: 768px) {
			height: 40px;
		}
		@media(max-width: 425px) {
			padding: 5px 16px;
			height: 32px;
			font-size: 12px;
		}
		&--bright {
			background: linear-gradient(179deg, #5fefc0, #2fc06e);
			color: $color-text-light;
		}
		&--pale {
			background: #ececec;
			color: $color-text-dark;
		}
	}
	&__field {
		@include hamster-field;
	}
	&__att {
		color: $color-base-accent;
		font-size: 22px;
		font-weight: 500;
		margin-left: 8px;
		@media(max-width: 768px) {
			font-size: 20px;
		}
		@media(max-width: 425px) {
			font-size: 18px;
		}
	}
	&__cap {
		@include hamster-label;
		font-weight: normal;
	}
	
	&__stats {
		display: flex;
		list-style: none;
		flex-wrap: wrap;
		&-item {
			color: $color-text-gray;
			line-height: 19px;
			text-transform: uppercase;
			margin-right: 35px;
			line-height: 24px;
			border-bottom: 1px dashed $color-text-gray;
			@media(max-width: 425px) {
				font-size: 12px;
				margin-right: 20px;
			}
		}
		span {
			margin-left: 10px;
		}
	}

	&__bars {
		display: flex;
		flex-direction: column;
		align-items: center;
		margin-bottom: 20px;
		div {
			width: 100%;
			margin-bottom: 10px;
		}
	}
	.no-desktop {
		@media(min-width: 501px) {
			display: none;
		}
	}
	.no-mobile {
		@media(max-width: 500px) {
			display: none;
		}
	}
	&-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
		&:not(:last-child) {
			margin-bottom: 20px;
		}
		@media(max-width: 500px) {
			flex-direction: column;
		}
		.userstatus-col:first-child {
			width: 63%;
			@media(max-width: 680px) {
				width: 49%;
			}
			@media(max-width: 500px) {
				width: 100%;
			}
		}
		.userstatus-col:last-child {
			width: 35%;
			@media(max-width: 680px) {
				width: 49%;
			}
			@media(max-width: 500px) {
				width: 100%;
				margin-top: 20px;
			}
		}
	}
}
</style>

<script>
import { mapState } from 'vuex';
export default {
	props:['userData'],
	computed: {
		...mapState("user", ["profile", "token"]),
		isAuth() {
			return !!this.token && this.profile && Object.keys(this.profile).length>0;
		},
	},
	watch: {
		isAuth(newVal) {
			if(newVal === false) {
				this.$router.push({name: 'account'})
			}
		}
	},
}
</script>