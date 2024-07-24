<template lang="pug">
  section.meta-content
    div.container(ref="contentDiv", :class="{ 'expanded': isExpanded }")
      slot
    div.container
      a.read-more.animation-link-underline(v-if="isTruncated" @click="toggleExpand") {{ isExpanded ? 'Скрыть' : 'Читать дальше' }}
</template>

<script>
export default {
  name: 'MetaContent',
  data() {
    return {
      isExpanded: false,
      isTruncated: false
    }
  },
  mounted() {
    this.$nextTick(this.checkIfTruncated);
    window.addEventListener('resize', this.checkIfTruncated); // Recheck on window resize
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkIfTruncated);
  },
  methods: {
    toggleExpand() {
      this.isExpanded = !this.isExpanded;
    },
    checkIfTruncated() {
      this.$nextTick(() => {
        const contentDiv = this.$refs.contentDiv;

        // Get the computed styles for container
        const style = getComputedStyle(contentDiv);
        const lineHeight = parseFloat(style.lineHeight);
        const maxLines = 10; // Maximum number of lines to show
        const maxHeight = lineHeight * maxLines;

        // Calculate total height required for the content
        const totalHeight = contentDiv.scrollHeight;

        // Determine if content exceeds maximum height
        this.isTruncated = totalHeight > maxHeight;
      });
    }
  }
}
</script>

<style scoped>
.meta-content {
  padding-bottom: 50px !important;
}

.meta-content > .container:first-child {
  max-height: 250px; /* Adjust based on the estimated height to display 10 lines */
  overflow: hidden;
}

.meta-content > .container.expanded {
  max-height: none;
}

.meta-content h1 {
  text-align: left !important;
  font-weight: 800 !important;
  font-size: 54px !important;
  color: #2C3444 !important;
  margin-bottom: 10px !important;
  line-height: 45px !important;
}

.meta-content h2 {
  text-align: left !important;
  font-style: normal !important;
  font-weight: 600 !important;
  font-size: 44px !important;
  color: #2C3444 !important;
  margin-bottom: 10px !important;
  line-height: 45px !important;
}

.meta-content p {
  font-weight: normal !important;
  font-size: 24px !important;
  line-height: 30px !important;
  color: #2C3444 !important;
  text-align: left !important;
  margin-bottom: 30px !important;
}

.meta-content .container:has(> a.read-more) {
  margin-top: 15px !important;
}

.meta-content a.read-more {
  cursor: pointer !important;
  text-decoration: none !important;
  color: #413f3f !important;
  font-size: 15px !important;
  position: relative !important;
}

.meta-content a.read-more:hover {
  color: #000000 !important;
}
</style>
