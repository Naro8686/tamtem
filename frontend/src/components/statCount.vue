<template lang="pug">
	div.statcount
		span(v-for="char in str").statcount__letter {{char}}
</template>

<script>
export default {
	props: {
		str: String,
	},
}
</script>
<style lang="scss" scoped>
	.statcount {
		display: flex;
	}
	.statcount__letter {
		@include flex-centerizer;
		@include w-h(22px, 36px);
		border-radius: 4px;
		font-size: 18px;
		font-weight: 500;
		background: $color-pale-green;
		color: $color-base-accent;
		margin-right: 3px;
		&:nth-child(3n+0) {
			margin-right: 12px;
		}
		&:last-child {
			margin-right: 0;
		}
		@media(max-width: 500px) {
			@include w-h(20px, 30px);
			font-size: 12px;
		}
	}
</style>