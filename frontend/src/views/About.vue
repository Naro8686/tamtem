<template lang="pug">
	div.home
		header.header
			.container.header__container
				.header-content
					h2.header__title Больше людей -#[br] больше возможностей 
					p.header__desc
						b Получайте доход за регистрацию компаний
					//-a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").header__button Добавить компанию
				.header-pic
					img(src="../assets/img/about/header-pic.png" alt="peoples")
		section.whatis
			.container.whatis__container
				div.whatis__item.whatis__item--right
					div.whatis__pic
						img(src="../assets/img/about/whatis-1.png" alt="what-is-tamtem")
					div.whatis__content
						h2.whatis__cap Что такое сервис agent.tamtem.ru
						div.whatis__text
							p Это сервис для физических лиц, которые могут привлекать компании для работы в сервисе tamtem.ru и получать прибыль от активности данных компаний.
							p Каждый может выступить в роли агента, рекомендовать поставщиков и заказчиков друг другу и зарабатывать на этом.
						ul.whatis__list
							li
								p Сервис agent.tamtem.ru не берет деньги с пользователей, для агентов использование сервиса #[span бесплатно]
							li
								p Для каждого заказа мы предлагаем #[span список] поставщиков, которых вы сможете привлечь для выполнения сделок
				div.whatis__item.whatis__item--left
					div.whatis__pic
						img(src="../assets/img/about/whatis-2.png" alt="what-is-agenttamtem")
					div.whatis__content
						h2.whatis__cap Что такое сервис tamtem.ru
						div.whatis__text
							p Это B2B биржа оптовых заказов.
							p Мы работаем по системе краудсорсинга, а его эффективность в несколько раз превышает эффективность обычного поиска, потому что позволяет в короткие сроки охватить максимальное количество людей и компаний.
							p В нашем случае, мы гарантируем короткий цикл сделки и ее реализацию. Стоимость получения контактов для поставщика - 0,2% от средней суммы сделки, разместить заказ и оставить отклик – бесплатно.
				//-a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").whatis__button Добавить компанию прямо сейчас
		section.increasetwo
			.container.increase__container
				h1.increasetwo__cena 50₽
				h2.increasetwo__title за регистрацию каждой #[br] компании по предложенному списку
				//-a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").increasetwo__button Зарегистрироваться сейчас
				p.example__provider-txt Вывод денежных средств осуществляется с помощью Яндекс.Деньги
				div.example__provider
					div.example__provider-pic
						img(src="../assets/img/payment/yandex-money.jpg" alt="yandex-money")
					
		//-section.example
			.container.example__container
				h2.example__title Как получить дополнительный доход
				b.example__cap Пример расчета
				p.example__text Вы привлекли в свой портфель 30 компаний #[br] В течение месяца каждая из компаний оплатила по 5 000  ₽ за заказы
				p.example__summ Ваш доход = 15 000 ₽
				p.example__label С учетом статуса «Бронзовый»
				div.example__provider
					div.example__provider-pic
						img(src="../assets/img/payment/yandex-money.jpg" alt="yandex-money")
					p.example__provider-txt Вывод денежных средств осуществляется с помощью Яндекс.Деньги
		section.howto
			.container.howto__container
				h2.howto__title Как начать работать
				ul.howto__list
					li
						div.howto__pic
							img(src="../assets/img/about/step-1.png" alt="Перейдите по ссылке")
						strong.howto__cap 1. Зарегистрируйтесь
						p.howto__txt Перейдите по ссылке в нашу группу Вконтакте и найдите реферальную ссылку для регистрации
					li
						div.howto__pic
							img(src="../assets/img/about/step-2.png" alt="Выберите заказ")
						strong.howto__cap 2. Выберите заказ
						p.howto__txt Из списка поставщиков сгенерируйте ссылки. Отправьте готовую ссылку для регистрации представителю компании любым удобным способом.
					li
						div.howto__pic
							img(src="../assets/img/about/step-3.png" alt="Свяжитесь с поставщиками")
						strong.howto__cap 3. Свяжитесь с поставщиками
						p.howto__txt Как только компания зарегистрируется по вашей ссылке, она попадет в ваш Портфель компаний. Каждая сделка компании из вашего Портфеля приносит вам доход.
				//-a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").howto__button Добавить компанию
		section.increasetwo
			.container.increase__container
				h2.increasetwo__title Честная сделка
				p.increasetwo__text Найди поставщика под заказ и получи доход
				h1.increasetwo__cena 5%
				p.increasetwo__textvyplata от выплат компаниями из вашего портфеля сервису tamtem.ru 
				p *Начиная с Золотого статуса
				//-a(href="javascript:void(0);" @click="clickActionLink('registrationForm')").increasetwo__button Зарегистрироваться сейчас
		//-section.increase
			.container.increase__container
				h2.increase__title Как повысить доход
				ul.increase__answers
					li 
						p Увеличить количество компаний в Портфеле компаний
					li 
						p Повысить статус	
				ul.increase__status-list.status-list
					li.status-list__item
						div.increase-card
							p.increase-card__status.increase-card__status--bronze Бронзовый #[br] статус
							p.increase-card__scores 500 - 4 999
							p.increase-card__percent 25% 
							p.increase-card__symbol + 
							p.increase-card__time 1 год 
							p.increase-card__txt в «Портфеле компаний»
					li.status-list__item
						div.increase-card
							p.increase-card__status.increase-card__status--silver Серебряный #[br] статус
							p.increase-card__scores 5 000 - 14 999
							p.increase-card__percent 30%
							p.increase-card__symbol + 
							p.increase-card__time 1,5 года
							p.increase-card__txt в «Портфеле компаний»
					li.status-list__item
						div.increase-card
							p.increase-card__status.increase-card__status--gold Золотой #[br] статус
							p.increase-card__scores 15 000 - 49 999
							p.increase-card__percent 35% 
							p.increase-card__symbol +
							p.increase-card__time 1,5 года 
							p.increase-card__txt в «Портфеле компаний»
					li.status-list__item
						div.increase-card
							p.increase-card__status.increase-card__status--platinum Платиновый #[br] статус
							p.increase-card__scores больше 50 000
							p.increase-card__percent 40% 
							p.increase-card__symbol + 
							p.increase-card__time 2 года
							p.increase-card__txt в «Портфеле компаний»
				ul.increase__orders
						li 1 завершенный заказ = 100 баллов
						li 1 предложение по заказу = 10 баллов
		section.reviews
			.container.reviews__container
				h2.reviews__title СМИ о нас
				div.reviews__wrapper
					ul.reviews__list
						li.reviews__box(v-for="item in reviews")
							a(:href="item.src").reviews__item
								p.reviews__text {{item.text}}
								p.reviews__link
									span Читать
									i
										iconLongArrow
									span.reviews__resname {{item.name}}	
		section.homepage-feedbacks
			.container.feedbacks__container
				h2.reviews__title Что говорят о нас клиенты
				div.reviews__wrapper
						ul.homepage-feedbacks__list
							li.homepage-feedbacks__item
								.homepage-feedbacks__card.feedback-card
								p.feedback-card__name Марина Смирнова
								div.feedback-card__stars
									rating(:rate="4")
								div.feedback-card__text
									p Это просто и доступно для любого человека. Никаких вложений, а вывести деньги смог сразу же после поступления на кошелек в agent.tamtem.ru. Да, сначала получается не очень много, но сделать несколько активных компаний, а потом с них получать дополнительный доход можно легко. Проект полностью легален, это тот плюс, который я отметил для себя. 
							li.homepage-feedbacks__item
								.homepage-feedbacks__card.feedback-card
								p.feedback-card__name Елена Грищенкова
								div.feedback-card__stars
									rating(:rate="5")
								div.feedback-card__text
									p Пришлось изрядно попотеть мозгами, чтобы окончательно разобраться в сервисе. Промежуточный итог - 160 баллов начислено, зарегистрировано уже почти 20 компаний. Две из них провели оплату. Еще не выводил, коплю сумму посущественнее. Буду привлекать активных партнеров-агентов. Тема интересная. #[br]#[br] Считаю, что не зря залетел на именно на старте. Долгосроки - мое все) Чуть не забыл упомянуть техподдержку... Ох, ребятам, видимо, нелегко приходится. Это я еще такой адекватный и более-менее разобрался сам. Представляю, сколько халявщиков им пишет. Держитесь! Сам был на вашем месте. А пока работаем, товарищи)
							li.homepage-feedbacks__item
								.homepage-feedbacks__card.feedback-card
								p.feedback-card__name Елена Воронина
								div.feedback-card__stars
									rating(:rate="4")
								div.feedback-card__text
								//-#[br]#[br] 
								p Это реально выгодный сервис. На данный момент интернет перенасыщен различными биржами, сайтами, сервисами, которые обещают золотые горы, а в итоге заработать на них можно копейки. На данном сайте, по крайней мере, все честно и легально. #[br]#[br] Выплаты осуществляются стабильно. Да, с самого начала можно не ждать золотых гор, нужно немного времени вникнуть, и начать собственное развитие. #[br]#[br]  Хорошо что сервис не требует постоянного нахождения на нем, можно использовать его как второстепенный заработок, и подрабатывать примерно 2, 3, 4 часа в день при этом иметь неплохую, стабильную, и даже со временем, пассивную прибыль!
</template>
<script>
// @ is an alias to /src
import mainLogo from "@/components/logo/mainLogo.vue"
import iconLongArrow from "@/components/icons/iconLongArrow.vue"
import rating from "@/components/icons/rating.vue"
export default {
  name: "home",
  components: {
		mainLogo,
		iconLongArrow,
		rating
  },
	data() {
		return {
			reviews: [
				{
					text:
						"О нашем стартапе пишут в новостном издании и рассказывают о работе сервиса для заказчиков по поиску поставщиков",
					src:
						"https://wall.wayxar.ru/startups/kak_effektivnee_rabotat_s_poiskom_zakazchikov_i_postavshchikov",
					name: "wall.wayxar.ru"
				},
				{
					text:
						"Наш технический директор рассказывает как правильно подобрать программистов. Экспертное мнение для журнала e-xecutive.ru",
					src:
						"https://www.e-xecutive.ru/career/hr-management/1991542-kak-ne-pereplatit-programmistu",
					name: "e-xecutive.ru"
				},
				{
					text:
						"Артём Ковалев, генеральный директор ООО «Акстек» (интернет-сервис agent.tamtem.ru), рассказал BS, каким должен быть социальный бизнес, почему для малого бизнеса важны рекомендации",
					src:
						"https://businesstory.ru/my-soedinjaem-biznes-i-obshhestvo-istorija-platformy-tamtem-ru/",
					name: "businesstory.ru"
				}
			],
		}
	},
	methods: {
		clickActionLink(payload) {
			this.$emit("showForm", payload);
		}
	}
};
</script>
<style lang="scss" scoped>
// Specific mixins
@mixin green-gradient-btn {
	display: flex;
	justify-content: center;
	align-items: center;
	border-radius: 32px;
	background: $color-base-accent;
	color: $color-text-light;
	background: linear-gradient(179deg, #5fefc0, #2fc06e);
}
@mixin title {
	text-align: center;
	font-size: 26px;
	font-weight: 500;
	line-height: 32px;
}
// Specific vars
$color-gradient-light: #d6eff0;
$color-gradient-middle: #a2efdb;
$color-gradient-dark: #5fefc0;

$color-base-accent: #2fc06e;
$color-accent-pale: #28b164;
$color-accent-gold: #f9eb6d;
$color-text-light: #ffffff;
$color-text-gray: #d5d5d5;

$font-family: "Montserrat", sans-serif;
$fontsize-base: 14px;
$font-light: 300;
$font-regular: 400;
$font-medium: 500;
$font-semibold: 600;
$font-bold: 700;
// *****************************
// utils classes
.text-accent {
	color: $color-base-accent;
}
figure {
	margin: 0;
}
// Blocks classes
.home {
	font-size: 14px;
}
// HEADER
.header {
	font-weight: $font-regular;
	background: url(../assets/img/about/header-bg.png) no-repeat;
	padding-top: 80px;
	padding-bottom: 80px;
	background-size: cover;
	@media(max-width: 768px) {
		padding: 30px 0;
	}
	&__container {
		display: flex;
		align-items: center;
		height: 100%;
		
		@media(max-width: 768px) {
			flex-direction: column;
		}
	}
	&-content {
		z-index: 1;
		max-width: 50%;
		margin-right: auto;
		@media(max-width: 768px) {
			max-width: 100%;
			width: 100%;
		}
	}
	&-pic {
		padding-right: 8%;
		@media(max-width: 768px) {
			padding: 0;
			width: 50%;
			margin-top: 20px;
		}
		img {
			width: 100%;
			height: auto;
		}
	}
	&__title {
		font-size: 38px;
		font-weight: 500;
		margin-bottom: 33px;
		@media(max-width: 768px) {
			text-align: center;
		}
		@media(max-width: 425px) {
			font-size: 28px;
		}
	}
	&__desc {
		color: $color-base-accent;
		font-size: 26px;
		font-weight: 500;
		line-height: 36px;
		margin-bottom: 40px;
		b {
			font-weight: 600;
		}
		@media(max-width: 768px) {
			font-size: 18px;
			line-height: 1.5;
			text-align: center;
		}
	}
	&__button {
		@include big-rounded-btn;
		@include btnHov($color-hover-button);
		@include w-h(250px, 50px);
		text-transform: none;
		font-size: 16px;
		padding: 0;
		@media(max-width: 768px) {
			margin: 0 auto;
		}
	}
}
.whatis {
	padding-top: 75px;
	padding-bottom: 122px;
	@media(max-width: 768px) {
		padding-top: 50px;
		padding-bottom: 50px;
	}
	&__cap {
		font-size: 26px;
		font-weight: 500;
		margin-bottom: 30px;
	}
	&__item {
		display: grid;
		grid-template-columns: 1fr 1fr;
		@media(max-width: 768px) {
			grid-template-columns: 1fr;
		}
		&--right {
			grid-template-areas: "pic cont";
			margin-bottom: 97px;
			@media(max-width: 768px) {
				grid-template-areas: "cont" "pic";
				margin-bottom: 50px;
			}
			@media(max-width: 425px) {
				grid-template-areas: "cont";
			}
		}
		&--left {
			grid-template-areas: "cont pic";
			margin-bottom: 0;
			@media(max-width: 768px) {
				grid-template-areas: "cont" "pic";
			}
			@media(max-width: 425px) {
				grid-template-areas: "cont";
			} 
		}
	}
	&__pic {
		grid-area: pic;
		justify-self: center;
		align-self: center;
		padding: 0 20px;
		img {
			width: 100%;
			height: auto;
		}
		@media(max-width: 768px) {
			width: 60%;
			margin-top: 40px;
		}
		@media(max-width: 425px) {
			display: none;
		}
	}
	&__content {
		grid-area: cont;
		align-self: center;
	}
	&__text {
		margin: 0;
		p {
			font-size: 14px;
			line-height: 21px;
			&:not(:last-child) {
				margin-bottom: 22px;
			}
		}
	}
	&__list {
		margin-top: 70px;
		li:not(:last-child) {
			margin-bottom: 44px;
		}
		p {
			position: relative;
			padding-left: 50px;
			&::before {
        content: "";
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12.997' height='9.231' viewBox='0 0 12.997 9.231'%3E%3Cg id='check-square' transform='translate(1.414 1.414)'%3E%3Cpath fill='none' stroke='%2331c26e' stroke-linecap='round' stroke-linejoin='round' stroke-miterlimit='10' stroke-width='2px' d='M-1.525 3.557l3.07 3.26L5.63 2.895 8.645 0' transform='translate(1.525)'/%3E%3C/g%3E%3C/svg%3E%0A")
            no-repeat,
          #d4f5de;
        background-position: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        position: absolute;
        top: 0;
        left: 0;
      }
		}
	}
	&__button {
		@include big-rounded-btn;
		@include btnHov($color-hover-button);
		@include w-h(370px, 50px);
		text-transform: none;
		font-size: 16px;
		padding: 0;
		margin: 0 auto;
		margin-top: 70px;
		text-align: center;
		@media(max-width: 425px) {
			font-size: 14px;
			width: 100%;
			height: auto;
			min-height: 50px;
			max-width: 370px;
			padding: 0 15px;
		}
	}
}
// EXAMPLE - 3
.example {
	background: url(../assets/img/about/increase-bg.png) no-repeat;
	background-position: center;
	background-size: cover;
	color: #000000;
	padding-top: 70px;
	padding-bottom: 70px;
	@media(max-width: 768px) {
		padding-top: 50px;
		padding-bottom: 50px;
	}
	
	&__container {
		display: flex;
		flex-direction: column;
		align-items: center;
	}
	&__title {
		@include title;
		margin-bottom: 35px;
	}
	&__cap {
		margin-bottom: 23px;
		color: $color-base-accent;
		font-weight: 500;
		font-size: 18px;
	}
	&__text {
		font-size: 14px;
		line-height: 21px;
		margin-bottom: 22px;
		text-align: center;
		&--conclusion {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			line-height: 30px;
		}
		@media(max-width: 1200px) {
			font-size: 16px;
		}
		@media(max-width: 768px) {
			font-size: 14px;
			line-height: 24px;
		}
	}
	&__summ {
		@include flex-centerizer;
		@include w-h(304px, 57px);
		border: 2px solid $color-base-accent;
		border-radius: 6px;
		font-weight: 500;
		font-size: 17px;
	}
	&__label {
		font-size: 14px;
		line-height: 27px;
		margin-top: 12px;
		margin-bottom: 20px;
	}
	&__provider {
		display: flex;
		flex-direction: column;
		align-items: center;
		&-txt {
			font-size: 14px;
			margin-top: 12px;
		}
	}
}

.howto {
	padding-top: 130px;
	padding-bottom: 146px;
	@media(max-width: 768px) {
		padding-top: 50px;
		padding-bottom: 50px;
	}
	&__title {
		@include title;
		margin-bottom: 70px;
		@media(max-width: 600px) {
			margin-bottom: 50px;
		}
		@media(max-width: 530px) {
			margin-bottom: 24px;
		}
	}
	&__list {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		gap: 40px;
		margin-bottom: 64px;
		@media(max-width: 768px) {
			grid-template-columns: 1fr;
			margin-bottom: 52px;
		}
		@media(max-width: 425px) {
			grid-template-columns: 1fr;
			margin-bottom: 50px;
		}
		li {
			list-style: none;
		}
	}
	&__pic {
		height: 230px;
		img {
			width: 100%;
			height: 100%;
			object-fit: contain;
		}
	}
	&__cap {
		display: block;
		text-align: center;
		font-weight: 500;
		font-size: 18px;
		margin-top: 38px;
		@media(max-width: 768px) {
			font-size: 16px;
		}
		@media(max-width: 600px) {
			margin-top: 20px;
		}
	}
	&__txt {
		text-align: center;
		margin-top: 35px;
		line-height: 1.5;
		@media(max-width: 768px) {
			padding: 0 10%;
		}
		@media(max-width: 600px) {
			margin-bottom: 20px;
		}
		a {
			color: $color-base-accent;
			text-decoration: none;
		}
		span {
			color: $color-base-accent;
		}
	}
	&__button {
		@include big-rounded-btn;
    @include btnHov($color-hover-button);
    max-width: 220px;
		min-height: 50px;
    text-transform: none;
    margin: 0 auto;
    font-size: 16px;
    font-weight: 600;
    padding: 0 20px;
		color: #ffffff;
    @media (max-width: 768px) {
      font-size: 14px;
			min-height: 40px;
    }
	}
}

.increasetwo{
	background: url(../assets/img/about/header-bg.png) no-repeat;
	background-size: cover;
	padding-top: 82px;
	padding-bottom: 43px;
	text-align: center;
	@media(max-width: 1200px) {
		padding: 70px 0;
	}
	@media(max-width: 768px) {
		padding-top: 50px;
		padding-bottom: 50px;
	}
	&__title {
		@include title;
		margin-bottom: 40px;
	}
	&__text{
	text-align: center;
    line-height: 21px;
    margin-bottom: 34px;
    padding: 0 10px;
	}
	&__cena {
		margin-bottom: 40px;
		font-size: 140px;
		line-height: 181px;
		color:#2fc06e;
		@media(max-width: 335px) {
		font-size: 140px;
		line-height: 172px;
	}

	}
	&__textvyplata{	
	font-weight: 500;
	font-size: 17px;
	line-height: 27px;
	padding-bottom: 10px;
	}
	&__button{
		color:	#2fc06e;
		font-size: 18px;
		font-weight: 500;
		text-decoration: none;
		border-bottom: 2px solid currentColor;
		padding-bottom: 4px;
	}
}

// INCREASE
.increase {
	background: url(../assets/img/about/header-bg.png) no-repeat;
	background-size: cover;
	padding-top: 82px;
	padding-bottom: 43px;
	@media(max-width: 1200px) {
		padding: 70px 0;
	}
	@media(max-width: 768px) {
		padding-top: 50px;
		padding-bottom: 50px;
	}
	&__title {
		@include title;
		margin-bottom: 40px;
	}
	&__answers {
		grid-area: answers;
		margin: 0 auto;
		margin-bottom: 60px;
		display: flex;
		width: 60%;
		@media(max-width: 1000px) {
			width: 90%;
		}
		@media(max-width: 768px) {
			width: 100%;
		}
		@media(max-width: 560px) {
			flex-direction: column;
			
		}
		li {
			width: 50%;
			display: flex;
			align-items: center;
			justify-content: flex-end;
			@media(max-width: 560px) {
				width: 100%;
				justify-content: flex-start;
				margin-bottom: 20px;
			}
			p {
				font-weight: $font-medium;
				font-size: 17px;
				line-height: 27px;
				position: relative;
				padding-left: 55px;
				&::before {
					content: "";
					background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='14' viewBox='0 0 12.997 9.231'%3E%3Cg id='check-square' transform='translate(1.414 1.414)'%3E%3Cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-miterlimit='10' stroke-width='2px' d='M-1.525 3.557l3.07 3.26L5.63 2.895 8.645 0' transform='translate(1.525)'/%3E%3C/g%3E%3C/svg%3E%0A") no-repeat, $color-base-accent;
					background-position: center;
					width: 37px;
					height: 37px;
					border-radius: 50%;
					position: absolute;
					top: 50%;
					transform: translateY(-50%);
					left: 0;
				}
			}
			
		}
	}
	&__orders {
		@media(max-width: 768px) {
			justify-self: center;
		}
		li {
			font-weight: $font-medium;
			font-size: 17px;
			padding: 0 30px;
			text-align: center;
			&:not(:last-child) {
				margin-bottom: 20px;
			}
		}
	}
	&__status-list {
		order: 1;
		margin: 0 auto;
		width: 100%;
		display: grid;
		grid-template-columns: 1fr 1fr 1fr 1fr;
		grid-template-rows: auto;
		gap: 30px;
		margin-bottom: 50px;
		
		@media(max-width: 768px) {
			width: 100%;
			grid-template-columns: 1fr 1fr;
			grid-template-rows: auto auto;
		}
		@media(max-width: 425px) {
			grid-template-columns: 1fr;
		}
	}
}
.status-list {
	&__item {
		justify-self: center;
	}
}
.increase-card {
	z-index: 2;
	position: relative;
	font-weight: $font-medium;
	background-color: #fff;
	border-radius: 10px;
	padding: 0 24px;
	padding-bottom: 26px;
	max-width: 226px;
	box-shadow: 0 5px 15px 0 rgba(69, 91, 99, 0.18);
	@media(max-width: 992px) {
		padding: 0 14px 20px;
	}
	&__status {
		color: #000000;
		font-weight: $font-medium;
		font-size: 17px;
		line-height: 27px;
		text-align: center;
		padding-top: 15px;
		padding-bottom: 15px;
		margin-bottom: 20px;
		background-color: $color-base-accent;
		border-bottom-left-radius: 30px;
		border-bottom-right-radius: 30px;
		&--bronze {
			background-color: #d1b3a0;
		}
		&--silver {
			background-color: #dedede;
		}
		&--gold {
			background-color: #ffd6ae;
		}
		&--platinum {
			background-color: #f8f1e9;
		}
	}
	&__txt {
		font-size: 14px;
		line-height: 21px;
		font-weight: $font-regular;
		text-align: center;
		margin-bottom: 10px;
	}
	&__scores {
		@include green-gradient-btn;
		background: linear-gradient(179deg, #5fefc0 -52%, #2fc06e 64%);
		height: 45px;
		font-size: 17px;
		font-weight: $font-medium;
		text-align: center;
		position: relative;
		padding-bottom: 7px;
		margin-bottom: 25px;
		&::after {
			content: 'баллов';
			font-size: 10px;
			font: $font-medium;
			position: absolute;
			bottom: 3px;
			width: 40px;
			text-align: center;
			left: calc(50% - 20px);
		}
		@media(max-width: 992px) {
			font-size: 14px;
			padding: 10px 0 14px;
			&::after {
				bottom: 5px;
			}
		}
	}
	&__percent {
		text-align: center;
		font-size: 32px;
		@media(max-width: 992px) {
			font-size: 16px;
			font-weight: $font-medium;

		}
	}
	&__symbol {
		text-align: center;
		font-size: 14px;
		margin: 8px 0;
	}
	&__time {
		text-align: center;
		font-size: 32px;
		margin-bottom: 15px;
		@media(max-width: 992px) {
			font-size: 16px;
			font-weight: $font-medium;
		}
	}
}

.reviews {
  background: #ffffff;
  padding-top: 130px;
	padding-bottom: 170px;
  @media(max-width: 768px) {
		padding-top: 50px;
		padding-bottom: 50px;
	}
  &__title {
		@include title;
    margin-bottom: 50px;
  }
  &__wrapper {
    overflow: hidden;
    position: relative;
  }
  &__list {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 30px;
    transition: 750ms ease;
    position: relative;
    left: 0;
    @media (max-width: 1020px) {
      grid-template-columns: 1fr;
    }
  }
  &__box {
    padding: 5px;
  }
  &__item {
    border-radius: 10px;
    border: 1px solid $color-border-gray;
    background-color: #ffffff;
    min-height: 245px;
    padding: 42px 36px;
    display: flex;
    flex-direction: column;
    height: 100%;
    color: #000;
    text-decoration: none;
    transition: 0.2s;
    &:hover {
      box-shadow: 0px 0px 14px 0 rgba(69, 91, 99, 0.2);
      .reviews__link i {
        transform: translateX(15px);
      }
    }
  }
  &__text {
    margin-bottom: 20px;
	line-height: 1.71;
  }
  &__link {
    margin-top: auto;
    color: $color-base-accent;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    span {
      margin-right: 12px;
    }
    i {
      display: inline-block;
      transition: 0.4s;
    }
  }
  &__resname {
    color: $color-hamster-cold;
    margin-left: auto;
    font-weight: 400;
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


