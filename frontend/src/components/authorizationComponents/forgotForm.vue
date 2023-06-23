<template lang="pug">
    section.forgot--section
      button.forgot--close(
        @click="$emit('close')"
        title="Закрыть"
      ) x
      form.forgot--form.form(
        @submit.prevent="validateForm()"
      )
        h1.form--title Сброс #[br] пароля
        .form--field.field
          input.field--input(
            :class="{'error' : errors.has('email')}"
            type="text"
            placeholder="Введите ваш email"
            data-vv-name="email"
            data-vv-as="Email"
            v-validate=`'required|email'`
            tabindex="1"
            v-model="email"
          )
          i.field--errors(
            v-if="errors.has('email')"
          ) {{...errors.collect('email')}}
        .form--field.info
            p.info--text Если вы забыли пароль, введите email.
            p.info--text Контрольная строка для смены пароля, #[br] а также ваши регистрационные данные, #[br] будут высланы вам по email.  
        .form--field.field--button
          button.field--button__submit(
            :class="{'disabled':loading}"
            type="submit"
            :disabled="loading"
          ) Отправить
        .form--field.field--forgot
          p.text
           a.link(href="javascript:void(0);" @click="signinClick()") Войти     
</template>
<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      loading: false,
      email: null
    };
  },
  computed: {
    passwordFieldType() {
      return !this.ispasswordVisible ? "password" : "text";
    }
  },
  methods: {
    ...mapActions("user", ["passwordReset"]),
    signinClick(){
      this.$emit('showForm','authorizationForm');
    },
    validateForm() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.formSend();
        }
      });
    },
    formSend() {
      this.loading = true;
      const data = {};
      data.email = this.email;
      this.passwordReset(data)
        .then(response => {
          console.log(response);
          if (response.result == true) {
            this.showSuccess(
              `Письмо для подтверждения отправлено на ${this.email}`
            );
          } else {
            console.log(response.error);
            this.showError(...Object.values(response.error)[0]);
          }
        })
        .catch(err => {
          console.log(err);
          this.showError("Произошла ошибка, попробуйте позднее");
        })
        .then(() => {
          this.loading = false;
        });
    }
  }
};
</script>
<style lang="scss" scoped>
.disabled {
  opacity: 0.8;
}

.forgot {
  &--section {
    display: flex;
    flex-direction: column;
    max-width: 460px;
    max-height: 762px;
    height: max-content;
    width: 100%;
    border-radius: $border-radius-standart;
    padding: 10px;
    background-color: #fff;
    padding-bottom: 114px;
  }
  &--close {
    outline: none !important;
    padding: 0;
    width: 24px;
    height: 24px;
    line-height: $fontsize-base;
    font-size: $fontsize-base;
    background-color: $closebutton-background;
    color: #fff;
    border: none;
    border-radius: $border-radius-small;
    align-self: flex-end;
    cursor: pointer;
    outline: none;
  }
  &--form {
    display: flex;
    flex-direction: column;
    width: 278px;
    align-self: center;
  }
}
.form {
  &--title {
    font: $font-semibold;
    color: $color-text-bright;
    font-size: $fontsize-desk-header;
    margin-bottom: 7px;
    margin-top: 64px;
  }
  &--field {
    margin-top: 40px;
  }
}
.info {
  margin-top: 17px;
  &--text {
    padding-left: 20px;
    font: $font-regular;
    font-size: 10px;
    color: #000;
  }
}
.field {
  &--input {
    height: 47px;
    width: 278px;
    border: 1px solid $color-border-gray;
    border-radius: $border-radius-small;
    background-color: $color-base-gray-light;
    padding-left: 20px;
    color: $color-text-gray;
    &.error {
      border: 1px solid $danger;
    }
  }
  &--errors {
    color: $danger;
    font: $font-regular;
    font-size: 10px;
  }
  &--checkbox {
    margin-top: 15px;
  }
  &--button {
    display: flex;
    justify-content: center;
    margin-top: 80px;
    &__submit {
      outline: none !important;
      cursor: pointer;
      width: 165px;
      height: 44px;
      border: none;
      border-radius: 22px;
      background-color: $color-green-elements;
      text-align: center;
      color: #fff;
      text-transform: uppercase;
      font: $font-bold;
      font-size: $fontsize-smaller;
    }
  }
  &--forgot {
    margin-top: 23px;
    display: flex;
    justify-content: center;
    .text {
      text-align: center;
    }
    .link {
      outline: none !important;
      text-decoration: none;
      font: $font-bold;
      font-size: $fontsize-base;
      color: $form-links-color;
    }
  }
}
</style>