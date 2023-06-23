<template functional>
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19">
	<g fill="none" :stroke="props.color" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"><path d="M5.5.5h-3a2 2 0 00-2 2v14a2 2 0 002 2h3"/>
		<path data-name="Shape" d="M14.5 13.5l4-4-4-4M18.5 9.5h-14"/>
	</g>
</svg>
</template>
<style lang="scss" scoped>

</style>
<script>
export default {
	props: {
		color: String
	}
}
</script>