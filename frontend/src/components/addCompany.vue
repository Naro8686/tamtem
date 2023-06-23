<template lang="pug">
  section.portfolio__addone
    label(for="inn").portfolio__label ИНН компании
    //- условный класс тут тупо чтобы появляющийся список не налезал на нижние блоки, а оставлять его в потоке было затруднительно
    div(
      :class="[{'inputblock--higher' : companiesList.length>0},{'errors' : errors.has('inn')}]"
    ).portfolio__inputblock.inputblock
      div.inputblock__row
        form(@submit.prevent="find()").inputblock__inputbox
          input(
          id="inn" name="inn"
          v-model="inn"
          data-vv-as="ИНН"
          data-vv-name="inn"
          v-validate='`required|inn`'
          ).inputblock__input
          button.inputblock__button(title="Проверить компанию" type="submit" v-if="!errors.has('inn')") Проверить
          selectCompanyName(v-if="companiesList.length>0" :companies="companiesList" @selectCompany="processData").inputblock__selectcompany
        div(
          :class="[{'inputblock__indicator--success' : isInnSuccess}, {'inputblock__indicator--error' : isInnError}]"
        ).inputblock__indicator.inputblock__indicator--inn
      //- элемент для вывода сообщения
      i.errors-list(v-if="errors.has('inn')") {{ ...errors.collect('inn')}}
      p(
        v-if="this.company && canSearch"
        :class="[{'inputblock__message--success' : isInnSuccess}, {'inputblock__message--error' : isInnError}]"
      )#inn-message.inputblock__message {{ innMessage }}
    label(for="orderlink").portfolio__label.portfolio__label--addorder Добавить ссылку на заказ
    div.portfolio__inputblock.inputblock
      div.inputblock__row
        div.inputblock__inputbox
          input(id="orderlink" v-model="orderLink" name="orderlink" placeholder="https://tamtem.ru/bids/727").inputblock__input
        div.inputblock__indicator.inputblock__indicator--warn
          p.inputblock__indicator-tip Добавление ссылки на заказ повысит вероятность того, что заказчик зарегистрируется на сервисе
      p.inputblock__message.inputblock__message--gray *Поле необязательно для заполнения
    p.portfolio__label.portfolio__label--linkcreate Ссылка для регистрации компании
    div.portfolio__linkcreatebox.linkcreatebox
      input#linkField.linkcreatebox__field(
        :class="{'linkcreatebox__field--created' : isLinkCreated}"
        v-model="linkValue"
        readonly
      )
      //- при нажатии на кнопку создать оно тут все зеленеет и кнопка меняется в "копировать."
      template(v-if="!isLinkCreated")
        button(@click.prevent="createLink" :class="{'linkcreatebox__button--copy' : isInnSuccess}").linkcreatebox__button Создать
      template(v-if="isLinkCreated")
        button(@click="copyLink").linkcreatebox__button.linkcreatebox__button--copy Копировать
      div(v-show="isLinkCopied").copy-link-message.container
        p.copy-link-message__text вставьте ссылку в эл. письмо для поставщика, не забудьте указать свое имя и отправьте эл. почту поставщику
        button(@click="isLinkCopied = false").copy-link-message__close Закрыть
</template>
<script>
import selectCompanyName from "@/components/selectCompanyName.vue";
import { mapActions } from "vuex";
export default {
  components: {
    selectCompanyName
  },
  data() {
    return {
      searchingBefore: false,
      companyChekingStatus: false,
      inn: null,
      innMessage: "",
      isCompanyAvailable: false,
      isLinkCreated: false,
      isLinkCopied: false,
      orderLink: null,
      linkValue: "",
      company: null,
      companiesList: [],
      statusesList: {
        ACTIVE: {
          id: 1,
          text: "Действующая"
        },
        LIQUIDATING: {
          id: 0,
          text: "Ликвидируется"
        },
        LIQUIDATED: {
          id: 0,
          text: "Ликвидирована"
        },
        REORGANIZING: {
          id: 0,
          text: "Реорганизация"
        }
      }
    };
  },
  watch: {
    inn() {
      this.company = null;
      this.isLinkCreated = false;
      this.isLinkCopied = false;
      this.linkValue = "";
      this.innMessage = "";
      this.searchingBefore = false;
    }
  },
  computed: {
    isInnError() {
      return (
        this.searchingBefore == true ||
        (this.company && this.company.org_status.id == 0) ||
        (this.company && !this.companyChekingStatus)
      );
    },
    isInnSuccess() {
      return !this.searchingBefore && this.company && this.companyChekingStatus;
    },
    canSearch() {
      return this.inn && (this.inn.length == 10 || this.inn.length == 12);
    }
  },
  methods: {
    ...mapActions("portfolio", ["getDataByInn"]),
    find() {
      if (this.inn && (this.inn.length == 10 || this.inn.length == 12)) {
        const payload = {
          key: this.$dadataKey,
          inn: this.inn
        };
        this.getDataByInn(payload)
          .then(response => {
            if (response.data.suggestions) {
              const filteredArray = response.data.suggestions.filter(item => {
                return item.data.state.status == "ACTIVE";
              });

              if (filteredArray.length > 0) {
                filteredArray.length == 1
                  ? this.processData(filteredArray[0])
                  : (this.companiesList = filteredArray);
              } else {
                this.showError("Ничего не найдено");
                this.searchingBefore = true;
              }
            }
          })
          .catch(() => {
            // console.log(err);
          });
      } else {
        return false;
      }
    },
    processData(suggestion) {
      const result = {};

      result.org_name = suggestion.value;
      result.org_kpp = suggestion.data.kpp;
      result.org_director = suggestion.data.management
        ? suggestion.data.management.name
        : null;
      (result.org_manager_post = suggestion.data.management
        ? suggestion.data.management.post
        : null),
        (result.org_okved = suggestion.data.okved),
        (result.org_status = this.setOrgStatus(suggestion.data.state.status)),
        (result.org_ogrn = suggestion.data.ogrn),
        (result.org_registration_date = this.transformDate(
          suggestion.data.state.registration_date
        )),
        (result.org_address_legal = suggestion.data.address.data.source),
        (result.org_inn = suggestion.data.inn);
      result.org_address = suggestion.data.address.data.city;

      this.company = result;
      if (this.company.org_status.id !== 0) {
        this.checkisOrgAvailable()
          .then(response => {
            if (response.data.result == true) {
              this.innMessage = this.company.org_name;
              this.companyChekingStatus = true;
            } else {
              this.innMessage = "Компания уже зарегистрирована";
              // this.company = null;
              this.companyChekingStatus = false;
            }
          })
          .catch(() => {
            // console.log(err);
            this.company = null;
            this.companyChekingStatus = false;
            this.showError("Произошла ошибка, попробуйте позднее");
            this.searchingBefore = true;
          });
      } else {
        this.innMessage = "Компания ликвидирована";
        this.searchingBefore = true;
        this.companyChekingStatus = false;
      }

      this.$set(this, "companiesList", []);
    },
    createLink() {
      if (!this.company) {
        this.showError("Заполните данные компании");
        return false;
      } else {
        let bidId;
        if (this.orderLink) {
          bidId = this.orderLink.replace(/[^0-9]/g, "");
        }

        if (this.orderLink && bidId.length == 0) {
          this.showError("Неверная ссылка");
          return false;
        }
        const data = {
          inn: this.company.org_inn,
          name: this.company.org_name,
          bid: bidId
        };
        // eslint-disable-next-line
        axios
          .post("/api/v1/user/refgenerate", data)
          .then(response => {
            if (response.data.result == true) {
              this.linkValue = response.data.data;
              this.isLinkCreated = true;
            } else {
              // console.log(response.data);
              this.showError("Произошла ошибка, попробуйте позднее");
            }
          })
          .catch(() => {
            // console.log(err);
            this.showError("Произошла ошибка, попробуйте позднее");
          });
      }
    },
    async checkisOrgAvailable() {
      // eslint-disable-next-line
      return await axios.post("/api/v1/user/innisavailable", {
        inn: this.inn
      });
    },
    setOrgStatus(status) {
      const result = this.statusesList[status];
      return result ? result : { id: 0, text: "Нет данных" };
    },
    transformDate(unixDate) {
      let date = new Date(unixDate).toLocaleString("ru").split(",")[0];
      let [day, month, year] = date.split(".");
      return `${year}-${month}-${day}`;
    },
    copyLink(event) {
      event.preventDefault();
			this.linkValue="Вас приветствует B2B биржа оптовых заказов tamtem.ru.\nНа нашем сервисе вы можете найти выгодный оптовый заказ или подходящего поставщика для вашей компании, для регистрации на сервисе перейдите по ссылке: "+this.linkValue+"\nИнформацию о сервисе можно просмотреть на нашем сайте https://tamtem.ru/ в соц сетях https://vk.com/tamtem_b2b и по телефону +7 (930) 720-23-00\n"+"Приглашаем компании к постоянному сотрудничеству!";
			this.copyToClipboard(this.linkValue);
      this.isLinkCopied = true;
      setTimeout(() => {
        this.isLinkCopied = false;
      }, 10000);
    }
  }
};
</script>
<style lang="scss" scoped>
$search-icon: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciICAgICB3aWR0aD0iMjgiICAgICBoZWlnaHQ9IjI4IiAgICAgdmlld0JveD0iMCAwIDE4IDE4IiAgICAgYXJpYS1sYWJlbGxlZGJ5PSJzZWFyY2giPiAgICA8ZyBmaWxsPSJub25lIiAgICAgZmlsbC1ydWxlPSJldmVub2RkIj4gICAgPHBhdGggc3Ryb2tlPSIjRDhEOEQ4IiAgICAgICAgICBkPSJNLTU1OC41LTQyNy41aDgxNnY2MjZoLTgxNnoiIC8+ICAgIDxwYXRoIHN0cm9rZT0iI0Q4RDhEOCIgICAgICAgICAgZD0iTS0xNDQuNS01OC41aDI5N3YxNDBoLTI5N3oiIC8+ICAgIDxnIHN0cm9rZT0iIzJmYzA2ZSIgICAgICAgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiAgICAgICBzdHJva2UtbGluZWpvaW49InJvdW5kIiAgICAgICBzdHJva2Utd2lkdGg9IjIiICAgICAgIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEgMSkiPiAgICAgIDxjaXJjbGUgY3g9IjYuNjY3IiAgICAgICAgICAgICAgY3k9IjYuNjY3IiAgICAgICAgICAgICAgcj0iNi42NjciIC8+ICAgICAgPHBhdGggZD0iTTE2IDE2bC00LjYyMi00LjYyMiIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==";

.errors {
  .errors-list {
    margin: 5px 0;
    padding: 0px 10px;
    font: $font-regular;
    font-size: 10px;
    color: $danger;
    display: block;
  }
  input {
    border: 1px solid $danger !important;
  }
}
.copy-link-message {
  position: fixed;
  left: 0;
  right: 0;
  bottom: 3%;
  width: 100%;
  background-color: #d4f5de;
  border: 1px solid $color-base-accent;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 5px 30px;
  min-height: 43px;
  &::before {
    content: "";
    @include w-h(21px);
    background-color: $color-base-accent;
    border-radius: 50%;
    background: url(../assets/img/tick.svg) no-repeat, $color-base-accent;
    background-position: center;
    flex-shrink: 0;
    margin-right: 15px;
  }
  &__text {
    font-size: 12px;
  }
  &__close {
    border: none;
    background: none;
    color: $color-base-accent;
    cursor: pointer;
  }
}
.portfolio {
  &__addone {
    @include contentbox;
    margin-bottom: 40px;
  }
  &__label {
    @include hamster-label;
    display: block;
    font-size: 12px;
    &--linkcreate {
      margin-top: 25px;
    }
    &--addorder {
      margin-top: 45px;
      padding-left: 28px;
      position: relative;
      &::before {
        content: "+";
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        background: $color-base-accent;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        left: 0;
        top: 50%;
        margin-top: -9px;
      }
    }
  }
  .inputblock {
    &__row {
      flex-grow: 2;
      display: flex;
      align-items: center;
    }
    &__inputbox {
      width: 100%;
      position: relative;
      display: flex;
      align-items: center;
    }
    &__input {
      @include hamster-field;
      width: 100%;
      &::-webkit-input-placeholder {
        /* Chrome */
        color: #b9b9b9;
      }
      &:-ms-input-placeholder {
        /* IE 10+ */
        color: #b9b9b9;
      }
      &::-moz-placeholder {
        /* Firefox 19+ */
        color: #b9b9b9;
        opacity: 1;
      }
      &:-moz-placeholder {
        /* Firefox 4 - 18 */
        color: #b9b9b9;
        opacity: 1;
      }
    }
    &__button {
      position: absolute;
      right: 5px;
      width: 82px;
      font: $font-medium;
      font-size: $fontsize-base;
      background-color: transparent;
      color: #2fc06e;
      text-decoration: underline;
      height: 25px;
      padding: 0;
      // background: url($search-icon);
      border: none;
      cursor: pointer;
    }
    &__message {
      margin-top: 5px;
      margin-bottom: 15px;
      font-size: 12px;
      line-height: 19px;
      color: $color-text-gray;
      word-break: break-all;
      @media (max-width: 320px) {
      }
      &--success {
        color: $color-base-accent;
        font-size: 14px;
        line-height: 19px;
      }
      &--error {
        color: $color-base-attention;
      }
    }
    &__indicator {
      @include w-h(30px);
      border-radius: 50%;
      background-color: #fff;
      border: solid 1px #ececec;
      margin-left: 15px;
      flex-shrink: 0;
      position: relative;
      &--success {
        background: url(../assets/img/tick.svg) no-repeat, $color-base-accent;
        background-position: center;
        border: none;
      }
      &--error {
        background: $color-base-attention;
        border: none;
        @include flex-centerizer;
        &::before {
          content: "—";
          color: #fff;
          font-weight: 600;
          font-size: 18px;
        }
      }
      &--warn {
        background: #f7c849;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background 0.3s linear;
        &::before {
          content: "!";
          font-weight: 600;
          font-size: 19px;
          color: #fff;
        }
        &:hover {
          background-color: #fff;
          &::before {
            color: $color-base-accent;
          }
        }
      }
      &-tip {
        // display: none;
        opacity: 0;
        height: 0;
        overflow: hidden;
        visibility: hidden;
        position: absolute;
        top: calc(100% + 14px);
        right: -10px;
        padding: 10px;
        background: #fff;
        box-shadow: 0 2px 6px 0 rgba(69, 91, 99, 0.18);
        width: 259px;
        border-radius: 10px;
        transition: 0.2s;
        &::before {
          content: "▲";
          position: absolute;
          display: inline-block;
          top: -16px;
          right: 15px;
          transform: scaleX(1.6); /* Не забываем про префиксы */
          color: #fff;
          text-shadow: 0px -1px 1px #ececec;
          font-size: 20px;
        }
      }
      &:hover {
        .inputblock__indicator-tip {
          // display: block;
          overflow: visible;
          opacity: 1;
          height: auto;
          visibility: visible;
        }
      }
    }
    &__selectcompany {
      position: absolute;
      left: 0;
      top: 100%;
    }
    &--higher {
      margin-bottom: 96px;
    }
  }
  .linkcreatebox {
    display: flex;
    align-items: center;
    @media (max-width: 500px) {
      flex-direction: column;
    }
    &__field {
      @include hamster-field;
      background-color: #ececec;
      color: #000;
      min-height: 43px;
      display: flex;
      align-items: center;
      flex-grow: 2;
      @media (max-width: 500px) {
        width: 100%;
      }
      &--created {
        background: #d4f5de;
      }
    }
    &__button {
      @include hamster-submit;
      @include flex-centerizer;
      background-color: #ececec;
      color: #000;
      font-weight: 500;
      width: 191px;
      flex-shrink: 0;
      margin-left: 20px;
      min-height: 43px;
      &--copy {
        background-color: $color-base-accent;
        color: #fff;
      }
      @media (max-width: 500px) {
        margin-left: 0;
        margin-top: 45px;
      }
    }
  }
}
</style>