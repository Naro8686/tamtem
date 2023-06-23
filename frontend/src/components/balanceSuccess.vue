<template lang="pug">
section.balance-success
	div.balance-success__pic
		icon-tick
	h2.balance-success__summ ₽ {{summ|priceFormat}}
	p.balance-success__cap Успешно зачислены на ваш счет
	button.balance-success__button(@click="$emit('close')") Вернуться в кошелёк
</template>

<script>
import iconTick from "@/components/icons/iconTick.vue"
export default {
	components: {
		iconTick
	},
	props:{
		summ:{
			type: [String,Number]
		}
	}
}
</script>

<style lang="scss" scoped>
.balance-success {
	@include contentbox;
	font-family: $font-family;
	display: flex;
	flex-direction: column;
	align-items: center;
	min-height: 500px;
	&__pic {
		background-color: $color-base-accent;
		border-radius: 50%;
		@include flex-centerizer;
		@include w-h(73px);
		margin-top: 30px;
	}
	&__summ {
		font-size: 32px;
		font-weight: 500;
		line-height: 24px;
		color: #000;
		margin-top: 60px;
	}
	&__cap {
		font-size: 14px;
		font-weight: 400;
		line-height: 19px;
		color: #000;
		margin-top: 10px;
	}
	&__button {
		cursor: pointer;
		background-color: $color-base-accent;
		color: #fff;
		font-size: 14px;
		font-weight: 600;
		@include flex-centerizer;
		border-radius: 32px;
		border: none;
		@include w-h(270px, 43px);
		margin-top: 70px;
	}
}
</style>