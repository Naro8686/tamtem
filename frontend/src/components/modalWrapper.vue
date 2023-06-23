<template lang="pug">
    section.wrapper(:class="containerClass")
        slot
</template>
<script>
export default {
  props: {
    overlayClass: {
      type: String,
      default: "body-overlay"
    },
    hasOverlay: {
      type: Boolean,
      default: true
    },
    closeOnOverlayClick: {
      type: Boolean,
      default: true
    },
    containerClass: {
      type: String,
      default: "modal"
    }
  },
  created() {
    this.$nextTick(()=>{
    if (this.hasOverlay) {
        document.body.classList.add(this.overlayClass);
           
			document.scrollingElement.style.overflow = "hidden";
    }
    if (this.hasOverlay && this.closeOnOverlayClick) {
      const overlayContainer = document.getElementsByClassName(
        this.overlayClass
      )[0];
      if (overlayContainer) {
        overlayContainer.addEventListener("click", event => {
          if (
            event.target.classList.contains(this.overlayClass) ||
            event.target.classList.contains(this.containerClass)
          ) {
            this.$emit("overlayClick");
            this.$emit("close");
          }
        });
      }
    }
      })
  },
  destroyed() {
    if (this.hasOverlay) {
      document.body.classList.remove(this.overlayClass);
			document.scrollingElement.style.overflow = "visible";

    }
  }
};
</script>
<style lang="scss" scoped>
.wrapper {
  z-index: 6;
  display: flex;
  justify-content: center;
  position: fixed;
  left: 0;
  right: 0;
  overflow-y: auto;
  max-height: 100%;
  top: 0;
  bottom: 0;
  padding: 50px 0;
	@media(max-width: 425px) {
		padding: 0;
	}
}
</style>