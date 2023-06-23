<template lang="pug">
	section.page-profile(v-if="isAuth")
		h1.page-profile__title Мой профиль
		section.page-profile__box
			.page-profile__userpic
			.page-profile__info
				.page-profile__info-box 
					router-link.page-profile__edit-link(:to="{name: 'editprofile'}") 
						icon-edit 
					p.page-profile__info-label Фамилия, имя, отчество
					b.page-profile__info-value {{profile.name}}
				.page-profile__info-box
					p.page-profile__info-label Телефон
					b.page-profile__info-value {{profile.phone|stylePhone}}
				.page-profile__info-box
					p.page-profile__info-label Email
					b.page-profile__info-value {{profile.email}}
			div.page-profile__statebars
				.page-profile__status.statebar
					i
						img(src="../assets/img/cap-status.png")
					p Статус
					b {{profile.privilege.name}}
				.page-profile__balance.statebar
					i
						img(src="../assets/img/cap-balance.png")
					p Баланс
					b {{profile.ballance|priceFormat}} ₽
			div.page-profile__link
				p.page-profile__link-label Ваша персональная ссылка
				input.page-profile__link-value( :class="{'page-profile__link-value--empty' : link==null}" ref="linkInput" readonly :value="link")
			div.page-profile__button
				button.page-profile__button-link(@click="hasLink" :disabled="disabledButton") {{link!=null ? 'Копировать' : 'Создать'}} 
			message(v-if="showMessage" text='Ссылка скопирована' @close="showMessage=false")
	section(v-else)
		p Чтобы пользоваться личным кабинетом, нужно авторизоваться
</template>

<style lang="scss" scoped>
.page-profile {
  &__box {
    @include contentbox;
    display: grid;
    grid-template-columns: 1fr 3fr 1.5fr;
    gap: 20px;
    row-gap: 27px;
    grid-template-areas:
      "userpic card state"
      "userpic link buttonLink";
    @media (max-width: 630px) {
      gap: 15px;
      grid-template-columns: 1fr 1fr;
      grid-template-areas:
        "userpic state"
        "card card"
        "link link"
        "buttonLink buttonLink";
    }
    @media (max-width: 425px) {
      grid-template-columns: 1fr;
      gap: 35px;
      grid-template-areas:
        "userpic"
        "state"
        "card"
        "link"
        "buttonLink";
    }
  }
  &__edit-link {
    float: right;
  }
  &__link {
    grid-area: link;
    &-label {
      font-size: 12px;
      line-height: 19px;
      margin-bottom: 8px;
      color: $color-text-gray;
      @media (max-width: 425px) {
        font-size: 12px;
      }
    }
    &-value {
      @include hamster-field;
      width: 100%;
      background-color: $color-pale-green;

      &--empty {
        border-color: #f0f0f0;
        background-color: white;
      }
    }
  }
  &__button {
    grid-area: buttonLink;
    align-self: end;
    display: flex;
    justify-content: center;
    &-link {
      @include hamster-submit;
      width: 157px;
      padding: 13px 15px;
    }
  }
  &__title {
    @include blocktitle;
  }
  &__userpic {
    grid-area: userpic;
    align-self: start;
    justify-self: center;
    background: url(../assets/img/login_thumb2x.png) no-repeat;
    background-size: cover;
    background-position: center;
    width: 100px;
    height: 100px;
    @media (max-width: 768px) {
      width: 92px;
      height: 92px;
    }
    @media (max-width: 425px) {
      width: 82px;
      height: 82px;
    }
  }
  &__statebars {
    grid-area: state;
    align-self: start;
    @media (max-width: 630px) {
      width: 100%;
    }
    @media (max-width: 425px) {
      width: 80%;
      margin: 0 auto;
    }
    .statebar {
      &:not(:last-child) {
        margin-bottom: 12px;
      }
      @media (max-width: 425px) {
        justify-content: center;
      }
    }
  }
  &__balance,
  &__status {
    @include statebar;
    @media (max-width: 425px) {
      font-size: 12px;
    }
  }
  &__info {
    grid-area: card;
    align-self: start;
    padding: 15px;
    border-radius: 10px;
    background-color: $color-base-light;
    border: 1px solid $color-border-gray;
    &-box {
      &:not(:last-child) {
        margin-bottom: 36px;
      }
    }
    &-label {
      font-size: 14px;
      line-height: 19px;
      color: $color-text-gray;
      @media (max-width: 425px) {
        font-size: 12px;
      }
    }
    &-value {
      display: inline-block;
      margin-top: 10px;
      font-weight: 500;
      line-height: 19px;
      color: $color-text-dark;
      @media (max-width: 425px) {
        font-size: 13px;
        margin-top: 6px;
      }
    }
  }
}
</style>

<script>
import { mapState, mapActions } from "vuex";
import message from "@/components/message.vue";
import iconEdit from "@/components/icons/iconEdit.vue";
export default {
  components: {
    iconEdit,
    message
  },
  data() {
    return {
      showMessage: false,
      link: null,
      disabledButton: false
    };
  },
  created() {
    this.profile && this.profile.referal_url
      ? (this.link = this.profile.referal_url)
      : "";
  },
  computed: {
    ...mapState("user", ["profile", "token"]),
    isAuth() {
      return (
        !!this.token && this.profile && Object.keys(this.profile).length > 0
      );
    },
    hasLink() {
      return this.link != null ? this.copyLink : this.createLink;
    }
  },
  watch: {
    isAuth(newVal) {
      if (newVal === false) {
        this.$router.push({ name: "account" });
      } else {
        this.profile.referal_url ? (this.link = this.profile.referal_url) : "";
      }
    }
  },
  methods: {
    ...mapActions("profile", ["generateLink"]),
    createLink() {
      this.disabledButton = true;
      this.generateLink()
        .then(response => {
          response.data.result == true
            ? (this.link = response.data.data)
            : this.showError("Не удалось создать ссылку, попробуйте позднее");
        })
        .catch(e => {
          console.log(e);
          this.showError("Произошла ошибка, попробуйте позднее");
        })
        .then(() => {
          this.disabledButton = false;
        });
    },
    copyLink() {
      this.copyToClipboard(this.link);
      this.showMessage = true;
      setTimeout(() => {
        this.showMessage = false;
      }, 2500);
    }
  }
};
</script>