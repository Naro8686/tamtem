<template lang="pug">
  .content
    .profileNew(v-if="profile")
      form.profile__form(@submit.prevent="validateBeforeSubmit")
        .custom-input-block
          .user__logo-block
            img#user__logo.user__logo(:style="addbackground()")
          .user__logo-change
            input#logo-img.user__logo-change-input(type="file", placeholder="Выберите фотографию", data-vv-as="Фото", data-vv-name="photo", name="image_field", v-validate=`'isImage'`)
            label(for="logo-img",style="width:auto") Добавить фото
        CustomInput(dataId="firstname", dataTitle="Имя", dataName="firstname", :dataValue="profile.profile.name", @input="form.firstname = $event")
        .custom-input-block
          input#userphone(
            placeholder="Телефон",
            data-vv-as="Телефон",
            data-vv-name="userphone",
            v-mask="['+7 (###) ### ##-##']",
            v-validate=`'required|phoneFormat'`,
            v-model="form.userphone"
          ).custom-input-input
          label.custom-input-label(for="userphone") Телефон
        CustomInput(dataId="usermail", dataTitle="E-mail", dataName="usermail", :dataValue="profile.profile.email", :disabled="true", message="E-mail изменить нельзя")
        .custom-btn-green
          button.custom-btn-green__btn.profile__btn(type="submit", :disabled="loading")
            | Сохранить
</template>

<script>
import CustomInput from "../../GeneralComponents/components/CustomInput"
import {mask} from "vue-the-mask"
import {Validator} from "vee-validate";

export default {
  components: {
    CustomInput
  },
  directives: {
    mask
  },
  props: {
    profile: {
      type: Object
    }
  },
  data() {
    return {
      loading: false,
      err: {},
      form: {
        photo: null,
        firstname: null,
        userphone: null
      },
      base64Img: null,
      formData: new FormData()
    }
  },
  created() {
    // this.form.phone = this.userphone;

    Validator.extend("phoneFormat", {
      getMessage: (field) => "Неверный формат телефона",
      validate: (value) => {
        return value.length == 18
      }
    });
    Validator.extend("isImage", {
      getMessage: (field) => "Разрешены только изображения",
      validate: (value) => {
        const extArr = ["png", "jpg", "jpeg", "gif", "bmp"]
        const ext = value[0].name.split(".").pop()
        if (extArr.indexOf(ext) === -1) return false
        else {
          this.transformFile(value[0])
          return true
        }
      }
    });
  },
  mounted() {
    if (this.profile) {
      this.updateFields()
    }
  },
  watch: {
    profile: function (newVal, oldVal) {
      this.updateFields()
    }
  },
  methods: {
    clearPhone(phone) {
      let res = phone.slice(3)
      return res.replace(/[\(\)\ \-]/g, "")
    },
    setFields(result) {
      for (let key in result) {
        if (result[key]) {
          switch (key) {
            case "photo":
              this.formData.set("photo", result[key])
              break
            case "userphone":
              this.formData.set("phone", this.clearPhone(result[key]))
              break
            case "firstname":
              this.formData.set("name", result[key])
              break
            default:
              break
          }
        }
      }
      this.profileUpdate()
    },
    validateBeforeSubmit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.err = {}
          // вызвать сборку
          this.setFields(this.form)
        }
      })
    },
    updateFields() {
      if (this.profile) {
        this.form.firstname = this.profile.profile.name;
        this.form.userphone = this.profile.profile.phone;
      }
    },
    profileUpdate() {
      this.loading = true;
      axios
          .post("/api/v1/user/update", this.formData, {
            headers: {"Content-Type": "multipart/form-data"}
          })
          .then((resp) => {
            this.loading = false
            if (resp.data.error) {
              this.err = resp.data.error
            } else {
              this.$store.dispatch("setProfile", {profile: resp.data.data})
              this.$emit("profileUpdateEmit")
              this.$router.push({name: "lk.profile"})
              this.$store.dispatch("setSnackbar", {
                color: "success",
                text: "Данные успешно обновлены",
                toggle: true
              })
            }
          })
          .catch((error) => {
            this.printErrorOnConsole(error)
            this.loading = false
            this.err = error.response.data.errors
          })
    },
    addbackground() {
      let res = {
        backgroundImage: 'url(/images/no-photo.svg)',
        backgroundRepeat: 'no-repeat',
        backgroundPosition: 'center',
        backgroundSize: 'contain'
      };
      let old = this.profile.profile.photo

      if (old && old.length > 0) {
        res.backgroundImage = `url('${old}')`;
      }

      if (this.base64Img) {
        res.backgroundImage = `url(${this.base64Img})`;
      }

      return res;
    },
    transformFile(file) {
      const app = this
      if (file) {
        this.form.photo = file
        const reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onload = function () {
          app.base64Img = reader.result
        }
        reader.onerror = function (error) {
          this.printErrorOnConsole(error)
        }
      }
    },
  }
}
</script>
<style>
.profileNew .user__logo-block {
  width: 110px;
  height: 110px;
  margin-bottom: 25px;
  text-align: center;
  margin-right: auto;
  margin-left: auto;
}

.profileNew .user__logo-change {
  display: flex;
  justify-content: center;
}

.profileNew .user__logo-block > img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.profileNew .user__logo-change-input {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.profileNew .user__logo-change label {
  background: #ecf2fe;
  border-radius: 5px;
  border: none;
  font-family: Montserrat;
  font-style: normal;
  font-weight: 500;
  font-size: 12px;
  line-height: 15px;
  color: #6e6e6e;
  width: 180px;
  height: 38px;
  padding: 11px 20px;
  cursor: pointer;
}
</style>
