<template lang="pug">
	//- Этот компонент не используется, позже его нужно удалить.
	section.faq
		section.blade-questions
			.container
				h2.blade-questions__title С чего начать?
				section.answers
					h3.answers__title Общие понятия
					ul.answers__list
						li.answers__item.answer
							div.answer__head 
								p.answer__name Что такое сервис tamtem.ru?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Tamtem - это удобный сервис для поставщиков и закупщиков товаров оптом, который работает по системе краудсорсинга.
						li.answers__item.answer
							div.answer__head
								p.answer__name Что такое краудсорсинг?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Краудсо́рсинг — мобилизация ресурсов людей посредством информационных технологий.
						li.answers__item.answer
							div.answer__head 
								p.answer__name Почему краудсорсинг, и чем он поможет мне?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Компании, работающие по принципу краудсорсинга, решают задачи с помощью энергии большого количества людей, но при этом дают большому количеству людей возможность заработать и проявить себя.
								p Каждый человек может выступить в роли Агента, рекомендовать поставщиков и заказчиков друг другу и зарабатывать на этом.
						li.answers__item.answer
							div.answer__head 
								p.answer__name Что такое сервис agent.tamtem.ru?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p #[a(href="http://agent.tamtem.ru/") http://agent.tamtem.ru/] - это сервис для физических лиц, которые могут привлекать компании для работы в сервисе tamtem.ru и получать прибыль от активности данных компаний.
								p Важно! Сервис #[a(href="http://agent.tamtem.ru/") http://agent.tamtem.ru/] не берет деньги с пользователей, для агентов использование сервиса бесплатно. 
								p
									a(href="/files/agreement.pdf") Пользовательское соглашение
								p
									a(href="/files/politic.pdf") Политика конфиденциальности
				section.answers
					h3.answers__title Как начать работать?
					ul.answers__list
						li.answers__item.answer
							div.answer__head
								p.answer__name Как зарегистрироваться на agent.tamtem.ru?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								ul
									li Перейдите по ссылке #[a(href="http://agent.tamtem.ru/") http://agent.tamtem.ru/] на сайт и в правом верхнем углу нажмите на «Войти | Регистрация».
									li Открывается окно авторизации. Если у вас уже есть учетная запись на #[a(href="https://tamtem.ru/") https://tamtem.ru/], выполните вход.
									li Если у вас нет учетной записи на #[a(href="") https://tamtem.ru/] или #[a(href="http://agent.tamtem.ru/") http://agent.tamtem.ru/], нажимите кнопку “Регистрация” и проходите процедуру регистрации нового пользователя, заполнив  соответствующие поля (ФИО, e-mail, телефон).
									li Теперь проверьте почту и, перейдя по ссылке в письме, подтвердите свою регистрацию на #[a(href="http://agent.tamtem.ru/") http://agent.tamtem.ru/]  и начните работу с сервисом.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как найти компанию?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Вы находите еще не зарегистрированные на tamtem.ru компании, которым будет интересно размещение или получение заказов. Проверить компанию вы можете по ИНН.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как зарегистрировать компанию?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Чтобы зарегистрировать компанию и добавить ее в свой портфель, в Личном кабинете перейдите на вкладку “Портфель компаний”. В поле “ИНН” введите ИНН компании, которую хотите зарегистрировать.
								p Если данная компания еще не зарегистрирована, то начнется процесс создания ссылки.
								p Если такая компания уже есть на сервисе, то система не даст создать ссылку на регистрацию.
								p Важно! Ссылки для каждой компании уникальны, так как содержат заполненное поле ИНН. 
						li.answers__item.answer
							div.answer__head
								p.answer__name Как отправить ссылку на конкретный заказ?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Если вы хотите отправить компании интересующий ее заказ, то при регистрации компании и создании ссылки в поле “Заказ” вставляем ссылку на заказ с сайта #[a(href="https://tamtem.ru/") https://tamtem.ru/].  Получив ссылку, представитель компании сразу попадет на конкретный заказ.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как происходит регистрация компании?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Когда вы отправляете реферальную ссылку представителю компании, после перехода по ней компания попадает на сайт #[a(href="https://tamtem.ru/") https://tamtem.ru/]  в окно регистрации с заполненным полем ИНН. Если в ссылке содержался заказ, то компания после регистрации попадет сразу на страницу заказа.
								p Дальше представитель компании подтверждает и регистрирует её в соответствии с установленными сервисом правилами.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как узнать, что компания зарегистрировалась?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Как только представитель компании регистрируется по реферальной ссылке, компания попадает  в ваш “Портфель компаний”.
								p Срок действия ссылки 72 часа, если в течение этого срока компания не зарегистрировалась, то ссылку нужно будет создать заново.
						li.answers__item.answer
							div.answer__head 
								p.answer__name Как узнать количество компаний в вашем «Портфеле компаний»?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p В Личном кабинете во вкладке “Портфель компаний” есть таблица всех зарегистрированных вами компаний.
								p Там же вам будет доступна вся информация по активности каждой из компаний:
								ul
									li общее количество заказов и предложений;
									li количество успешных сделок, в которых компания была выбрана в роли Поставщика;
									li отчисления с активности компании. 
						li.answers__item.answer
							div.answer__head
								p.answer__name Как происходит начисление средств?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p С каждой оплаты на сервисе #[a(href="https://tamtem.ru/") https://tamtem.ru/] , зарегистрированной в вашем “Портфеле компаний” вам будет начислено от 8 до 20 % в зависимости от вашего статуса. 
								p 
									i Пример: компанию выбрали на роль поставщика, и она оплатила 5000 рублей за контакт.Если у вас Бронзовый статус (10% отчислений и 1 год содержания в “Портфеле компании”) вам будет начислено 500 рублей. 

						li.answers__item.answer
							div.answer__head
								p.answer__name Как вывести деньги?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p В Личном кабинете во вкладке Баланс найдите пункт “Вывод средств”
								p В открывшемся окне выберете способ начисления (карта или электронный кошелек) и заполните все необходимые поля. Введите сумму, которая не может превышать сумму на вашем кошельке на сервисе #[a(href="http://agent.tamtem.ru/") http://agent.tamtem.ru/] . Нажмите кнопку “Перевести” и перейдите на страницу платежной системы. Средства поступят на ваш счет в течение 3 суток.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как зарабатывать с помощью agent.tamtem.ru больше?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Увеличить доход можно двумя способами.
								ol
									li Привлекайте больше компании, которые выступают в роли Поставщика. Больше компаний-поставщиков - больше средств, которые вы будете получать за их активность на сервисе.
									li Повышайте свой статус, участвуя в Программе статусов. За действия компаний из вашего Портфеля компаний вы будете получать баллы статуса. Также баллы статуса начисляются за привлечение новых пользователей на agent.tamtem.ru

						li.answers__item.answer
							div.answer__head
								p.answer__name Что такое Программа статусов, и как повысить свой статус?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p На данный момент в системе действует 5 статусов:
								ul
									li “Базовый” (0-500 баллов) - 8%, 1 год в “Портфеле компаний”;
									li Бронзовый (500-4999 баллов)  - 10%, 1 год в “Портфеле компаний”;
									li Серебряный (5000-14999 баллов) - 10%, 1.5 года в “Портфеле компаний”;
									li Золотой (15000-49999 баллов) - 15%, 1.5 года в “Портфеле компаний”;
									li Платиновый (больше 50000 баллов) - 20%, 2 года в “Портфеле компаний”.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как начисляются баллы?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Баллы начисляются за определенные действия компаний, находящихся в вашем “Портфеле компаний” и за привлечение новых пользователей:
								ul
									li Выбор Заказчиком Победителя в заказе - 100 баллов;
									li Создание Поставщиком предложения по заказу - 10 баллов.
									li Приглашение новых пользователей - 30 баллов.
						li.answers__item.answer
							div.answer__head
								p.answer__name Как узнать свой статус?
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Узнать свой статус можно в Личном кабинете в разделе “Статус”.

						li.answers__item.answer
							div.answer__head
								p.answer__name Хочу быть профи!
								span.answer__icon
									i.answer__icon-closed
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									i.answer__icon-opened
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							div.answer__text
								p Это рубрика статей для пользователей, которые привлекают компании. Здесь мы делимся полезной информацией, примерами работ с возражением  и обсуждаем кейсы. Читайте, комментируйте, добавляйте свои полезные материалы и кейсы! В нашем #[a(href="http://blog.tamtem.ru/") блоге] хочу стать профи.
				section.answers-helpcard
					div.answers-helpcard__pic
						img(src="../assets/img/faq/answ-help.jpg")
					div.answers-helpcard__content.help-info
						h4.help-info__title Что делать,#[br] если нужна помощь?
						div.help-info__instructions
							p.help-info__text Вы можете связаться со службой поддержки сервиса agent.tamtem.ru по телефону 8 499 929-00-43
							p.help-info__text Изучить информацию в нашем блоге
						ul.help-info__pills
							li.help-info__pill.help-info__phone
								a(href="tel:+74999290043") 8 499 929-00-43
							//- li.help-info__pill.help-info__chat
							//- 	a(href="javascript:void(0);") чат
							li.help-info__pill.help-info__blog
								a(href="http://blog.tamtem.ru/") блог
						div.help-info__cap
							p.help-info__text.help-info__text--center Мы всегда поможем вам!
						ul.help-info__politics
							//- li
							//- 	a(href="javascript:void(0);") Правила пользования сервисом
							li
								a(href="/files/agreement.pdf") Пользовательское соглашение
							li
								a(href="/files/politic.pdf") Политика конфиденциальности
				section.advices
					h3.advices__title Полезные советы
					ul.advices__list
						li.advices__item
							a(href="http://blog.tamtem.ru/news/companynews/vozmozhnosti_dlya_agentov" target="_blank").advices__item-link
								p.advices__item-pic
									img(src="../assets/img/faq/1-1.png")
								p.advices__item-text
									| Больше людей-больше возможностей
						li.advices__item
							a(href="http://blog.tamtem.ru/news/companynews/oplata_agentam" target="_blank").advices__item-link
								p.advices__item-pic
									img(src="../assets/img/faq/2-1.png")
								p.advices__item-text
									| Почему мы готовы платить агентам?
						li.advices__item
							a(href="http://blog.tamtem.ru/news/companynews/kak-agenty-nachat-rabotat" target="_blank").advices__item-link
								p.advices__item-pic
									img(src="../assets/img/faq/3-1.png")
								p.advices__item-text
									| Как агенту начать работать с tamtem.ru
</template>
<script>
export default {
	data() {
		return {
	
		}
	},
	methods: {
		getAllItems() {
			let items = document.querySelectorAll('.answer__head');
			let currentItem = '';
			this.items = items;
			for(let i=0;i<items.length;i++) {
				items[i].addEventListener("click", function(){
					toggleAnswer(items[i].parentNode);
				})
			}
			function toggleAnswer(el) {
				if(currentItem && currentItem !== el) {
					currentItem.classList.remove('opened')
					currentItem = el
				}
				el.classList.toggle('opened');
				currentItem = el
			}
		},
	},
	mounted() {
		this.getAllItems()
	}
}
</script>
<style lang="scss" scoped>
.faq {
	height: 100%;
}
.blade-questions {
	&__title {
		font-size: 45px;
		font-weight: 600;
		margin: 80px 0;
		@media(max-width: 425px) {
			font-size: 30px;
			margin: 45px 0;
		}
	}
	.answers {
		@include contentbox;
		margin-bottom: 74px;
		padding: 0px;
		&__title {
			font-size: 26px;
			font-weight: 500;
			color: $color-base-accent;
			margin: 60px 60px 60px 60px;
			@media(max-width: 768px) {
				margin: 41px 31px;
			}
			@media(max-width: 425px) {
				font-size: 20px;
				margin: 36px 17px;
			}
		}
		&__item {
			cursor: pointer;
		}
	}
	.answer {
		a {
			color: #000;
			text-decoration: underline;
		}
		&__head {
			padding: 0 60px;
			display: flex;
			// justify-content: space-between;
			position: relative;
			@media(max-width: 768px) {
				padding: 0 31px;
			}
			@media(max-width: 425px) {
				padding: 0 17px;
			}
		}
		&__name {
			font-size: 18px;
			line-height: 32px;
			font-weight: 500;
			padding: 45px 0;
			width: 100%;
			border-top: 1px solid $color-border-gray;
			padding-right: 25px;
			@media(max-width: 768px) {
				font-size: 17px;
				padding: 32px 0;
				padding-right: 25px;
			}
			@media(max-width: 425px) {
				font-size: 15px;
				padding: 28px 0;
				padding-right: 25px;
			}
		}
		&__icon {
			position: absolute;
			width: 24px;
			height: 24px;
			display: flex;
			right: 60px;
			top: calc(50% - 12px);
			@media(max-width: 768px) {
				right: 31px;
			}
			@media(max-width: 425px) {
				right: 17px;
			}
			svg {
				stroke: $color-base-accent;
				stroke-width: 3px;
				@media(max-width: 425px) {
					stroke-width: 2px;
				}
			}
			&-closed {
				
			}
			&-opened {
				display: none;
			}
		}
		&__text {
			color: #fff;
			background-color: $color-base-accent;
			font-size: 18px;
			line-height: 28px;
			@media(max-width: 768px) {
				font-size: 17px;
			}
			@media(max-width: 425px) {
				font-size: 15px;
			}
			a {
				color: #fff;
				text-decoration: underline;
			}
			p, ul, ol {
				width: 60%;
				@media(max-width: 768px) {
					width: 90%;
				}
				@media(max-width: 425px) {
					width: 100%;
				}
			}
			p:not(:last-child) {
				margin-bottom: 15px;
			}
			ul {
				list-style-type: disc;
				margin-bottom: 15px;
				margin-left: 20px;
			}
			ol {
				margin-bottom: 15px;
				margin-left: 20px;
			}
			// unactive
			height: 0;
			overflow: hidden;
			padding: 0;
			transition: 0.3s;
		}
		&.opened {
			a {
				color: #fff;
			}
			.answer__head {
				background: $color-base-accent;
				color: #fff;
			}
			.answer__name {
				border: none;
			}
			.answer__icon-closed {
				display: none;
			}
			.answer__icon-opened {
				display: block;
				svg {
					stroke: #fff;
				}
			}
			.answer__text {
				height: auto;
				padding: 45px 60px;
				@media(max-width: 768px) {
					padding: 34px 31px;
				}
				@media(max-width: 425px) {
					padding: 32px 17px;
				}
			}
		}
		
	}
	.answers-helpcard {
		display: flex;
		margin-bottom: 75px;
		align-items: stretch;
		max-height: 671px;
		border-radius: 10px;
		overflow: hidden;
		@media(max-width: 930px) {
			max-height: 700px;
		}
		&__pic {
			width: 65%;
			overflow: hidden;
			img {
				width: auto;
				height: 100%;
			}
			@media(max-width: 1110px) {
				width: 60%;
				img {
					transform: translateX(-3%);
				}
			}
			@media(max-width: 850px) {
				display: none;
			}
		}
		&__content {
			width: 35%;
			background-color: $color-base-accent;
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
			@media(max-width: 1110px) {
				width: 40%;
			}
			@media(max-width: 850px) {
				width: 100%;
			}
		}
		.help-info {
			color: #fff;
			padding: 4% 1.2% 2%;
			@media(max-width: 768px) {
				padding: 4% 31px 2%;
			}
			@media(max-width: 425px) {
				padding: 4% 17px 2%;
			}
			&__title {
				font-size: 26px;
				line-height: 38px;
				font-weight: 500;
				text-align: center;
				margin-bottom: 40px;
				margin-bottom: 6%;
				@media(max-width: 850px) {
					margin-bottom: 4%;
				}
			}
			&__text {
				font-size: 18px;
				line-height: 32px;
				margin-bottom: 15px;
				@media(max-width: 850px) {
					text-align: center;
					margin-bottom: 5px;
				}
				@media(max-width: 768px) {
					font-size: 16px;
				}
				@media(max-width: 425px) {
					font-size: 14px;
				}
				&--center {
					text-align: center;
				}
			}
			&__cap {
				margin-top: 14%;
				@media(max-width: 850px) {
					margin-top: 3%;
				}
			}
			&__pills {
				display: flex;
				// justify-content: space-between;
				// justify-content: flex-start;
				justify-content: center;
				margin-top: 20px;
				flex-wrap: wrap;
				margin-top: 5%;

				@media(max-width: 1110px) {
					a {
						font-size: 14px;
						min-width: 75px;
						padding: 13px 10px;
					}
				}
				@media(max-width: 850px) {
					justify-content: center;
					margin-top: 2%;
					li:not(:last-child) {
						margin-right: 10px;
					}
				}
				li {
					flex-shrink: 0;
					margin: 3px 0;
				}
				li:not(:last-child) {
					margin-right: 10px;
				}
				a {
					min-width: 84px;
					padding: 13px;
					display: flex;
					justify-content: center;
					align-items: center;
					background-color: #fff;
					color: $color-base-accent;
					text-decoration: none;
					font-size: 18px;
					border-radius: 35px;
				}
			}
			&__politics {
				margin-top: auto;
				a {
					color: #fff;
					font-size: 12px;
					font-weight: 500;
					line-height: 24px;
				}
				@media(max-width: 850px) {
					display: flex;
					justify-content: center;
					li {
						margin: 3px 0;
					}
					li:not(:last-child) {
						margin-right: 10px;
					}
				}
				@media(max-width: 425px) {
					flex-direction: column;
					align-items: center;
					li {
						margin: 5px 0;
					}
					li:not(:last-child) {
						margin-right: 0px;
					}
				}
			}
		}
	}
	.advices {
		@include contentbox;
		margin-bottom: 300px;
		padding: 60px;
		@media(max-width: 768px) {
			padding: 40px 31px;
		}
		@media(max-width: 425px) {
			padding: 40px 17px;
		}
		&__title {
			font-size: 26px;
			font-weight: 500;
			color: $color-base-accent;
			margin-bottom: 50px;
		}
		&__list {
			@include row-flex;
		}
		&__item {
			@include col();
			@include size(4);
			background: #fff;
			overflow: hidden;
			@media(max-width: 850px) {
				@include size(6);
				margin-bottom: 25px;
			}
			@media(max-width: 500px) {
				@include size(12);
			}
			&-link {
				border-radius: 6px;
				overflow: hidden;
				height: 100%;
				display: flex;
				flex-direction: column;
				text-decoration: none;
			}
			&-pic {
				display: flex;
				img {
					width: 100%;
					height: auto;
					@media(max-width: 500px) {
						object-fit: contain;
					}
				}
			}
			&-text {
				background: #fff;
				padding: 11px;
				color: #000;
				border: 1px solid #ececec;
				border-top: none;
				border-bottom-left-radius: 6px;
				border-bottom-right-radius: 6px;
				font-size: 18px;
				line-height: 24px;
				// height: 100%;
				@media(max-width: 768px) {
					font-size: 16px;
				}
				@media(max-width: 425px) {
					font-size: 14px;
				}
			}
		}
	}
}

</style>