<template functional lang="pug">
div
	template(v-if="props.variant == 'base-unlogged'")
		svg(xmlns="http://www.w3.org/2000/svg" width="37.066" height="37.066")
			defs
				clipPath(id="a")
					circle(cx="18.533" cy="18.533" r="18.533" fill="#fff" stroke="#fff" stroke-width="2")
			g
				g(fill="none" stroke="#fff" stroke-width="1.5")
					circle(cx="18.533" cy="18.533" r="18.533" stroke="none")
					circle(cx="18.533" cy="18.533" r="17.783")
				g(clip-path="url(#a)")
					g(fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5")
						g(transform="translate(12.725 6.436)")
							circle(cx="5.945" cy="5.945" stroke="none" r="5.945")
							circle(cx="5.945" cy="5.945" r="5.195")
						g
							path(d="M18.642 21.869A12.752 12.752 0 0131.39 34.621v2.834H5.89v-2.834a12.752 12.752 0 0112.752-12.752z" stroke="none")
							path(d="M18.642 22.619h0a12 12 0 0112 12v1.45a.632.632 0 01-.632.632H7.272a.632.632 0 01-.632-.632v-1.448a12 12 0 0112.002-12.002z")
	template(v-if="props.variant == 'base-logged'")

	template(v-if="props.variant == 'modal-unlogged'")
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#ffffff" d="M256 314.134C112.765 314.134.565 380.505.565 465.235v26.083C.565 502.741 9.825 512 21.247 512s20.682-9.259 20.682-20.682v-26.083c0-59.484 98.032-109.737 214.071-109.737s214.071 50.253 214.071 109.737v26.083c0 11.423 9.259 20.682 20.682 20.682 11.423 0 20.682-9.26 20.682-20.682v-26.083c0-84.73-112.2-151.101-255.435-151.101zM380.793 106.679c-3.963-26.728-16.158-50.955-35.265-70.062s-43.334-31.3-70.063-35.264a124.943 124.943 0 00-36.675 0c-68.189 10.112-115.438 73.814-105.327 142.003 4.898 33.032 22.367 62.18 49.188 82.073 21.774 16.15 47.593 24.632 74.213 24.631 6.171 0 12.386-.456 18.601-1.378 68.19-10.112 115.439-73.814 105.328-142.003zM269.399 207.765c-22.098 3.279-44.158-2.247-62.104-15.559-17.947-13.311-29.635-32.815-32.912-54.917-6.766-45.628 24.85-88.253 70.477-95.019a83.745 83.745 0 0124.541 0c36.712 5.444 65.034 33.767 70.478 70.478 6.763 45.627-24.853 88.252-70.48 95.017z"/></svg>
	template(v-if="props.varian == 'modal-logged'")
</template>
<script>
export default {
	props: {
		variant: String
	}
}
</script>
<style lang="scss" scoped>

</style>