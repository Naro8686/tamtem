<template lang="pug">
section.profileedit
	h1.profileedit__title Редактировать профиль
	//- section
	form.editform(@submit.prevent="validateUserdataForm")
		.editform__userpic(:style="addBackground")
			label(for="edit-userpic").userpic-upload
				span.userpic-upload__icon +
				input#edit-userpic.hidden(
					type="file"  
					name="edit-userpic"
					data-vv-as="Фото"
					data-vv-name="photo"
					v-validate="'image|size:10000|transform'"
				)
		.editform__box.editform__box--name
			label.editform__label фамилия, Имя, отчество
			input(v-model="userdata.name"
			data-vv-name="name"
			data-vv-as="Имя"
			v-validate=`'required|min:2'`
			tabindex="1").editform__input
			i.editform__errors(
				v-if="errors.has('name')"
			) {{...errors.collect('name')}}			
		.editform__box.editform__box--phone
			label.editform__label Телефон
			input(v-model="userdata.phone"
				placeholder="+7 (999) 999-99-99"
				data-vv-name="phone"
				data-vv-as="Телефон"
				v-validate=`'required|mobilePhone'`
			).editform__input
			i.editform__errors(
				v-if="errors.has('phone')"
			) {{...errors.collect('phone')}}
		.editform__controls.profileedit__controls
			button(type="submit").editform__submit.profileedit__controls-submit Сохранить изменения
		.editform__photo
			i.editform__errors(
				v-if="errors.has('photo')"
			) {{...errors.collect('photo')}}		
	h2.profileedit__title Пароль и безопасность
	form.passchangeform(@submit.prevent="validatePasswordForm")
		.passchangeform__box.passchangeform__box--oldpass
			label.passchangeform__label Старый пароль 
			input.passchangeform__input(
				v-model="passwords.password_old"
				data-vv-as="Старый пароль"
				data-vv-name="old_password"
				v-validate=`'required|min:6'`
			)
			i.editform__errors(
				v-if="errors.has('old_password')"
			) {{...errors.collect('old_password')}}
		.passchangeform__box.passchangeform__box--newpass
			label.passchangeform__label Новый пароль
			input.passchangeform__input(
				:type="passwordFieldType"
				v-model="passwords.password"
				data-vv-as="Новый пароль"
				data-vv-name="password"
				ref="password"
				v-validate=`'required|min:6'`)
			button.passchangeform__showpass(
				type="button"
				@click="passwordVisible=!passwordVisible" 
				:class="{'active' : passwordVisible}"
			)
			i.editform__errors(
				v-if="errors.has('password')"
			) {{...errors.collect('password')}}
		.passchangeform__box.passchangeform__box--repeatpass
			label.passchangeform__label Повторите новый пароль
			input.passchangeform__input(
				:type="repeatedPasswordFieldType"
				v-model="passwords.password_confirmation"
				data-vv-as="Подтвердите пароль"
				data-vv-name="password_confirmation"
				v-validate=`'required|min:6|confirmed:password'`)
			button.passchangeform__showpass(
				type="button"
				@click="repeatedPasswordVisible=!repeatedPasswordVisible" 
				:class="{'active' : repeatedPasswordVisible}"
			)
			i.editform__errors(
				v-if="errors.has('password_confirmation')"
			) {{...errors.collect('password_confirmation')}}
		.passchangeform__controls.profileedit__controls
			button(type="submit").passchangeform__submit.profileedit__controls-submit Сохранить изменения
</template>

<style lang="scss" scoped>
.profileedit {
  &__title {
    @include blocktitle;
  }
  &__controls {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 26px;
    @media (max-width: 425px) {
      justify-content: space-around;
      flex-wrap: wrap;
    }
    &-discard {
      background: none;
      border: none;
      color: $color-text-gray;
      margin-right: 5%;
      @media (max-width: 425px) {
        font-size: 13px;
        margin: 0;
        margin-bottom: 15px;
      }
    }
    &-submit {
      @include hamster-submit;
      flex-shrink: 0;
    }
  }
  .editform {
    @include contentbox;
    margin-bottom: 80px;
    display: grid;
    row-gap: 30px;
    column-gap: 20px;
    grid-template-columns: 100px 1fr auto;
    grid-template-areas:
      "userpic name name"
      "userpic phone controls";
    @media (max-width: 730px) {
      grid-template-areas:
        "userpic name ."
        "userpic phone ."
        "userpic . controls";
    }
    @media (max-width: 600px) {
      grid-template-columns: 1fr;
      row-gap: 40px;
      grid-template-areas:
        "userpic"
        "name"
        "phone"
        "controls";
    }
    &__userpic {
      grid-area: userpic;
      align-self: start;
      background: url(../assets/img/login_thumb.png) no-repeat;
      background-size: cover;
      background-position: center;
      width: 100px;
      height: 100px;
      position: relative;
      @media (max-width: 768px) {
        width: 92px;
        height: 92px;
      }
      @media (max-width: 600px) {
        justify-self: center;
      }
      @media (max-width: 425px) {
        width: 82px;
        height: 82px;
      }
    }
    &__box {
      @include hamster-inputbox;
      &--name {
        grid-area: name;
      }
      &--phone {
        grid-area: phone;
      }
    }
    &__label {
      @include hamster-label;
    }
    &__errors {
      @include hamster-field-error;
    }
    &__input {
      @include hamster-field;
    }
    &__controls {
      grid-area: controls;
    }
    .userpic-upload {
      position: absolute;
      bottom: 0;
      right: 0;
      &__icon {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: 500;
        cursor: pointer;
        color: $color-base-light;
        background-color: $color-base-accent;
        box-shadow: 0 12px 16px 0 rgba(69, 91, 99, 0.1);
        width: 24px;
        height: 24px;
        border-radius: 4px;
      }
    }
  }
  .passchangeform {
    @include contentbox;
    display: grid;
    row-gap: 30px;
    column-gap: 20px;
    grid-template-columns: 100px 1fr auto;
    grid-template-areas:
      "old old ."
      "new new ."
      "repeat repeat controls";
    @media (max-width: 730px) {
      grid-template-areas:
        "old old ."
        "new new ."
        "repeat repeat ."
        ". . controls";
    }
    @media (max-width: 600px) {
      grid-template-columns: 1fr;
      row-gap: 40px;
      grid-template-areas:
        "old"
        "new"
        "repeat"
        "controls";
    }
    &__box {
      position: relative;
      @include hamster-inputbox;
      &--oldpass {
        grid-area: old;
      }
      &--newpass {
        grid-area: new;
      }
      &--repeatpass {
        grid-area: repeat;
      }
    }
    &__label {
      @include hamster-label;
    }
    &__input {
      @include hamster-field;
    }
    &__showpass {
      cursor: pointer;
      position: absolute;
      width: 20px;
      right: 10px;
      top: 33px;
      height: 20px;
      padding: 0;
      outline: none !important;
      background-color: transparent;
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
    &__controls {
      grid-area: controls;
    }
    // &__discard {
    // 	background: none;
    // 	border: none;
    // 	color: $color-text-gray;
    // 	margin-right: 5%;
    // 	@media(max-width: 425px) {
    // 		font-size: 13px;
    // 		margin: 0;
    // 		margin-bottom: 15px;
    // 	}
    // }
    // &__submit {
    // 	@include hamster-submit;
    // 	flex-shrink: 0;
    // }
  }
}
</style>

<script>
import { mapState, mapActions } from "vuex";
import { Validator } from "vee-validate";
export default {
  data() {
    return {
      userdata: {
        name: null,
        phone: null,
        photo: null
      },
      passwords: {
        password_old: null,
        password: null,
        password_confirmation: null
      },
      passwordVisible: false,
      repeatedPasswordVisible: false,
      base64Img: null
    };
  },
  created() {
    this.userdata.name = this.profile.name;
    this.userdata.phone = this.profile.phone;
    if (this.profile.photo) {
      this.fileCreate(this.profile.photo).then(result => {
        this.fileTransform(result);
      });
    }
    Validator.extend("transform", {
      validate: value => {
        this.fileTransform(value[0]);
        return true;
      }
    });
  },
  watch: {
    "userdata.phone"(newVal) {
      this.userdata.phone = newVal.replace(/[^0-9]/gi, "").slice(0, 11);
    }
  },
  computed: {
    ...mapState("user", ["profile"]),
    passwordFieldType() {
      return this.passwordVisible ? "text" : "password";
    },
    repeatedPasswordFieldType() {
      return this.repeatedPasswordVisible ? "text" : "password";
    },
    addBackground() {
      if (this.base64Img) {
        return `background: url(${this.base64Img}) no-repeat scroll center center / cover;`;
      } else return "";
    }
  },
  methods: {
    ...mapActions("profile", ["fileCreate", "profileUpdate", "updatePassword"]),
    ...mapActions("user", ["setProfile"]),
    validateUserdataForm() {
      this.$validator.validateAll(["name", "phone"]).then(result => {
        if (result) {
          this.prepareData();
        }
      });
    },
    validatePasswordForm() {
      this.$validator
        .validateAll(["old_password", "password", "password_confirmation"])
        .then(result => {
          if (result) {
            this.updatePassword(this.passwords)
              .then(response => {
                if (response.data.result == true) {
                  this.showSuccess("Пароль успешно обновлён.");
                }
              })
              .catch(err => {
                if (err.response && err.response.data.result == false) {
                  this.showError(
                    ...Object.values(err.response.data.error.errors)[0]
                  );
                } else {
                  this.showError("Не удалось обновить пароль");
                }
              });
          }
        });
    },
    prepareData() {
      const data = new FormData();
      for (const key in this.userdata) {
        this.userdata[key]
          ? data.set(
              key,
              key == "phone"
                ? this.userdata[key]
                    .replace(/[^0-9]/gi, "")
                    .replace(/^[78]/, "")
                : this.userdata[key]
            )
          : "";
      }
      const payload = {
        id: this.profile.id,
        data: data
      };
      this.profileUpdate(payload)
        .then(response => {
          if (response.data.result == true) {
            this.showSuccess("Данные профиля успешно обновлены");
            this.setProfile(response.data.data);
          }
        })
        .catch(err => {
          console.log(err);
          this.showError("Произошла ошибка, попробуйте позднее");
        });
    },
    fileTransform(file) {
      const reader = new FileReader();
      const that = this;
      reader.readAsDataURL(file);
      reader.onload = function() {
        that.userdata.photo = file;
        that.base64Img = reader.result;
      };
      reader.onerror = function(err) {
        console.error(err);
        that.showError("Не удалось обработать фотографию");
      };
    }
  }
};
</script>