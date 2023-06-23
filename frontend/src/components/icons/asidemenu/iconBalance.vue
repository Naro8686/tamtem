<template functional>
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18">
		<g id="credit-card" transform="translate(1 1)">
			<rect id="Rectangle-path" width="22" height="16" rx="2" stroke-width="2" :stroke="props.color" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" fill="none"/>
			<path id="Shape" d="M0,0H22" transform="translate(0 6)" fill="none" :stroke="props.color" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/>
		</g>
	</svg>
</template>
<script>
export default {
	props: {
		color: String
	}
}
</script>
<style lang="scss" scoped>

</style>