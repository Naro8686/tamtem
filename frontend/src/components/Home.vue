<template lang="pug">
	section.home(v-if="isAuth")
		//-section().home-begin
			a(href="https://www.youtube.com/watch?v=Ibsa0NYU0t4" target="_blank").home-begin__link
				h1.home-begin__title С чего начать работу с agent.tamtem.ru?
				div.home-begin__pic
					p.home-begin__round
		section().home-begin
			a(href="https://www.youtube.com/watch?v=gkvjUHSROVs" target="_blank").home-begin__link
				h1.home-begin__title Подробное описание как добавить компанию
				div.home-begin__pic
					p.home-begin__round
		section.home-recent
			h2.home__title.home-recent__title Привлекайте компании и получайте до 20 0000 рублей ежемесячно
			h3.home__titleadd.home-recent__titleadd Стоимость регистрации 1 компании 50 рублей #[br] Ежедневные выплаты от 300 рублей без комиссии
			div.home-recent__container
				ul.home-recent__bidlist
					li(v-for="bid in bids")
						router-link(:to="{name: 'biddetail', params: {id: bid.id, bidData:bid}}").home-recent__link
							bidcard(:bid='bid')
				//- button.home-recent__more Показать другие заказы
		//- section.home-rating
			h2.home__title Ваш рейтинг
			ul.home-rating__list
				li.home-rating__item.rating-item.rating-item--links
					div.rating-item__box
						p.picture
							img(src="../assets/img/mainpage/content/link.png")
						p.value 1000
					p.rating-item__label Количество #[br] созданных ссылок
				li.home-rating__item.rating-item.rating-item--companies
					div.rating-item__box
						p.picture
							img(src="../assets/img/mainpage/content/company.png")
						p.value 52
					p.rating-item__label Количество #[br] компаний в портфеле
				li.home-rating__item.rating-item.rating-item--actives
					div.rating-item__box
						p.picture
							img(src="../assets/img/mainpage/content/deal.png")
						p.value 28
					p.rating-item__label Количество #[br] активных компаний
	section.home(v-else :class="{'loading' : isLoading}")
		section.home-introduction
			h1.home__title.home-introduction__title Краудсорсинговый сервис
			b.home-introduction__cap для дополнительного заработка без вложений с долгосрочной перспективой
			lazy-youtube-video(@videoLoaded="videoClick()" url="https://www.youtube.com/watch?v=gkvjUHSROVs")
			//--a(href="/registration" @click.prevent="openForm('registrationForm')").home-introduction__button Хочу стать агентом
			section.supplier-tarifs
			h2.home__title.home-reviews__title Выплата
			div.container
			.row
				.col
					h2.supplier__title.supplier-tarifs__title до 20 000 рублей ежемесячно
					div.supplier-tarifs__cap 
						b 50₽
					h2.supplier__title.supplier-tarifs__title за регистрацию каждой #[br]#[br] компании по предложенному списку
					div.supplier-tarifs__text
						p *Вывод денежных средств осуществляется с помощью Яндекс.Деньги на банковскую карту РФ от 100 рублей
						img(src="../assets/img/payment/yandex-money.jpg" alt="yandex-money")
					div.supplier-tarifs__btn
					
						//-a(href="/registration" @click.prevent="openForm('registrationForm')").increasetwo__button Зарегистрироваться сейчас
		section.home-answers
			h2.home__title.home-answers__title Ответы на самые частые вопросы
			div.home-answers__wrapper
				ul.home-answers__list
					li.home-answers__box
						a(href="http://blog.tamtem.ru/news/companynews/Kak_zarabotat_realnye_dengi").home-answers__item
							div.home-answers__pic
								//- img(src="../assets/img/mainpage/answers/platform.svg")
								img(:src="`${fullPath}/img/mainpage/answers/payment.svg`")
							h4.home-answers__cap Как заработать реальные деньги или обновление Агентов 2.0
							p.home-answers__text В этой статье мы расскажем о том, как быстро заработать и вывести деньги с сервиса, покажем изменения в нашей работе и какую пользу это принесет вам, как Агентам
							p.home-answers__link
								span Читать
								i
									iconLongArrow
					li.home-answers__box
						a(href="http://blog.tamtem.ru/news/companynews/novosti_dlya_agentov").home-answers__item
							div.home-answers__pic
								//- img(src="../assets/img/mainpage/answers/payment.svg")
								img(:src="`${fullPath}/img/mainpage/answers/platform.svg`")
							h4.home-answers__cap Новые поощрения для Агентов
							p.home-answers__text #[br] Новости для тех, кто работает с нами уже постоянно. Не знаете где найти нужные ссылки- читайте здесь.
							p.home-answers__link
								span Читать
								i
									iconLongArrow
					li.home-answers__box
						a(href="http://blog.tamtem.ru/news/case/kak_zarabotat_v_dekrete").home-answers__item
							div.home-answers__pic
								img(:src="`${fullPath}/img/mainpage/answers/howitwork.svg`")
							h4.home-answers__cap Бывших работодателей не бывает, или как я заработала на Agent.tamtem.ru
							p.home-answers__text В этой статье Мария рассказала о своем опыт сотрудничества с agent.tamtem.ru и получилось ли заработать с помощью нашего сайта. Читаем и перенимаем опыт
							p.home-answers__link
								span Читать
								i
									iconLongArrow
		section.home-answers
			h2.home__title.home-answers__title Что говорят о нас клиенты
			div.home-answers__wrapper
				ul.home-answers__list
					li.home-answers__box
						p.feedback-card__name Игорь Носиков
							div.feedback-card__stars
							rating(:rate="5")
							div.feedback-card__text
							p.home-answers__text #[br]Мои друзья и знакомые увидев этот сайт и мой балланс, интересуются: «А я так смогу?» , «А объясни!», «А я так тоже хочу!». Мой Вам совет потратьте время, объясните! #[br]#[br]Вы не растите себе конкурента, а помогаете заработать друзьям. Все хотят денег, такое уж время. А здесь есть возможность дополнительно заработать, так что рекомендую.
					li.home-answers__box
						p.feedback-card__name Алексей Мальцов
							div.feedback-card__stars
							rating(:rate="4")
							div.feedback-card__text
							p.home-answers__text #[br]Это реально выгодный сервис. На данный момент интернет перенасыщен различными биржами, сайтами, сервисами, которые обещают золотые горы, а в итоге заработать на них можно копейки. На данном сайте, по крайней мере, все честно и легально. Выплаты осуществляются стабильно. Да, с самого начала можно не ждать золотых гор, нужно немного времени вникнуть, и начать собственное развитие. #[br]#[br]Хорошо что сервис не требует постоянного нахождения на нем, можно использовать его как второстепенный заработок, и подрабатывать примерно 2, 3, 4 часа в день при этом иметь неплохую, стабильную, и даже со временем, пассивную прибыль!
					li.home-answers__box
						p.feedback-card__name Дмитрий Говоров
							div.feedback-card__stars
							rating(:rate="4")
							div.feedback-card__text
							p.home-answers__text #[br]У меня сезонный заработок, и в данный момент работы нет. Искал в интернете способы заработать и наткнулся на этот сервис. Сначала показалось что очень все запутано и сложно. Но, решил, что я хуже всех что-ли и зарегистрировался. #[br]Оказалось все более прозаично. У меня уже бронзовый статус и хороший портфель компаний. #[br]#[br]Реально все работает, не халява конечно, приходиться впахивать, но заработанные деньги "греют душу". #[br]Трудно сделать первый шаг, но потом как по накатанной. Тем более, что всегда помогут, подскажут, объяснят что и как. Вывод заработка моментальный. Все зависит от тебя, поработал-заработал. 
		section.home-reviews
			h2.home__title.home-reviews__title СМИ о нас
			div.home-reviews__wrapper
				ul.home-reviews__list
					li.home-reviews__box(v-for="item in reviews")
						a(:href="item.src").home-reviews__item
							//- h4.home-reviews__cap {{item.title}}
							p.home-reviews__text {{item.text}}
							p.home-reviews__link
								span.link-name {{item.name}}
		section.home-reviews
			h2.home__title.home-reviews__title Мы в соцсетях, возникнут вопросы - пиши!
			
		//-section.home-feedback
			div.home-feedback__pic
				img(:src="`${fullPath}/img/mainpage/content/reviews.png`" alt="reviews")
			h2.home__title.home-feedback__title Отзывы и предложения
			form.home-feedback__form
				textarea(placeholder="Введите текст").home-feedback__text
				input(placeholder="Email").home-feedback__email
				button(type="submit").home-feedback__btn Отправить

	
</template>

<script>
import { mapState } from "vuex";
import bidcard from "@/components/bidcard";
import LazyYoutubeVideo from "vue-lazy-youtube-video";
import iconLongArrow from "@/components/icons/iconLongArrow";
import rating from "@/components/icons/rating.vue"
export default {
  data() {
    return {
      isViewedSectionBids: false,
      bids: [],
      reviews: [
        {
          title: "Title",
          text:
            "О нашем стартапе пишут в новостном издании и рассказывают о работе сервиса на реальном примере",
          src:
            "http://online24news.ru/press-reliz/4855-servis-optovyh-zakazov-na-kotorom-mozhet-zarabotat-kazhdyy.html",
          name: "online24news.ru"
        },
        {
          title: "Title",
          text:
            "Наш технический директор рассказывает как правильно подобрать программистов. Экспертное мнение для журнала e-xecutive.ru",
          src:
            "https://www.e-xecutive.ru/career/hr-management/1991542-kak-ne-pereplatit-programmistu",
          name: "www.e-xecutive.ru"
        },
        {
          title: "Title",
          text:
            "Артём Ковалев, генеральный директор ООО «Акстек» (интернет-сервис agent.tamtem.ru), рассказал BS, каким должен быть социальный бизнес, почему для малого бизнеса важны рекомендации",
          src:
            "https://businesstory.ru/my-soedinjaem-biznes-i-obshhestvo-istorija-platformy-tamtem-ru/",
          name: "businesstory.ru"
        }
      ],
      answers: [
        {
          text:
            "Как заработать реальные деньги или обновление Агентов 2.0",
          src:
            "http://blog.tamtem.ru/news/companynews/Kak_zarabotat_realnye_dengi",
          name: "blog.tamtem.ru",
          title: "Как заработать реальные деньги?",
          picname: "howitwork"
        },
        {
          text: "Почему мы делаем закрытую регистрацию?",
          src: "http://blog.tamtem.ru/news/companynews/Pochemu_my_delaem_zakrytuyu_registraciyu",
          name: "blog.tamtem.ru",
          title: "Почему мы делаем закрытую регистрацию",
          picname: "howitwork"
        },
        {
          text:
            "Бывших работодателей не бывает, или как я заработала на Agent.tamtem.ru",
          src:
            "http://blog.tamtem.ru/news/companynews/vozmozhnosti_dlya_agentov",
          name: "blog.tamtem.ru",
          title: "Как девушка в декрете смогла заработать на сайте",
          picname: "howitwork"
        }
      ],
			isLoading: true,
    };
  },
  components: {
    iconLongArrow,
    LazyYoutubeVideo,
		rating,
    bidcard
  },
	beforeCreate() {
		
	},
  created() {
		setTimeout(()=>{
			this.isLoading = false
		}, 1500)
		this.checkSuccesRegistrationForm();
    this.checkReferrer();
    this.checkPayoutResult();
    this.checkDataFromBackend();
    if (this.isAuth == true) {
      this.loadBids();
    }
  },
  computed: {
    ...mapState("user", ["profile", "token"]),
    isAuth() {
      return (
        !!this.token && this.profile && Object.keys(this.profile).length > 0
      );
    },
    fullPath() {
      return this.$root.fullPath;
    }
  },
  watch: {
    isAuth(newVal) {
      if (newVal == true) {
        this.loadBids();
      }
    }
  },
  methods: {
		openForm(form) {
			this.$root.$emit("openForm", form)
		},
    checkPayoutResult() {
      const query = this.$route.query;      if (query.yandexpayout) {
        if (query.yandexpayout == "false") {
          this.showError(query.msg);
        } else {
          this.showSuccess(query.msg);
        }
          this.$router.replace({ name: this.$route.name });
      }
    },
    /**
     * Download actual bidsList for agent
     */
    loadBids() {
      // eslint-disable-next-line
      axios
        .get("/api/v1/hypothesis/deals")
        .then(response => {
          if (response.data.result == true) {
            this.isViewedSectionBids = true;
            this.bids = [...response.data.data];
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    videoClick() {
      this.yandexReachGoal("video_agent");
      this.googleReachGoal("video_agent");
    },
    checkDataFromBackend() {
      const routeItem = this.$route.query;

      if (Object.values(routeItem).length > 0 && this.isAuth == false) {
        routeItem.result == "false" ? this.showError(routeItem.error) : "";
        routeItem.result == "true" ? this.showSuccess(routeItem.info) : "";
        routeItem.command == "passwordresetconfirm"
          ? this.$root.$emit("openForm", "authorizationForm")
          : "";
        this.$router.replace({ name: this.$route.name });
      }
    },
    checkReferrer() {
      const query = this.$route.query;
      if (query.destination == "regagent" && this.isAuth == false) {
        const agentId = this.$route.query.agent;
        if (agentId) {
          sessionStorage.setItem("agent_id", agentId);
        }
        this.$router.replace({ name: this.$route.name });
        this.$root.$emit("openForm", "registrationForm");
      }
    },
    checkSuccesRegistrationForm() {
      const query = this.$route.query;
      if (query.registration == "true" && this.isAuth == false) {
        this.$router.replace({ name: this.$route.name });
        this.$root.$emit("openForm", "successRegistrationForm");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.loading {
	position: relative;
	&::before {
		content: '';
		z-index: 1;
		position: absolute;
		width: 100%;
		height: 100%;
		background: #f6f6f6;
		top: 0;
	}
	&::after {
		content: '';
		z-index: 1;
		position: absolute;
		width: 50px;
		height: 50px;
		top: 30vh;
		left: 50%;
		margin-left: -25px;
		border-radius: 50%;
		border: 3px solid #ececec;
		border-left: 3px solid $color-base-accent;
		animation: infiniteRotate 500ms linear infinite;
	}
}
@keyframes infiniteRotate {
	0% {transform: rotate(0deg);}
	100% {transform: rotate(360deg);}
}
.fade-enter {
	opacity: 0;
}
.fade-enter-active {
	transition: 1s;
}
.fade-leave-active {
	transition: 1s;
}
.fade-leave-to {
	opacity: 0;
}
.home {
  font-size: 14px;
  line-height: 21px;
  font-weight: 400;
  &__title {
    text-align: center;
    font-size: 26px;
    line-height: 1.5;
    font-weight: 500;
    margin-bottom: 44px;
    @media (max-width: 530px) {
      font-size: 20px;
      line-height: 30px;
    }
  }
  &__titleadd {
    text-align: left;
    font-size: 20px;
    line-height: 1.5;
    font-weight: 500;
    margin-bottom: 44px;
    padding:15px 20px 15px 25px;
    @media (max-width: 530px) {
      font-size: 20px;
      line-height: 30px;
    }
  }
}
.home-introduction {
  width: 100%;
  margin-bottom: 113px;
  &__title {
    margin-bottom: 15px;
  }
  &__cap {
    display: block;
    font-weight: 500;
    font-size: 18px;
    text-align: center;
    margin-bottom: 44px;
  }
	&__button {
		@include big-rounded-btn;
		@include btnHov($color-hover-button);
		@include w-h(250px, 50px);
		text-transform: none;
		font-size: 16px;
		font-weight: 500;
		margin: 0 auto;
		margin-top: 87px;
	}
}
.home-begin {
  margin-bottom: 50px;
  &__link {
    background: #f0f4fd;
    display: flex;
    height: 94px;
    cursor: pointer;
    text-decoration: none;
    transition: 0.3s;
    &:hover {
      opacity: 0.9;
    }
  }
  &__title {
    font-weight: 500;
    //font-size: 18px;
		text-align: center;
		font-size: 24px;
    color: #0a5f87;
    height: 100%;
    @include flex-centerizer;
    width: 65%;
		@media (max-width: 530px) {
      font-size: 18px;
    }
  }
  &__pic {
    background: #f0f4fd;
    height: 100%;
    width: 35%;
    background: url(../assets/img/mainpage/bg/video-small-thumb.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    @include flex-centerizer;
  }
  &__round {
    @include w-h(51px);
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.5);
    position: relative;
    &::before {
      position: absolute;
      content: "";
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 9px 0 9px 15.6px;
      border-color: transparent transparent transparent #fff;
      top: 50%;
      left: 50%;
      transform: translateX(-5px) translateY(-9px);
    }
  }
}
.home-answers {
  margin-bottom: 113px;
  background: #ffffff;
  @media (max-width: 1200px) {
    margin-top: 100px;
  }
  @media (max-width: 768px) {
    margin-top: 56px;
  }

  &__title {
    margin-bottom: 44px;
  }
  &__wrapper {
    overflow: hidden;
    position: relative;
  }
  &__list {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    column-gap: 15px;
    row-gap: 20px;
    transition: 750ms ease;
    position: relative;
    left: 0;
    @media (max-width: 768px) {
      grid-template-columns: 1fr;
      justify-content: center;
    }
  }
  &__box {
    padding: 5px;
  }
  &__item {
    border-radius: 10px;
    background-color: #ffffff;
    min-height: 245px;
    // padding: 33px 17px 15px;
    display: flex;
    flex-direction: column;
    height: 100%;
    color: #000;
    text-decoration: none;
  }
  &__pic {
    margin-bottom: 30px;
    height: 65px;
    display: flex;
    justify-content: flex-start;
    align-items: flex-end;
  }
  &__link {
    margin-top: auto;
    color: $color-base-accent;
    font-weight: 500;
    text-decoration: none;
    span {
      margin-right: 12px;
    }
  }
  &__cap {
    margin-bottom: 26px;
    font-size: 18px;
    line-height: 28px;
    font-weight: 500;
    a {
      color: inherit;
    }
  }
  &__text {
    margin-bottom: 32px;
    a {
      color: inherit;
    }
  }
}

.supplier-tarifs {
	margin-bottom: 113px;
	$color-cold-soft: #ecf2fe;
	background-color: $color-cold-soft;
  padding-bottom: 50px;
  background: url(/images/home/home-bg-prices.png) no-repeat;
  background-position: center;
	background-size: cover;
	&__text{
		text-align: center;
	}
  &__cap {
    color: $color-base-accent;
    text-align: center;
    b {
      font-size: 150px;
      line-height: 233px;
      font-weight: 500;
      @media (min-width: 768px) {
        font-size: 150px;
        line-height: 181px;
      }
    }
    span {
      font-size: 64px;
      font-weight: 500;
      line-height: 78px;
      @media (min-width: 768px) {
      }
    }
  }
  &__title {
    margin-bottom: 22px;
    font-weight: 600;
		text-align: center;
		line-height: 21px;
  }
  &__text {
    text-align: center;
    margin-bottom: 34px;
    padding: 0 10px;
  }
	&__note {
		font-weight: 500;
		font-size: 18px;
		text-align: center;
		margin-bottom: 20px;
	}
	&__btn {
		a {
			color: $color-base-accent;
			font-size: 18px;
			font-weight: 500;
			text-decoration: none;
			border-bottom: 2px solid currentColor;
			padding-bottom: 4px;
			&:hover {
				text-decoration: none;
				color: $color-hover-button;
				border-color: currentColor;
			}
		}
		display: flex;
		justify-content: center;
		
	}
}

.home-reviews {
  background: #ffffff;
  margin-bottom: 113px;
  // margin-bottom: 140px;
  &__title {
    margin-bottom: 44px;
  }
  &__wrapper {
    overflow: hidden;
    position: relative;
  }
  &__list {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    column-gap: 15px;
    row-gap: 20px;
    transition: 750ms ease;
    position: relative;
    left: 0;
    @media (max-width: 768px) {
      grid-template-columns: 1fr;
      justify-content: center;
    }
  }
  &__box {
    padding: 5px;
  }
  &__item {
    border-radius: 10px;
    border-top: 5px solid $color-hamster-cold;
    box-shadow: 0 2px 14px 0 rgba(69, 91, 99, 0.18);
    background-color: #ffffff;
    min-height: 245px;
    padding: 28px 17px 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
    color: #000;
    text-decoration: none;
  }
  &__cap {
    font-weight: 500;
    font-size: 18px;
    margin-bottom: 20px;
  }
  &__text {
    margin-bottom: 20px;
  }

  &__link {
    margin-top: auto;
    color: $color-base-accent;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    .link-name {
      margin-left: auto;
      color: $color-base-accent;
      font-size: 12px;
    }
  }
}

.home-feedback {
	padding: 40px 20px 50px;
	border-radius: 10px;
	background-color: #eff5fc;
	&__pic {
		text-align: center;
		margin-bottom: 20px;
	}
	&__form {
		max-width: 503px;
		width: 100%;
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		column-gap: 20px;
		row-gap: 30px;
		margin: 0 auto;
		
		textarea, input {
			background-color: #fff;
			border-radius: 4px;
			width: 100%;
			border: none;
			font-size: 12px;
			line-height: 15px;
		}
		
	}
	&__text {
		grid-column: 1 / 4;
		grid-row: 1;
		min-height: 100px;
		resize: none;
		padding: 11px 13px;
		&::placeholder {
			color: $color-text-gray;
		}
		
	}
	&__email {
		grid-column: 1 / 3;
		grid-row: 2;
		padding: 0 13px;
		height: 43px;
		@media(max-width: 425px) {
			grid-column: 1 / 4;
			grid-row: 2;
		}
	}
	&__btn {
		grid-column: 3 / 4;
		grid-row: 2;
		@include big-rounded-btn;
		@include btnHov($color-hover-button);
		height: 39px;
		text-transform: none;
		font-size: 14px;
		align-self: end;
		@media(max-width: 425px) {
			grid-row: 3;
			grid-column: 1 / 4;
		}
	}
}
.home-recent {
  margin-bottom: 102px;
  &__title {
    margin-bottom: 46px;
  }
  &__titleadd{
    margin-bottom: 46px;
  }
  &__link {
    text-decoration: none;
  }
  &__bidlist {
    display: grid;
    grid-template-columns: 1fr;
    column-gap: 10px;
    row-gap: 30px;
    margin-bottom: 50px;
    background: #f6f6f6;
    border: 1px solid $color-border-gray;
    border-top: none;
    border-bottom: none;
    li {
      // min-height: 200px;
      & /deep/ .bidcard {
        min-height: 200px;
        height: auto;
      }
    }
  }
  // &__more {
  // 	@include flex-centerizer;
  // 	min-height: 52px;
  // 	max-width: 280px;
  // 	width: 100%;
  // 	border: none;
  // 	border-radius: 35px;
  // 	background: $color-base-accent;
  // 	color: #fff;
  // 	font-size: 14px;
  // 	font-weight: 600;
  // 	margin: 0 auto;
  // 	cursor: pointer;
  // 	&:hover {
  // 		background: $color-hover-button;
  // 	}
  // }
}
.home-rating {
  margin-bottom: 44px;
  &__list {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    @media (max-width: 768px) {
      column-gap: 10px;
    }
    @media (max-width: 520px) {
      grid-template-columns: 1fr;
    }
  }
  .rating-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    &__box {
      @include flex-centerizer;
      @include w-h(143px);
      border: 6px solid #ececec;
      border-radius: 50%;
      position: relative;
      margin-top: 44px;
      @media (max-width: 768px) {
        @include w-h(120px);
        margin-top: 40px;
      }
    }
    .picture {
      @include w-h(81px);
      @include flex-centerizer;
      position: absolute;
      border-radius: 50%;
      background: #fff;
      top: -39px;
      img {
        width: 55%;
      }
      @media (max-width: 768px) {
        @include w-h(70px);
      }
    }
    .value {
      font-size: 36px;
      font-weight: 500;
      @media (max-width: 768px) {
        font-size: 24px;
      }
    }
    &__label {
      text-align: center;
      font-weight: 500;
      font-size: 14px;
      line-height: 1.5;
      margin-top: 40px;
    }
    &--links {
      .rating-item__box {
        border-color: #f6c748;
      }
      .value {
        color: #f6c748;
      }
    }
    &--companies {
      .rating-item__box {
        border-color: $color-base-accent;
      }
      .value {
        color: $color-base-accent;
      }
    }
    &--actives {
      .rating-item__box {
        border-color: #ed5448;
      }
      .value {
        color: #ed5448;
      }
    }
  }
}

.homepage-feedbacks {
  // background: url(/images/home/home-bg-1.png) no-repeat;
  // background-size: cover;
  background: #ffffff;
  padding-top: 0px;
  padding-bottom: 3px;
  @media (max-width: 768px) {
    padding-top: 90px;
  }
  &__title {
    margin-bottom: 90px;
  }
  &__towrite {
    margin-bottom: 50px;
  }
  &__list {
    list-style: none;
	line-height: 1.71;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
	padding: 50px;
    gap: 30px;
    @media (max-width: 768px) {
      grid-template-columns: 1fr;
    }
  }
}
.feedback-card {
  &__name {
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 8px;
  }
  &__stars {
    display: flex;
    list-style: none;
    margin-bottom: 23px;
  }
  &__text {
    @media (max-width: 768px) {
      font-size: 12px;
    }
    p {
      &:not(:last-child) {
        margin-bottom: 26px;
      }
    }
  }
}
</style>