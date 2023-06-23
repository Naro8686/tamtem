<template functional>
	<svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
		<g id="briefcase" transform="translate(1 1)">
			<rect id="Rectangle-path" width="20" height="14" rx="2" stroke-width="2" transform="translate(0 4)" :stroke="props.color" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" fill="none"/>
			<path id="Shape" d="M8,18V2A2,2,0,0,0,6,0H2A2,2,0,0,0,0,2V18" transform="translate(6)" fill="none" :stroke="props.color" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/>
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