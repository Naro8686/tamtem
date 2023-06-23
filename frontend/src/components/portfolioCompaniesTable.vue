<template functional lang="pug">
section
	.companies-table
		.companies-table__header
			.companies-table__header-row.companies-table__row
				.companies-table__header-cell Компании
				.companies-table__header-cell Категории
				.companies-table__header-cell Предложения
				.companies-table__header-cell Отклики
				.companies-table__header-cell Сумма начислений
		.companies-table__body
			template(v-if="props.companiesList.length>0")
				.companies-table__row(:key="company.id" v-for="company in props.companiesList")
					.companies-table__cell(data-cell="company")
						p.cell-name {{company.name}}
						div.cell-info(v-if="company.activated_at")
							span.cell-info-reg Регистрация
							span.cell-info-date {{company.activated_at|dateFormat}}
					.companies-table__cell(data-cell="categories")
						component(:is="injections.components.categoryPill" :text="company.category_name")
					.companies-table__cell(data-cell="offers")
						span.cell-offers {{company.points_set_winner}}
					.companies-table__cell(data-cell="deals")
						span.cell-deals {{company.points_response}}
					.companies-table__cell(data-cell="summ")
						span.cell-summ {{company.response_ballance|priceFormat}}  #[i ₽]
			template(v-else)
				.companies-table__row
					.companies-table__cell.companies-table__cell--empty Нет данных			
</template>
<script>
import categoryPill from "@/components/categoryPill.vue";
export default {
  props: {
    companiesList: {
      type: Array
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
.companies-table {
  @media (max-width: 600px) {
    display: none;
  }
  &__row {
    display: grid;
    grid-template-columns: 27% 18% 1fr 1fr 1fr;
  }
  &__header {
    overflow: hidden;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
  }
  &__header-cell {
    text-align: center;
    background-color: #f6f6f6;
    border: solid 1px #ececec;
    padding: 10px 10px;
    font-weight: 600;
    min-height: 72px;
    display: flex;
    align-items: center;
    font-size: 12px;
    justify-content: center;
    word-break: break-word;
  }
  &__cell {
    border: 1px solid #ececec;
    background-color: #fff;
    padding: 10px 5px;
    display: flex;
    font-size: 12px;
    line-height: 19px;
    align-items: center;
    min-height: 60px;
    word-break: break-all;
    justify-content: center;
    p,
    span,
    div,
    i {
      font-size: inherit;
    }
    &[data-cell="company"] {
      flex-direction: column;
      align-items: flex-start;
      word-break: break-word;
      .cell-info {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        width: 100%;
        &-reg {
          margin-right: 10px;
        }
        &-date {
          color: $color-base-accent;
        }
      }
    }
    &[data-cell="categories"] {
      font-size: 10px;
    }
    &[data-cell="summ"] {
      font-weight: 600;
      i {
        font-style: normal;
        font-weight: normal;
      }
    }
    &--empty {
      grid-column: 1/7;
      font-weight: 600;
    }
  }
  &__body {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;

    .companies-table__row {
      transition: all ease-in-out 0.2s 0.2s;
			&:not(:last-child) {
				margin-bottom: 20px;
			}
      &:hover {
        transition: all ease-in-out 0.2s 0.2s;
        box-shadow: 0 2px 6px 0 rgba(69, 91, 99, 0.18);
        transform: scale(1.019, 1.12);
      }
    }
  }
}
</style>