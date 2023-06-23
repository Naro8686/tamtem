<template functional lang="pug">
section.companies-cards__card.company-card
	component(:is="injections.components.categoryPill" :text="props.company.category_name")
	p.company-card__name {{props.company.name}}
	b.company-card__summ + {{props.company.response_ballance|priceFormat}} #[i  ₽]
	p.company-card__date(v-if="props.company.activated_at") {{props.company.activated_at|dateFormat}}
	ul.company-card__stats
		li.company-card__offers Предложения {{props.company.points_set_winner}}
		li.company-card__orders Отклики {{props.company.points_response}}
</template>

<script>
import categoryPill from "@/components/categoryPill.vue";
export default {
  props: { 
		company: { 
			type: Object, 
			required: true 
		} 
	},
  inject: {
    components: {
      default: {
        categoryPill
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.company-card {
  background: #fff;
  padding: 12px 5px;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 20px;
  grid-template-areas:
    "ctg ."
    "name summ"
    "date ."
    "stats stats";
  border: 1px solid #ececec;
  border-radius: 9px;
  border-left-width: 3px;
  &:not(:last-child) {
    margin-bottom: 20px;
  }
  &__ctg {
    grid-area: ctg;
  }
  &__name {
    grid-area: name;
    font-size: 13px;
  }
  &__summ {
    grid-area: summ;
    font-size: 13px;
    font-weight: 600;
    i {
      font-weight: normal;
      font-style: normal;
    }
  }
  &__date {
    grid-area: date;
    color: $color-base-accent;
    font-size: 12px;
    font-weight: 500;
  }
  &__stats {
    grid-area: stats;
    list-style: none;
    display: grid;
    grid-template-columns: auto auto auto;
    background: #f6f6f6;
    border: 1px solid #ececec;
    border-radius: 4px;
    font-size: 12px;
    li {
      @include flex-centerizer;
      width: 100%;
      padding: 10px 5px;
      &:not(:last-child) {
        border-right: 1px solid #ececec;
      }
    }
  }
}
</style>