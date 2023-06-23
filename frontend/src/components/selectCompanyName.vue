<template functional lang="pug">
	div.companyselect
		ul.companyselect__list
			li.companyselect__item(v-for="company in props.companies")
				a(v-if="props.inn.length==12" href="javascript:void(0);" @click.stop="listeners['selectCompany'](company)").companyselect__target 
					p {{company.value}}
					span {{ company.data.kpp ? `КПП: ${company.data.kpp} ` : "" }} {{ company.data.address.value }}
				a(v-else href="javascript:void(0);" @click.stop="listeners['selectCompany'](company)").companyselect__target 
					p {{company.value}}
					span {{ company.data.kpp ? `КПП: ${company.data.kpp} ` : "" }} {{ company.data.address.value }}
</template>
<script>
export default {
  props: {
    companies: {
      type: [Array, Object]
    }
  }
};
</script>
<style lang="scss" scoped>
.companyselect {
  z-index: 3;
  width: 100%;
  background: #fff;
  &__list {
    border: 1px solid $color-border-gray;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top: none;
    overflow-y: scroll;
    height: 128px;
  }
  &__item {
    list-style: none;

    cursor: pointer;
    &:not(:last-child) {
      border-bottom: 1px solid $color-border-gray;
    }
    &:hover {
      background: $color-pale-green;
      color: #000;
    }
    &:active {
      color: $color-text-dark;
    }
  }
  &__target {
    background: $color-base-light;
    width: 100%;
    display: flex;
    align-items: center;
    height: 63px;
    padding: 12px;
    color: $color-text-gray;
    &:hover {
      background: $color-pale-green;
      color: #000;
    }
    &:active {
      color: $color-text-gray;
    }
  }
}
</style>