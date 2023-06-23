<template lang="pug">
    section.authorization--section
      button.authorization--close(
        @click="$emit('close')"
        title="Закрыть"
      ) x
      form.authorization--form.form(
        @submit.prevent="validateForm()"
      )
        h1.form--title Войти
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
        .form--field.field
          input.field--input(
            :class="{'error' : errors.has('password')}"
            :type="passwordFieldType"
            v-validate=`'required|min:6'`
            data-vv-name="password"
            data-vv-as="Пароль"
            placeholder="Пароль"
            tabindex="2"
            v-model="password"
          )
          i.field--errors(
            v-if="errors.has('password')"
          ) {{...errors.collect('password')}}
        .form--field.field--checkbox(v-if="isLetterResendButtonVisible")
            a.resend-letter(href="javascript:void(0);" @click="resendMail()") Отправить письмо повторно
        .form--field.field--checkbox
            .checkbox          
              input.checkbox--input(type="checkbox" id="saveemail")
              label.checkbox--label(for="saveemail") Запомнить меня
            i.field--errors
        .form--field.field--button
          button.field--button__submit(
            :class="{'disabled':loading}"
            type="submit"
            :disabled="loading"
          ) Войти
        .form--field.field--forgot
          a.link(href="javascript:void(0);" @click="$emit('showForm','forgotForm')") Забыли пароль?        
        //-.form--field.field--registration
          p.text Или пройти #[br]
           a.link(href="javascript:void(0);" @click="$emit('showForm','registrationForm')") регистрацию     
</template>
<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      loading: false,
      email: null,
      password: null,
      ispasswordVisible: false,
      isLetterResendButtonVisible: false
    };
  },
  computed: {
    passwordFieldType() {
      return !this.ispasswordVisible ? "password" : "text";
    }
  },
  methods: {
    ...mapActions("user", ["sendLoginData", "resendLetter"]),
    validateForm() {
      this.yandexReachGoal("voity_on_form_auth");
      this.$validator.validateAll().then(result => {
        if (result) {
          this.formSend();
        }
      });
    },
    resendMail() {
      const data = {
        email: this.email
      };
      this.resendLetter(data)
        .then(response => {
          if (response.result == true) {
            this.showSuccess(
              `Письмо для подтверждения отправлено на ${this.email}`
            );
          }
        })
        .catch(() => {
          this.showError("Произошла ошибка, попробуйте позднее");
        });
    },
    formSend() {
      this.loading = true;
      const data = {};
      (data.email = this.email), (data.password = this.password);
      this.sendLoginData(data)
        .then(response => {
          if (response.result == false) {
            this.showError(response.error.message);
            response.error.error_code == 0
              ? (this.isLetterResendButtonVisible = true)
              : "";
          } else {
            this.$emit("close");
            this.$router.push({ name: "home" }).catch(() => {});
          }
        })
        .catch(err => {
          if (err.response && err.response.data.error) {
            this.showError(
              err.response.data.error.message || err.response.data.error
            );
          } else {
            this.showError("Произошла ошибка, попробуйте позднее");
          }
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
.resend-letter {
  outline: none !important;
  text-decoration: none;
  font: $font-bold;
  font-size: $fontsize-smaller;
  color: $form-links-color;
}
.authorization {
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
    @media (max-width: 425px) {
      border-radius: 0;
      min-height: 100vh;
    }
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
    font: $font-medium;
    color: $color-text-bright;
    font-size: $fontsize-desk-header;
    margin-bottom: 7px;
    margin-top: 64px;
  }
  &--field {
    margin-top: 30px;
  }
}
.field {
  position: relative;
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
    position: absolute;
    top: calc(100% + 3px);
    left: 15px;
  }
  &--checkbox {
    margin-top: 30px;
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
      background-color: $color-base-accent;
      text-align: center;
      color: #fff;
      text-transform: uppercase;
      font: $font-bold;
      font-size: $fontsize-smaller;
    }
  }
  &--forgot,
  &--registration {
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
.checkbox {
  .checkbox--input {
    display: none;
  }
  .checkbox--label {
    font: $font-regular;
    font-size: 10px;
    display: flex;
    align-items: center;
    min-height: 14px;
    position: relative;
    padding-left: 20px;
    margin: 0;
  }
  .checkbox--input + .checkbox--label:before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 4px;
    border: 1px solid $color-gray-dark;
  }
  .checkbox--input:checked + .checkbox--label:before {
    background: url($check-background) $color-base-accent;
    background-repeat: no-repeat, no-repeat;
    background-size: 70%, contain;
    background-position: center;
    border-color: $color-base-accent;
  }
}
</style>