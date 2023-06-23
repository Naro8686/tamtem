<template lang="pug">
.goback(v-if='isBack')
	button(@click="$router.go(-1)")
		<svg xmlns="http://www.w3.org/2000/svg" width="21.157" height="17.196" viewBox="0 0 21.157 17.196">
			<g id="arrow-left" transform="translate(1 1.414)">
					<path id="Shape" fill="none" d="M19.157 0H0" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" transform="translate(0 8)" stroke-width="2"/>
					<path id="Shape-2"  fill="none" d="M7.184 14.368L0 7.184 7.184 0" transform="translate(0 1)" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-name="Shape"/>
			</g>
		</svg>
</template>

<script>
export default {
	computed: {
    isBack() {
      return window.history.length > 1;
    }
  }
}
</script>

<style lang="scss" scoped>
.goback {
	@include flex-centerizer;
	@include w-h(36px, 30px);
	border: 2px solid #ffffff;
	border-radius: 5px;
}
button {
	background: none;
	border: none;
	cursor: pointer;
}
</style>