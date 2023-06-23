<template functional>
	<svg xmlns="http://www.w3.org/2000/svg" width="13.5" height="17.5" viewBox="0 0 13.5 17.5">
		<g id="bar-chart" transform="translate(-5.25 -3.25)">
			<path id="Line_824" d="M0 10V0" class="cls-1" :stroke="props.color" data-name="Line 824" transform="translate(12 10)"/>
			<path id="Line_825" d="M0 16V0" class="cls-1" :stroke="props.color" data-name="Line 825" transform="translate(18 4)"/>
			<path id="Line_826" d="M0 4V0" class="cls-1" :stroke="props.color" data-name="Line 826" transform="translate(6 16)"/>
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

<style scoped>
	.cls-1{
		fill:none;
		stroke-linecap:round;
		stroke-linejoin:round;
		stroke-width:1.5px;
	}

</style>