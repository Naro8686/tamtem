<template lang="pug">
		section.registration--section
			button.registration--close(
				@click="$emit('close')"
				title="Закрыть"
			) x
			form.registration--form.form(
				@submit.prevent="validateForm()"
			)
				h1.form--title Регистрация #[br]профиля
				.form--field.field
					input.field--input(
						:class="{'error' : errors.has('name')}"
						type="text"
						placeholder="Ф.И.О."
						data-vv-name="name"
						data-vv-as="Ф.И.О."
						v-validate=`'required|min:2'`
						tabindex="1"
						v-model="form.name"
					)
					i.field--errors(
						v-if="errors.has('name')"
					) {{...errors.collect('name')}}
				.form--field.field
					input.field--input(
						:class="{'error' : errors.has('email')}"
						type="text"
						placeholder="Введите ваш email"
						data-vv-name="email"
						data-vv-as="Email"
						v-validate=`'required|email'`
						tabindex="2"
						v-model="form.email"
					)
					i.field--errors(
						v-if="errors.has('email')"
					) {{...errors.collect('email')}}
				.form--field.field
					input.field--input(
						:class="{'error' : errors.has('phone')}"
						type="text"
						placeholder="Введите ваш номер телефона"
						data-vv-name="phone"
						data-vv-as="Телефон"
						v-validate=`'required|mobilePhone'`
						tabindex="3"
						v-model="form.phone"
					)
					i.field--errors(
						v-if="errors.has('phone')"
					) {{...errors.collect('phone')}}
				.form--field.field--extended
					input.field--input(
						:class="{'error' : errors.has('password')}"
						:type="passwordFieldType"
						v-validate=`'required|min:6'`
						data-vv-name="password"
						data-vv-as="Пароль"
						placeholder="Пароль"
						tabindex="4"
						v-model="form.password"
						ref="password"
					)
					.field__action
						button(type="button" @click="isPasswordVisible=!isPasswordVisible" :class="{'active' : isPasswordVisible }").field__action-eye
					i.field--errors(
						v-if="errors.has('password')"
					) {{...errors.collect('password')}}
				//.form--field.field
					input.field--input(
						:class="{'error' : errors.has('repeatedPassword')}"
						:type="repeatedPasswordFieldType"
						v-validate=`'required|min:6|confirmed:password'`
						data-vv-name="repeatedPassword"
						data-vv-as="Повторите пароль"
						placeholder="Повторите пароль"
						tabindex="5"
						v-model="form.password_confirmation"
					)
					i.field--errors(
						v-if="errors.has('repeatedPassword')"
					) {{...errors.collect('repeatedPassword')}}
				.form--field.field--checkbox
						.checkbox          
							input.checkbox--input(
								v-model="form.license_agreement" 
								type="checkbox" 
								id="agreement" 
								data-vv-as='Согласие' 
								data-vv-name='license_agreement' 
								v-validate="'required'")
							label.checkbox--label(for="agreement" :class="{'req': errors.has('license_agreement')}") 
								| Я принимаю условия #[a(href="files/agreement.pdf") Пользовательского соглашения] и даю свое согласие на обработку персональных данных на условиях и целях, определенных #[a(href="/files/politic.pdf") политикой конфиденциальности]
						i.field--errors(
						v-if="errors.has('license_agreement')"
					) {{...errors.collect('license_agreement')}}
				.form--field.field--button
					button.field--button__submit(
						:class="{'disabled':loading}"
						type="submit"
						:disabled="loading"
					) Зарегистрироваться
				.form--field.field--registration
					p.text Есть аккаунт? #[br]
						a.link(href="javascript:void(0);" @click="signinClick()") Войти     
</template>
<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      serverErrors: {},
      loading: false,
      form: {
        name: null,
        email: null,
        phone: null,
        password: null,
        // password_confirmation: null,
        license_agreement: null
      },
      isPasswordVisible: false
    };
  },
  computed: {
    passwordFieldType() {
      return !this.isPasswordVisible ? "password" : "text";
    }
  },
  watch: {
    "form.phone"(newVal) {
      this.form.phone = newVal.replace(/[^0-9]/gi, "").slice(0, 11);
    }
  },
  methods: {
    ...mapActions("user", ["sendRegistrationData"]),
    signinClick(){
      this.$emit('showForm','authorizationForm');
    },
    validateForm() {
      this.yandexReachGoal("agent_registr");
      this.googleReachGoal("agent_registr");
      this.$validator.validateAll().then(result => {
        if (result) {
          this.formSend();
        }
      });
    },
    formSend() {
      this.loading = true;
      const data = Object.assign({}, this.form);
      data.phone = data.phone.replace(/[^0-9]/gi, "").replace(/^[78]/, "");

      const agentId = sessionStorage.getItem("agent_id");
      if (agentId) {
        data.agent_id = agentId;
      }
      this.sendRegistrationData(data)
        .then(response => {
          if (response.result) {
            this.showSuccess(
              `Вы успешно зарегистрировались. На почту ${data.email} отправлено письмо с инструкциями`
            );
            this.$emit("showForm", "authorizationForm");
          } else {
            this.showError("Произошла ошибка, попробуйте позднее");
          }
        })
        .catch(err => {
          if (err.response && err.response.data.errors) {
            const serverErrors = Object.values(err.response.data.errors);
            this.showError(...serverErrors[0]);
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

.registration {
  &--section {
    display: flex;
    flex-direction: column;
    max-width: 460px;
    // max-height: 866px;
    height: max-content;
    width: 100%;
    border-radius: $border-radius-standart;
    padding: 10px;
    background-color: #fff;
    padding-bottom: 64px;
    @media (max-width: 425px) {
      border-radius: 0;
      min-height: 100vh;
    }
  }
  &--close {
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
    outline: none !important;
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
    // margin-bottom: 7px;
    margin-top: 54px;
    margin-bottom: 15px;
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
    padding-left: 12px;
    padding-right: 12px;
    color: $color-text-gray;
    &.error {
      border: 1px solid $danger;
    }
  }
  &__action {
    position: absolute;
    height: 20px;
    top: 15px;
    right: 10px;
    display: flex;
    align-items: center;
    button {
      cursor: pointer;
      outline: none;
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
  &--extended {
    position: relative;
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
    margin-top: 49px;
    &__submit {
      outline: none !important;
      cursor: pointer;
      width: 274px;
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
    display: inline-block;
    align-items: center;
    min-height: 14px;
    position: relative;
    padding-left: 20px;
    margin: 0;
    &.req:before {
      border-color: $danger !important;
      border-width: 1px !important;
    }
    a {
      color: $color-base-dark;
      text-decoration: none;
      font: inherit;
      font-weight: inherit;
      font-weight: 500;
    }
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