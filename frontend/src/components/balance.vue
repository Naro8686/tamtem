<template lang="pug">
div.balance-wrap(v-if="isAuth")
	section.balance(v-if="!success")
		h1.balance__title Мой баланс
		.balance__container
			div.balance__items
				section.balance__available
					p.balance__cap Доступно
					div.balance__fieldgroup
						p.balance__field {{profile.ballance|priceFormat}}
						p.balance__field.balance__field--symbol ₽
				section.balance__status
					.balance__statebar
						i
							img(src="../assets/img/cap-status.png")
						p Статус
						b {{profile.privilege.name}}
		h2.balance__title Вывод средств
		//- **************************************************************************************
		//- divider ******************************************************************************
		//- **************************************************************************************
		section.fund
			ul.fund__tab-controls
				li(
					@click="currentTab='sum'"
					:class="{'fund__tab-control--active' : currentTab == 'sum'}"
				).fund__tab-control Сумма
				li( 
					@click="nextMove('system')"
					:class="{'fund__tab-control--active' : currentTab == 'system'}"
				).fund__tab-control Системы вывода средств
				//- li( 
				//- 	@click="nextMove('info')"
				//- 	:class="{'fund__tab-control--active' : currentTab == 'info'}"
				//- ).fund__tab-control Информация
			ul.fund__tab-content
				li(
					:class="{'tabscreen--active' : currentTab == 'sum'}"
				).fund__tab-screen.tabscreen
					div.fund-summ
						p.fund-summ__cap Сумма, которую вы желаете вывести
						div.fund-summ__content
							div.fund-summ__fields-box
								input(
									type="text" 
									placeholder="19 500"
									v-model="summ"
									data-vv-name="summ"
									data-vv-as="Сумма"
									v-validate="`required|minimal:100|money`"
									:class="{'invalid' : errors.has('summ')}"
								).fund-summ__field
								p.fund-summ__field.fund-summ__field--symbol ₽
								p.fund-summ__min Минимум: 100.00 ₽
								p.wrong-message.fund-summ__error(v-if="errors.has('summ')") Вы ввели сумму меньше минимально допустимой. Пожалуйста, введите другую сумму.
							button(
								@click="nextMove('system')"
							).fund__btn.fund-summ__btn.fund__btn--ready Получить
				//- **************************************************************************************
				//- divider ******************************************************************************
				//- **************************************************************************************
				li(
					:class="{'tabscreen--active' : currentTab == 'system'}"
				).fund__tab-screen.tabscreen
					div.systems
						ul.systems-list
							li.systems-list__item
								div.systems-list__box
									input(
										type="radio" 
										name="fund-system" 
										id="fund-card"
										value="visa-master"
										v-model="system"
									).systems-list__input
									label(for="fund-card").systems-list__label.systems-list__label--unable Visa/Mastercard
										div.systems-list__inner
											p.systems-list__pic
												img(src="../assets/img/payment/visa2x.jpg" width="45" height="29" alt="visa")
											p.systems-list__pic
												img(src="../assets/img/payment/mastercard2x.jpg" width="37" height="29" alt="mastercard")
								//- div(v-show="system == 'visa-master'").systems-list__info
									p Комиссия: 3%
									//p Минимум: 10.00 ₽
							//li.systems-list__item
								div.systems-list__box
									input(
										type="radio" 
										name="fund-system" 
										id="fund-mir" 
										value="mir"
										v-model="system"
									).systems-list__input
									label(for="fund-mir").systems-list__label Мир
										div.systems-list__inner
											p.systems-list__pic
												img(src="../assets/img/payment/mir2x.jpg" width="51" height="18" alt="mir")
								div(v-show="system == 'mir'").systems-list__info
									//- div.systems-list__info-tax
										p Комиссия: 3%
										p Минимум: 50.00 ₽
									div.systems-list__info-unable
										p Внимание! Услуга временно недоступна на нашем сайте. Приносим свои извинения. Повторите попытку позже. Если необходимо, свяжитесь с оператором +7 930 720 23 00
							//li.systems-list__item
								div.systems-list__box
									input(
										type="radio" 
										name="fund-system" 
										id="fund-ya"
										value="yandex"
										v-model="system"
									).systems-list__input
									label(for="fund-ya").systems-list__label Яндекс.Деньги
										div.systems-list__inner
											p.systems-list__pic
												img(src="../assets/img/payment/yandex-money2x.jpg" width="72" height="36" alt="yandex-money")
								div(v-show="system == 'yandex'").systems-list__info
									p Комиссия: 3%
									p Минимум: 50.00 ₽
							//li.systems-list__item
								div.systems-list__box
									input(
										type="radio" 
										name="fund-system" 
										id="fund-qiwi"
										value="qiwi"
										v-model="system"
									).systems-list__input
									label(for="fund-qiwi").systems-list__label QIWI Кошелек
										div.systems-list__inner
											p.systems-list__pic
												img(src="../assets/img/payment/qiwi2x.jpg" width="64" height="29" alt="qiwi")
								div(v-show="system == 'qiwi'").systems-list__info
									p Комиссия: 3%
									p Минимум: 50.00 ₽
							//li.systems-list__item
								div.systems-list__box
									input(
										type="radio" 
										name="fund-system" 
										id="fund-mob"
										value="mobile"
										v-model="system"
									).systems-list__input
									label(for="fund-mob").systems-list__label Мобильная связь (автоопределение оператора)
									div.systems-list__inner
										
								div(v-show="system == 'mobile'").systems-list__info
									p Комиссия: 3%
									p Минимум: 50.00 ₽
						div.systems-info
							p.systems-info__summ 
								span.systems-info-label Сумма зачисления
								span.systems-info-value #[span.ruble ₽] {{clearedSumm|priceFormat}}
							//p.systems-info__summ
								span.systems-info-label Сумма зачисления,#[br] c учетом сервисных сборов
								span.systems-info-value #[span.ruble ₽] 18 500.00
							button(
								type="button" 
								@click="send()" 
								:class="[{'fund__btn--ready' : isSystemReady}, {'invalid' : isSystemWrong}]"
							).systems-info__btn.fund__btn Получить
				//- **************************************************************************************
				//- divider ******************************************************************************
				//- **************************************************************************************
				//- li(:class="{'tabscreen--active' : currentTab == 'info'}").fund__tab-screen.tabscreen
					div.payment-info
						section.payment-info-card(v-if="system === 'visa-master' || system === 'mir'")
							//- div.payment-info-card__card.form-card
								.form-card__body
									ul.form-card__logos
										li 
											img(src="../assets/img/payment/visa2x.jpg")
										li
											img(src="../assets/img/payment/mastercard2x.jpg")
										li
											img(src="../assets/img/payment/mir2x.jpg")
									div.form-card__number.card-number
										p.form-card__label.card-number__cap Номер карты
										div.card-number__error(v-if="concatCard.length < 16") Введите номер карты полностью
										div.card-number__inputs
											input(
												type="text" 
												placeholder="0000" 
												maxlength="4"
												v-model="cardNumPt1"
												:class="{'invalid' :  cardNumPt1.length < 4}"
											).card-number-part.form-card__input
											input(
												type="text" 
												placeholder="0000"
												maxlength="4"
												v-model="cardNumPt2"
												:class="{'invalid' :  cardNumPt2.length < 4}"
											).card-number-part.form-card__input
											input(
												type="text" 
												placeholder="0000"
												maxlength="4"
												v-model="cardNumPt3"
												:class="{'invalid' : cardNumPt3.length < 4}"
											).card-number-part.form-card__input
											input(
												type="text" 
												placeholder="0000"
												maxlength="4"
												v-model="cardNumPt4"
												:class="{'invalid' : cardNumPt4.length < 4}"
											).card-number-part.form-card__input
									div.form-card__period.card-period
										p.card-period__cap Срок действия карты
										ul.card-period__fields
											li
												label.form-card__label месяц
												input(type="text" v-model="month" placeholder="мм" maxlength="2" :class="{'invalid' : isCardInvalid}").form-card__input
											li
												label.form-card__label год
												input(type="text" v-model="year" placeholder="гг" maxlength="2" :class="{'invalid' : isCardInvalid}").form-card__input
									div.form-card__holder.card-holder
										p.form-card__label Держатель карты
										//- сюда бы наверное маску типа NAME LASTNAME
										input(
											type="text" 
											placeholder="Имя и фамилия"
											v-model="cardholder"
											:class="{'invalid' : isCardInvalid}"
										).form-card__input.card-holder__input
							div.payment-info-card__ext
								//div.payment-info-card__word
									label Кодовое #[br] слово
									div.inputbox(:class="{'invalid' : codeInvalid}")
										input.inputbox__input(
											:type="isWordOpen ? 'text' :'password'"
										)
										div.inputbox__action
											button(type="button" @click="isWordOpen=!isWordOpen" :class="{'active' : isWordOpen }").inputbox__action-eye
								//div.wrong-message(v-if="codeInvalid")
									| При регистрации вы указали другое «Кодовое слово». Проверьте правильность заполнения, повторите попытку. Если необходимо, свяжитесь с оператором +7 930 720 23 00. 
								button.payment-info-card__button.payment-info__button.fund__btn.fund__btn--ready(
									@click="send()"
								)
									//- класс fund__btn--ready соответствует правильно заполненным полям в этом шаге
									icon-security
									span Получить  ₽ {{clearedSumm|priceFormat}}
						//- **************************************************************************************
						//- divider ******************************************************************************
						//- **************************************************************************************
						//section.payment-info-qiwi(v-if="system === 'qiwi'")
							p.payment-info-qiwi__pic
								img(src="../assets/img/payment/qiwi3x.png")
							div.payment-info-qiwi__field.payment-info-qiwi__num
								label Номер кошелька
								div.inputbox(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(type="text" placeholder="0000 0000 0000 0000")
							div.payment-info-qiwi__field.payment-info-qiwi__sum
								label Сумма вывода
								div.inputbox.inputbox--left-symbol(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(type="text" placeholder="18 500.00")
									span.inputbox__symbol.inputbox__symbol--left ₽
							div.payment-info-qiwi__field.payment-info-qiwi__code
								label Кодовое слово
								div.inputbox(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(:type="isWordOpen ? 'text' :'password'")
									div.inputbox__action
										button(type="button" @click="isWordOpen=!isWordOpen" :class="{'active' : isWordOpen }").inputbox__action-eye
								div.wrong-message(v-if="codeInvalid")
									| При регистрации вы указали другое «Кодовое слово». Проверьте правильность заполнения, повторите попытку. Если необходимо, свяжитесь с оператором +7 930 720 23 00. 
							button.payment-info-qiwi__button.payment-info__button.fund__btn
								icon-security
								span Получить  ₽ 18 500.00
						//- **************************************************************************************
						//- divider ******************************************************************************
						//- **************************************************************************************
						//section.payment-info-ya(v-if="system === 'yandex'")
							p.payment-info-ya__pic
								img(src="../assets/img/payment/yandex-money3x.png")
							div.payment-info-ya__field.payment-info-ya__num
								label Номер кошелька
								div.inputbox(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(type="text" placeholder="0000 0000 0000 0000")
							div.payment-info-ya__field.payment-info-ya__sum
								label Сумма вывода
								div.inputbox.inputbox--left-symbol(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(type="text" placeholder="18 500.00")
									span.inputbox__symbol.inputbox__symbol--left ₽
							div.payment-info-ya__field.payment-info-ya__code
								label Кодовое слово
								div.inputbox(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(:type="isWordOpen ? 'text' :'password'")
									div.inputbox__action
										button(type="button" @click="isWordOpen=!isWordOpen" :class="{'active' : isWordOpen }").inputbox__action-eye
								div.wrong-message(v-if="codeInvalid")
									| При регистрации вы указали другое «Кодовое слово». Проверьте правильность заполнения, повторите попытку. Если необходимо, свяжитесь с оператором +7 930 720 23 00. 
							button.payment-info-ya__button.payment-info__button.fund__btn
								icon-security
								span Получить  ₽ 18 500.00
						//- **************************************************************************************
						//- divider ******************************************************************************
						//- **************************************************************************************
						//section.payment-info-mob(v-if="system === 'mobile'")
							div.payment-info-mob__field.payment-info-mob__num
								label Номер телефона
								//- очень особенный инпутбокс, при определении номера справа является логотип оператора. Если эта фича пройдет естетственный отбор, конечно.
								div.inputbox(:class="{'invalid' : codeInvalid}").inputbox--phone
									input.inputbox__input(
										type="text" placeholder="+7 (___) ___ __ __"
										v-model="phoneNumber"
										maxlength="10"
									)
									div.inputbox__operator-place(v-if="phoneNumber.length==10")
										div.inputbox__operator
											img(src="../assets/img/payment/operators/Yota.jpg")
								p Введите 10-значный номер телефона
							div.payment-info-mob__field.payment-info-mob__sum
								label Сумма вывода
								div.inputbox.inputbox--left-symbol(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(type="text" placeholder="18 500.00")
									span.inputbox__symbol.inputbox__symbol--left ₽
							div.payment-info-mob__field.payment-info-mob__code
								label Кодовое слово
								div.inputbox(:class="{'invalid' : codeInvalid}")
									input.inputbox__input(:type="isWordOpen ? 'text' :'password'")
									div.inputbox__action
										button(type="button" @click="isWordOpen=!isWordOpen" :class="{'active' : isWordOpen }").inputbox__action-eye
								div.wrong-message(v-if="codeInvalid")
									| При регистрации вы указали другое «Кодовое слово». Проверьте правильность заполнения, повторите попытку. Если необходимо, свяжитесь с оператором +7 930 720 23 00. 
							button.payment-info-mob__button.payment-info__button.fund__btn
								icon-security
								span Получить  ₽ 18 500.00
	balance-success(v-if="success" :summ="summ" @close="resetData()")
section(v-else)
	p Чтобы пользоваться личным кабинетом, нужно авторизоваться
</template>
<script>
// import { Validator } from 'vee-validate';
import { mapState } from "vuex";
import iconSecurity from "@/components/icons/iconSecurity.vue";
import balanceSuccess from "@/components/balanceSuccess.vue";
export default {
  components: {
    iconSecurity,
    balanceSuccess
  },
  data() {
    return {
      // tabscreens: [],
      // tabcontrols: [],
      // tab data values (string): sum, system, info
      currentTab: "sum",
      // systems values (string): visa-master, mir, yandex, qiwi, mobile
      system: "visa-master",
      // не знаю, хорошо или нет, но все кодовые слова в компоненте открываются через одну эту переменную.
      isWordOpen: false,
      // а вот эти переменные - мой симулятор валидности полей.
      isSystemReady: true,
      isSummReady: false,
      isInfoReady: false,
      codeInvalid: false,
      isCardInvalid: false,
      isSystemWrong: false,
      // просто разные инпуты
      summ: "",
      phoneNumber: "",
      cardNumPt1: "",
      cardNumPt2: "",
      cardNumPt3: "",
      cardNumPt4: "",
      month: "",
      year: "",
      cardholder: "",
      success: false
    };
  },
  computed: {
    ...mapState("user", ["profile", "token"]),
    isAuth() {
      return (
        !!this.token && this.profile && Object.keys(this.profile).length > 0
      );
    },
    clearedSumm() {
      return +this.summ.replace(",", ".");
    },
    concatCard() {
      return (
        this.cardNumPt1 + this.cardNumPt2 + this.cardNumPt3 + this.cardNumPt4
      );
    },
    paymentUrl() {
      return "/api/v1/yandex/initialpayouttocard";
    }
  },
  watch: {
    summ(newVal, oldVal) {
      this.summ = /^\d*[,.]?\d{0,2}$/.test(newVal) ? newVal : oldVal;
    },
    isAuth(newVal) {
      if (newVal === false) {
        this.$router.push({ name: "account" });
      }
    }
  },
  methods: {
    resetData() {
      this.summ = "";
      this.currentTab = "sum";
      this.cardNumPt1 = "";
      this.cardNumPt2 = "";
      this.cardNumPt3 = "";
      this.cardNumPt4 = "";
      (this.month = ""),
        (this.year = ""),
        (this.cardholder = ""),
        (this.success = false);
    },
    send() {
      this.getMoney();
    },
    getMoney() {
      const data = { amount: this.clearedSumm };
      axios
        .post(this.paymentUrl, data)
        .then(result => {
        //   console.log(result);
          if (result.data.result) {
            window.location = result.data.data.url;
          } else {
            this.showError("Ошибка платёжной системы, попробуйте позднее");
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    nextMove(move) {
      if (this.profile.ballance >= this.clearedSumm) {
        this.$validator.validateAll().then(result => {
          if (result) {
            this.currentTab = move;
          }
        });
      } else {
        this.showError("У вас на балансе недостаточно средств для вывода");
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.wrong-message {
  position: relative;
  // top: calc(100% + 15px);
  // left: 0;
  background-color: #fff;
  border-radius: 10px;
  border: solid 1px #ececec;
  padding: 10px 10px 10px 40px;
  font-size: 12px;
  line-height: 17px;
  margin-top: 15px;
  &::before {
    content: "!";
    position: absolute;
    left: 13px;
    top: 12px;
    background-color: $warning;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10px;
    color: #fff;
  }
}
.inputbox {
  position: relative;
  &__input {
    @include hamster-field;
    height: 43px;
    width: 100%;
    padding-right: 20px;
    background-color: #fff;
    &::placeholder {
      color: #707070;
    }
    &:active,
    &:focus {
      box-shadow: none;
      border-color: $color-base-accent;
      background-color: #ffffff;
    }
  }
  &__symbol {
    position: absolute;
    width: 31px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    &--left {
      left: 0;
      top: 0;
    }
  }
  &--left-symbol {
    input {
      padding-left: 31px;
    }
  }
  &--extended {
    .inputbox__input {
      padding-right: 25px;
      &:focus ~ .input-wrapper__action {
        & /deep/ svg {
          stroke: $color-base-accent;
        }
      }
    }
  }
  &--phone {
    .inputbox__input {
      padding-right: 50px;
    }
    .inputbox__operator-place {
      position: absolute;
      width: 50px;
      height: 100%;
      right: 0;
      top: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .inputbox__operator {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      overflow: hidden;
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
  }
  &__action {
    position: absolute;
    height: 20px;
    top: 11px;
    right: 10px;
    display: flex;
    align-items: center;
    button {
      outline: none;
      cursor: pointer;
    }
    &-eye {
      width: 20px;
      height: 20px;
      border: none;
      background: url($eye-inactive);
      background-position: center;
      background-repeat: no-repeat;
      &.active {
        background: url($eye-active);
        background-position: center;
        background-repeat: no-repeat;
      }
    }
  }
  &.invalid {
    .inputbox__input {
      border-color: #ed5448;
      background-color: #ffdbd8;
      color: #ed5448;
    }
    .inputbox__action {
    }
  }
  // &.errors {
  //   .errors-list {
  //     margin: 5px 0;
  //     padding: 0px 10px;
  //     font: $font-regular;
  //     font-size: 10px;
  //     color: $danger;
  //     display: block;
  //   }
  //   input {
  //     border: 1px solid $danger;
  //   }
  // }
}
.balance {
  &__title {
    @include blocktitle;
  }
  &__container {
    margin-bottom: 50px;
  }
  &__items {
    @include row-flex;
    flex-wrap: nowrap;
    @media (max-width: 610px) {
      flex-wrap: wrap;
    }
  }
  &__available {
    @include contentbox;
    @include col();
    @include size(7);
    @media (max-width: 610px) {
      @include size(12);
      margin-bottom: 15px;
    }
  }
  &__status {
    @include contentbox;
    @include col();
    @include size(5);
    @media (max-width: 610px) {
      @include size(12);
    }
  }
  &__statebar {
    @include statebar;
    margin-top: 24px;
    justify-content: center;
    flex-wrap: wrap;
    padding: 5px 10px;
    p {
      width: auto;
    }
    @media (max-width: 610px) {
      margin-top: 0;
    }
  }
  &__cap {
    @include hamster-label;
  }
  &__fieldgroup {
    display: flex;
    flex-grow: 2;
  }
  &__field {
    @include hamster-field;
    height: 43px;
    flex-grow: 2;
    &--symbol {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 43px;
      flex-grow: 0;
      flex-shrink: 0;
      margin-left: 10px;
    }
  }
}
.fund {
  @include contentbox;
  overflow: hidden;
  padding: 0;
  &__btn {
    background: $color-grey;
    color: #000;
    font-size: 14px;
    font-weight: 500;
    border-radius: 22px;

    height: 43px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    cursor: pointer;
    border: none;

    &--ready {
      background-color: $color-base-accent;
      color: #fff;
      & /deep/ path {
        fill: #ffffff;
      }
    }
    &.invalid {
      background-color: #8db2b0;
      color: #ffffff;
      cursor: default;
      & /deep/ path {
        fill: #ffffff;
      }
    }
  }
  &__tab-controls {
    display: flex;
    @media (max-width: 345px) {
      flex-direction: column;
    }
  }
  &__tab-control {
    list-style: none;
    padding: 10px;
    background-color: $color-base-gray-light;
    font-size: 16px;
    color: #000;
    font-weight: 600;
    border: 1px solid #ececec;
    min-height: 72px;
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    border-left: none;
    cursor: pointer;
    @media (max-width: 768px) {
      font-size: 14px;
    }
    @media (max-width: 600px) {
      font-size: 11px;
      word-break: break-all;
    }
    @media (max-width: 345px) {
      width: 100%;
      min-height: 43px;
    }
    &--active {
      background-color: #fff;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      border: 1px solid #ececec;
    }
  }
  &__tab-screen {
    list-style: none;
  }
}
.tabscreen {
  padding: 0 20px;
  height: 0;
  overflow: hidden;
  transition: 0.3s;

  &--active {
    height: auto;
    padding: 25px 20px;
  }
  @media (max-width: 425px) {
    padding: 0 10px;
    &--active {
      padding: 20px 10px;
    }
  }
}
.fund-summ {
  display: grid;
  &__cap {
    font-size: 13px;
    color: #707070;
    line-height: 19px;
    margin-bottom: 5px;
  }

  &__content {
    display: flex;
    width: 70%;
    @media (max-width: 768px) {
      width: 100%;
    }
    @media (max-width: 600px) {
      flex-direction: column;
    }
  }
  &__fields-box {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 10px;
    position: relative;
    padding-bottom: 5px;
  }
  &__error {
    font-size: 13px;
    color: #707070;
    line-height: 19px;
    margin: 0;
  }
  &__min {
    position: absolute;
    top: 100%;
    font-size: 13px;
    color: #707070;
    line-height: 19px;
  }
  &__field {
    @include hamster-field;
    height: 43px;
    width: 100%;
    &--symbol {
      width: 43px;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 43px;
    }
    &.invalid {
      border-color: #ed5448;
      background-color: #ffdbd8;
      color: #ed5448;
    }
  }
  &__btn {
    width: 150px;
    margin-left: 20px;
    flex-shrink: 0;
    @media (max-width: 600px) {
      margin-top: 25px;
      margin-left: 0;
      justify-self: center;
    }
  }
}
.systems {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 15px;
  @media (max-width: 670px) {
    grid-template-columns: 1fr;
  }
}
.systems-list {
  border: 1px solid $color-border-gray;
  background: #ffffff;
  border-radius: 10px;
  overflow: hidden;
  align-self: start;
  &__item {
    &:not(:last-child) {
      .systems-list__box {
        border-bottom: 1px solid $color-border-gray;
      }
    }
    &:last-child {
      .systems-list__info {
        border-bottom: none;
        border-top: 1px solid $color-border-gray;
      }
    }
  }
  &__box {
    display: flex;
    align-items: center;
    height: 56px;
    position: relative;
    &::before {
      content: "";
      width: 1px;
      height: 80%;
      background-color: $color-border-gray;
      position: absolute;
      left: 47px;
    }
    input {
      display: none;
    }
    label {
      padding-left: 70px;
      position: relative;
      cursor: pointer;
      font-size: 14px;
      line-height: 19px;
      height: 100%;
      width: 100%;
      display: flex;
      align-items: center;
      @media (max-width: 670px) {
        font-size: 13px;
      }
      @media (max-width: 425px) {
        padding-left: 60px;
        font-size: 12px;
      }
      &::before {
        content: "";
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 1px solid #707070;
        background-color: #ffffff;
        position: absolute;
        left: 17px;
        top: calc(50% - 7px);
      }
      &::after {
        content: "";
        width: 8px;
        height: 8px;
        position: absolute;
        top: calc(50% - 3px);
        left: 21px;
        background: transparent;
        border-radius: 10px;
      }
    }
    input:checked + label {
      border-left: 3px solid $color-base-accent;
    }
    input:checked + label::before {
      border-color: $color-base-accent;
      transform: translateX(-3px);
    }
    input:checked + label::after {
      transform: translateX(-3px);
      background-color: $color-base-accent;
    }
  }
  &__info {
    padding: 20px 0px 20px 70px;
    border-bottom: 1px solid $color-border-gray;
    @media (max-width: 425px) {
      padding-left: 60px;
    }
    p {
      font-size: 12px;
      color: $color-text-gray;
      line-height: 17px;
      width: 60%;
      &:not(:last-child) {
        margin-bottom: 3px;
      }
      @media (max-width: 670px) {
        font-size: 10px;
      }
      @media (max-width: 425px) {
        width: 80%;
      }
    }
    &-unable {
      position: relative;
      &::before {
        content: "!";
        position: absolute;
        left: -53px;
        top: 0;
        background-color: $warning;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 9px;
        color: #fff;
      }
    }
  }
  &__inner {
    display: flex;
    margin-left: auto;
    padding: 0 10px;
  }
  &__pic {
    &:not(:last-child) {
      margin-right: 10px;
    }
    @media (max-width: 300px) {
      display: none;
    }
    img {
    }
  }
}
.systems-info {
  display: flex;
  flex-direction: column;
  &__summ {
    width: 100%;
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    .systems-info-label {
      margin-right: 15px;
      color: $color-text-gray;
      font-size: 13px;
    }
    .ruble {
      font-weight: 400;
      font-size: 14px;
      margin-right: 3px;
    }
    .systems-info-value {
      flex-shrink: 0;
      font-size: 14px;
      font-weight: 600;
    }
  }
  &__btn {
    width: 150px;
    align-self: center;
    margin-top: auto;
    @media (max-width: 670px) {
      align-self: flex-end;
    }
  }
}

.payment-info-card {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  @media (max-width: 768px) {
    grid-template-columns: 1fr;
    grid-auto-rows: auto;
  }
  &__card {
    @media (max-width: 470px) {
      justify-self: center;
    }
  }
  &__ext {
    display: flex;
    flex-direction: column;
  }
  &__word {
    display: flex;
    justify-content: flex-end;
    position: relative;
    @media (max-width: 768px) {
      br {
        display: none;
      }
      flex-direction: column;
      label {
        margin-bottom: 5px;
      }
      .inputbox {
        max-width: 400px;
      }
    }
    label {
      color: $color-text-gray;
      font-size: 13px;
      line-height: 18px;
      margin-right: 10px;
      flex-shrink: 2;
    }
    .inputbox {
      flex-grow: 2;
    }
  }

  &__button {
    align-self: center;
    margin-top: auto;
    @media (max-width: 768px) {
      align-self: flex-start;
      margin-top: 20px;
    }
  }
}
.payment-info__button {
  @include flex-centerizer;
  width: 240px;
  cursor: pointer;
  & /deep/ svg {
    margin-right: 10px;
  }
}
.form-card {
  &__body {
    background-color: $color-base-accent;
    border-radius: 10px;
    width: 400px;
    height: 244px;
    padding: 17px 21px;
    display: flex;
    flex-direction: column;
    @media (max-width: 470px) {
      padding: 11px 21px;
      width: 340px;
      height: 212px;
    }
    @media (max-width: 410px) {
      width: 100%;
      height: auto;
    }
  }
  &__label {
    color: #fff;
    font-size: 12px;
    line-height: 19px;
    margin-bottom: 2px;
  }
  &__input {
    background-color: #fff;
    color: #000;
    text-align: center;
    border-radius: 4px;
    height: 29px;
    padding: 0 5px;
    border: none;
    font-size: 13px;
    line-height: 29px;
    &::placeholder {
      color: #707070;
    }
    &.invalid {
      border: 1px solid #ed5448;
      background-color: #ffdbd8;
      color: #ed5448;
    }
  }
  &__logos {
    display: grid;
    grid-template-columns: 56px 56px 56px;
    grid-template-rows: 35px;
    gap: 9px;
    margin-bottom: 10px;
    @media (max-width: 470px) {
      margin-bottom: 5px;
      grid-template-rows: 25px;
      grid-template-columns: 40px 40px 40px;
    }
    @media (max-width: 365px) {
      display: none;
    }
    li {
      background-color: #fff;
      img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }
  }
}
.card-number {
  margin-bottom: 10px;
  position: relative;
  @media (max-width: 470px) {
    margin-bottom: 5px;
  }
  &__inputs {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    column-gap: 10px;
    input {
      width: 100%;
    }
  }
  &__error {
    position: absolute;
    padding: 5px;
    background-color: #fff;
    font-size: 12px;
    height: 40px;
    display: flex;
    align-items: center;
    border-radius: 4px;
    border: solid 1px #ececec;
    bottom: 100%;
  }
}
.card-period {
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  &__cap {
    color: #fff;
    font-size: 13px;
    margin-right: 6px;
    margin-bottom: 8px;
  }
  &__fields {
    display: grid;
    grid-template-columns: 58px 58px;
    column-gap: 4px;
    li {
      display: flex;
      flex-direction: column;
      label {
        text-align: center;
      }
    }
  }
}
.card-holder {
  margin-top: auto;
  &__input {
    width: 100%;
    text-align: left;
  }
}
.payment-info-qiwi {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 47px auto;
  row-gap: 30px;
  grid-template-areas:
    "pic ."
    "num ."
    "sum ."
    "code button";
  @media (max-width: 600px) {
    grid-template-columns: 264px 1fr;
    grid-template-areas:
      "pic ."
      "num ."
      "sum ."
      "code ."
      "button .";
  }
  @media (max-width: 425px) {
    grid-template-columns: 1fr;
    row-gap: 20px;
    grid-template-areas:
      "pic"
      "num"
      "sum"
      "code"
      "button";
  }
  &__field {
    label {
      font-size: 13px;
      line-height: 19px;
      color: $color-text-gray;
      display: block;
      margin-bottom: 5px;
    }
  }
  &__pic {
    grid-area: pic;
    align-self: start;
    justify-self: start;
    height: 100%;
    img {
      height: 47px;
      width: auto;
    }
    @media (max-width: 425px) {
      justify-self: center;
    }
  }
  &__num {
    grid-area: num;
  }
  &__sum {
    grid-area: sum;
  }
  &__code {
    grid-area: code;
  }
  &__button {
    grid-area: button;
    justify-self: center;
    align-self: end;
  }
}
// Дублирую код, потому что раскладка впоследствии может приобрести множество отличий. Или нет.
.payment-info-ya {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 57px auto;
  row-gap: 30px;
  grid-template-areas:
    "pic ."
    "num ."
    "sum ."
    "code button";
  @media (max-width: 600px) {
    grid-template-columns: 264px 1fr;
    row-gap: 25px;
    grid-template-areas:
      "pic ."
      "num ."
      "sum ."
      "code ."
      "button .";
  }
  @media (max-width: 425px) {
    grid-template-columns: 1fr;
    row-gap: 20px;
    grid-template-areas:
      "pic"
      "num"
      "sum"
      "code"
      "button";
  }
  &__field {
    label {
      font-size: 13px;
      line-height: 19px;
      color: $color-text-gray;
      display: block;
      margin-bottom: 5px;
    }
  }
  &__pic {
    grid-area: pic;
    align-self: start;
    justify-self: start;
    height: 100%;
    img {
      height: 57px;
      width: auto;
    }
    @media (max-width: 425px) {
      justify-self: center;
    }
  }
  &__num {
    grid-area: num;
  }
  &__sum {
    grid-area: sum;
  }
  &__code {
    grid-area: code;
  }
  &__button {
    grid-area: button;
    justify-self: center;
    align-self: end;
  }
}
.payment-info-mob {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto;
  row-gap: 30px;
  grid-template-areas:
    "num ."
    "sum ."
    "code button";
  @media (max-width: 600px) {
    grid-template-columns: 264px 1fr;
    grid-template-areas:
      "num ."
      "sum ."
      "code ."
      "button .";
  }
  @media (max-width: 425px) {
    grid-template-columns: 1fr;
    row-gap: 20px;
    grid-template-areas:
      "num"
      "sum"
      "code"
      "button";
  }
  &__field {
    label,
    p {
      font-size: 13px;
      line-height: 19px;
      color: $color-text-gray;
      display: block;
      margin-bottom: 5px;
    }
    p {
      margin-top: 8px;
      margin-bottom: 0;
    }
  }
  &__num {
    grid-area: num;
  }
  &__sum {
    grid-area: sum;
  }
  &__code {
    grid-area: code;
  }
  &__button {
    grid-area: button;
    justify-self: center;
    align-self: end;
  }
}
</style>

