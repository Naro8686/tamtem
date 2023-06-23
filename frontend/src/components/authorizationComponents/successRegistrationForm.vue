<template lang="pug">
    section.success--section
      button.success--close(
        @click="$emit('close')"
        title="Закрыть"
      ) x
      .success--form.form
        h1.form--title Спасибо,#[br]что вы с нами!
        .form--field.info
            p.info--text Ваш аккаунт успешно активирован.  
        .form--field.form--success
          p.text
           a.link(href="javascript:void(0);" @click="signinClick()") Войти     
</template>
<script>
export default {
  methods:{
    signinClick(){
      this.$emit('showForm','authorizationForm');
    }
  }
}
</script>
<style lang="scss" scoped>
.success {
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

.info {
  margin-top: 50px;
  &--text {
    font: $font-regular;
    font-size: 14px;
    color: #000;
  }
}
&--success {
    margin-top: 53px;
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