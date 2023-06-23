<template lang="pug">
div.bidcard
	.bidcard__header
		h3.bidcard__title Заказ:&nbsp;{{bid.name}}
		button.bidcard__vendors Список поставщиков
	.bidcard__body
		div.bidcard-body-descr
			span Тип сделки: {{bid.dqh_type_deal}}
			span Объём: {{bid.dqh_volume}} {{bid.unit_for_all}}
			span Минимальная партия: {{bid.dqh_min_party}}
	hr.bidcard__divider
	.bidcard__footer
		.bidcard__location
			feather-map-pin
			span.bidcard__location-text {{bid.region}}
		.bidcard__budget
			p.bidcard__budget-cap Средняя сумма заказа: 
			span {{priceFormat(bid.budget_all)}} ₽
			//-span &nbsp;&ndash;&nbsp;
			//-span {{bid.budget_to}}
			//-span.budget-rubl &nbsp;&#8381;,&nbsp;
			//-span {{bid.budget_with_nds ? 'с' : 'без'}} НДС
</template>

<script>
import featherMapPin from "@/components/icons/featherMapPin.vue";
export default {
  data() {
    return {
      show: true
    };
  },
  props: {
    bid: Object
	},
	methods: {
	priceFormat(price) {
      const p = parseFloat(price, 10);
      if (p === 0) {
        return p;
      } else {
        if (p !== null && p !== false) {
          return p.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ");
        }
      }
		}
	},
  components: {
    featherMapPin
  }
};
</script>

<style lang="scss" scoped>
.bidcard {
  border-bottom: solid 1px $color-border-gray;
  border-top: solid 1px $color-border-gray;
  height: 100%;
  display: flex;
  flex-direction: column;
  background: #fff;
  color: #000;
  &__header {
    border-bottom: none;
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 22px;
    padding: 15px 20px 15px 25px;
    min-height: 61px;
    border-bottom: 1px solid #ececec;
    @media (max-width: 425px) {
      flex-direction: column;
    }
  }
  &__title {
    color: #000000;
    font-weight: 500;
    font-size: 18px;
    line-height: 28px;
    overflow: hidden;
    width: 85%;
    word-wrap: break-all;
    margin: 0;
    @media (max-width: 425px) {
      font-size: 14px;
      line-height: 20px;
      order: 2;
      margin-top: 10px;
    }
    @media (max-width: 320px) {
      font-size: 12px;
    }
  }
  &__vendors {
    @include flex-centerizer;
    // @include w-h(167px, 34px);
    width: 167px;
    max-width: 167px;
    min-height: 34px;
    padding: 5px;
    margin-top: 2px;
    border-radius: 35px;
    color: #000000;
    background: $color-pale-green;
    font-size: 12px;
    border: none;
    cursor: pointer;
    @media (max-width: 425px) {
      order: 1;
      align-self: flex-end;
      background: none;
      text-decoration: underline;
      color: $color-base-accent;
      width: auto;
      min-height: auto;
      padding: 0;
    }
  }
  &__body {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px 0 25px;
  }
  &__divider {
    background-color: #ececec;
    height: 1px;
    margin: 18px 20px 10px 25px;
    border: none;
  }
  &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px 5px 25px;
    border-top: none;
    @media (max-width: 425px) {
      flex-direction: column;
      align-items: flex-start;
    }
  }

  &__location {
    display: flex;
    justify-content: space-between;
    align-items: center;
    &-text {
      font-size: 12px;
      color: #000;
    }
    & /deep/ svg {
      color: #000000;
      height: 14px;
      @media (max-width: 425px) {
        transform: translateX(-5px);
      }
    }
  }
  &__budget {
    display: flex;
    @media (max-width: 425px) {
      margin-top: 10px;
    }
    &-cap {
      margin-right: 15px;
    }
    span {
      font-weight: 500;
    }
  }
  .text-small {
    line-height: 15px;
    margin-left: 3px;
  }
  &-body {
    &-descr {
      word-wrap: break-all;
      min-height: 43px;
      font: $font-regular;
      font-size: $fontsize-base;
      color: black;
      line-height: 19px;
      max-height: 80px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
  }
}
</style>