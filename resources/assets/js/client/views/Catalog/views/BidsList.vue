<template lang="pug">
.bids-search
	.bids-search__intro.bids-intro
		.container
			.bids-intro__inner
				h1.bids-intro__title Биржа оптовых #[br] продаж tamtem.ru
				div.bids-intro__picture
					img(src="/images/bidlist/intro-pic.png")
		//- .container
		.bids-intro__filters
			filtersItem
	catalog-menu
	.bids-main
		.container
			.bids-main__breadcrumbs
				breadcrumbs
			h2.bids-main__title {{getBidCatState.name || "Все категории"}}
			//- выводит список заказов, если в метаданных роута установлен тип buy
			template(v-if="type == 'buy'")
				section.bids-layout.bids-layout--buy
					div.bids-layout__categories(v-if="getBidCatState.open")
						ul.aside-cat-list
							li.aside-cat-list__item(v-for='item in subCategories')
								a(
									:class="{'is-active' : item.id == getBidCatState.currSub}"
									:href="item.id"
									@click.stop.prevent="setCategory(item)"
								).aside-cat-list__link {{item.name}}
					div.bids-layout__content(:class="{'bids-layout__content--full' : !getBidCatState.open}")
						ul.bidlist-buy-list.bids-main__list(
							v-if='hasItems'
						)
							li.bidlist-buy-list__item(
								v-for='bid in bids.items'
								:class="{'bidlist-buy-list__item--full' : !getBidCatState.open}"
							)
								bidcardshortbuy(
									:bid='bid'
									:class="{viewed: findBid(bid.id)}"
									v-if="getCurrentValue.type_deal=='buy'"
								)
						.mb-5(v-else)
							form-nothing(v-if="!getLoadingState && !hasItems")
						section.bids-more(v-if='bids ? !!bids.hasMore : false')
							button(@click.prevent='loadMore()').bids-more__btn
								span(v-if='isLoadingMore') Загрузка...
								span(v-else) Показать еще

			//- выводит список объявлений, если в метаданных роута установлен тип sell
			template(v-if="type == 'sell'")
				section.bids-layout.bids-layout--sells
					div.bids-layout__categories(v-if="getBidCatState.open")
						ul.aside-cat-list
							li.aside-cat-list__item(v-for='item in subCategories')
								a(
									:class="{'is-active' : item.id == getBidCatState.currSub}"
									:href="item.id"
									@click.stop.prevent="setCategory(item)"
								).aside-cat-list__link {{item.name}}
					div.bids-layout__content
						ul.bidlist-sells-list.bids-main__list(
							v-if='hasItems'
						)
							li.bidlist-sells-list__item(
								v-for="bid in bids.items"
							)
								bid-card-short-sell(
									:bid="bid"
									:class="{viewed: findBid(bid.id)}"
								)
						.mb-5(v-else)
							form-nothing(v-if="!getLoadingState && !hasItems")
						section.bids-more(v-if='bids ? !!bids.hasMore : false')
							button(@click.prevent='loadMore()').bids-more__btn
								span(v-if='isLoadingMore') Загрузка...
								span(v-else) Показать еще
					div.bids-layout__help(v-if="!getBidCatState.open")
						h3.bids-layout__help-title Помощь
						ul.bids-layout__help-links
							li
								a(href="#") Как понять, что меня выбрали на роль поставщика?
							li
								a(href="#") Что делать, если сделка не состоялась по вине заказчика?
							li
								a(href="#") Как пополнить кошелёк и оплатить контакт?
						p.bids-layout__help-note Не нашли ответ? Напишите нам
						a(href="#").bids-layout__help-ask Задать вопрос


</template>

<script>
import { mapGetters, mapActions, mapState} from "vuex";
import filtersItem from "../../GeneralComponents/components/filtersitem";
import CatalogMenu from "../../GeneralComponents/components/CatalogMenu";
import breadcrumbs from "../../GeneralComponents/components/Breadcrumbs";
import bidcardshortbuy from "../../GeneralComponents/components/bidcardshortbuy";
import BidCardShortSell from "../../GeneralComponents/components/BidCardShortSell";
import formNothing from "../../GeneralComponents/components/formNothing";
import viewbids from "../../../mixins/viewedbids.mixin";
export default {
	mixins: [viewbids],
	components: {
		filtersItem,
		breadcrumbs,
		formNothing,
		bidcardshortbuy,
		BidCardShortSell,
		CatalogMenu,
	},
	data() {
		return {
			bids: {},
			nextPage: 2,
			isLoadingMore: false,
			type: '',
			catAsideOpen: false,
			// activeCategoryName: "Все категории",
			activeCatId: null,
			activeCatSlug: null
			// subcategories: []
		};
	},
	computed: {
		...mapState("categories", ["categoriesArray"]),
		...mapGetters(["getDefaultValue", "getCurrentValue", "getLoadingState"]),
		...mapGetters("categories", [
			"getSubCategoriesByParentId",
			"getSubCategoriesByParentSlug",
			"getCategoryById",
			"getCategoryBySlug",
			"getBidCatState"
		]),
		paramsChange: {
			get() {
				return this.$store.getters.getCurrentValue;
			}
		},
		hasItems() {
			return this.bids.items && this.bids.items.length > 0;
		},
		apiUrl() {
			return "/api/v1/filter/deals";
		},
		subCategories() {
			if(this.getBidCatState.pSlug) {
				return this.getSubCategoriesByParentSlug(this.getBidCatState.pSlug);
			}
			return this.getSubCategoriesByParentSlug(this.getBidCatState.slug || this.getCurrentValue.category);
		},
	},
	methods: {
		...mapActions(["setNewVal"]),
		...mapActions("categories", ["bidCategoryAct"]),
		// этот метод нужен, чтобы установить новое текущее состояние в хранилище
		getParamsfromRoute() {
      // console.log('Bilds List getParamsfromRoute ');
      // console.log(this.getDefaultValue);
      const currentVal = Object.assign({}, this.getDefaultValue);
      const currentParams = this.$router.currentRoute.params;
			// берет либо параметр из роута, либо стандартное значение
			currentVal.page = this.$route.query.page || 1;
			currentVal.per_page = this.$route.query.per_page || 12;
			currentVal.date_published = this.$route.query.date_published || "desc";

			// изменяем тип в объекте состояния
			if(this.type == 'sell') {
				currentVal.type_deal = "sell"
			} else (
				currentVal.type_deal = this.$route.query.type_deal || "buy"
			)
			// этот блок условий проверяет, были ли установлены какие-то новые значения в компоненте filtersitem
			if (this.$route.query.search) {
				this.$set(currentVal, "search", this.$route.query.search);
			}
      if (currentParams.parentSlug && currentParams.slug) {
        this.$set(currentVal, "category", currentParams.slug);
        this.$set(currentVal, "parentSlug", currentParams.parentSlug);
        this.$set(currentVal, "slug", currentParams.slug);
      } else if (currentParams.parentSlug && !currentParams.slug) {
        this.$set(currentVal, "category", currentParams.parentSlug);
        this.$set(currentVal, "parentSlug", currentParams.parentSlug);
      }
			if (this.$route.query.region) {
				this.$set(currentVal, "region", this.$route.query.region);
			}
			// вызывает мутацию хранилища для объекта текущего состояния
			this.setNewVal(currentVal);
		},
		loadMore() {
			const currentVal = Object.assign({}, this.getCurrentValue);
			currentVal.page++;

			this.setNewVal(currentVal);
		},
		// метод тоже вызывается в created
		getData() {
			this.$store.dispatch("setLoading", true);
			this.isLoadingMore = true;

			// компонуем полную строчку запроса, состоящую из постоянного адреса API и списка параметров, полученного геттером хранилища для объекта текущего состояния
			let url = `${this.apiUrl}?${Api.serializeQueryParams(
				this.getCurrentValue
			)}`;

			if (this.page != 1 && !this.bids.items) {
				let fakeParams = Object.assign({}, this.getCurrentValue);
				fakeParams.per_page = fakeParams.page * 12;
				fakeParams.page = 1;
				url = `${this.apiUrl}?${Api.serializeQueryParams(fakeParams)}`;
			}

			axios
				.get(url)
				.then(resp => {
				if (resp.data.data.count > 0) {
					if (this.bids.items) {
					if (this.getCurrentValue.page == 1) {
						this.$delete(this.bids, "items");
						this.bids = resp.data.data;
					} else {
						this.bids.items = this.bids.items.concat(resp.data.data.items);
						this.bids.hasMore = resp.data.data.hasMore;
					}
					} else {
					this.$delete(this.bids, "items");
					this.bids = resp.data.data;
					}
				} else {
					this.$delete(this.bids, "items");
					this.bids.hasMore = false;
				}
				})
				.catch(error => {
					this.printErrorOnConsole(error);
				})
				.then(() => {
					this.isLoadingMore = false;
					this.$store.dispatch("setLoading", false);
				});
		},
		isEmptyObject(obj) {
			return Object.getOwnPropertyNames(obj).length === 0;
		},
		setCategory(category) {
			// this.categoryString = category.name;
			this.activeCatId = category.id;
			this.activeCatClug = category.slug;
			const currentVal = Object.assign({}, this.getCurrentValue);
			let bidcatstate = {
				open: true,
				name: category.name,
				id: category.id,
				slug: category.slug,
			}
			if (category.slug) {
				this.$set(currentVal, "category", category.slug);
        if (category.parent_slug) {
          this.$set(currentVal, "parentSlug", category.parent_slug);
          this.$set(currentVal, "slug", category.slug);
        } else {
          this.$set(currentVal, "parentSlug", category.slug);
          this.$set(currentVal, "slug", null);
        }
			} else {
				this.$delete(currentVal, "category");
				this.$delete(currentVal, "parentSlug");
				this.$delete(currentVal, "slug");
			}
			this.$set(currentVal, "page", 1);
			if(category.parent_slug) {
				bidcatstate.pId = category.parent_id;
				bidcatstate.pSlug = category.parent_slug;
				bidcatstate.currSub = this.activeCatId;
				bidcatstate.currSubSlug = this.activeCatSlug;
			}
			// вызов метода, объявленного через mapActions (вызывает action хранилища)
			this.bidCategoryAct(bidcatstate);
			this.setNewVal(currentVal);
			this.changeRoute();


			let lastBidCatState = this.getBidCatState;
			if(localStorage) {
				localStorage.setItem(
					"bidCatState",
					JSON.stringify(lastBidCatState)
				);
			}
		},
		changeRoute() {
      // console.log('Bilds List change route');
      const currentVal = Object.assign({}, this.getCurrentValue);
			if (this.type == 'buy' && this.isBidsListPage) {
				this.$router.push({
					name: "bids.list",
					query: currentVal
				})
			} else if (this.type == 'sell' && this.isSellsListPage) {
				this.$router.push({
					name: "sells.list",
					query: currentVal
				})
			} else {
				return ""
			}
		}
	},
	watch: {
		$route(to, from) {
      // console.log('BidsList watch route');
      // console.log(this.getCurrentValue);
      this.type = to.meta.type;
			this.getParamsfromRoute();
			this.getData();
		},
		getCurrentValue: {
			handler(newVal) {
        //TO DO changes here
        // console.log('BidsList watch getCurrentValue handler');
        // console.log(this.getCurrentValue);
        const params = {}
        const queryParams = {}

        if (this.getCurrentValue.parentSlug) {
          params.parentSlug = this.getCurrentValue.parentSlug;
        }

        if (this.getCurrentValue.slug) {
          params.slug = this.getCurrentValue.slug;
        }

        if (this.getCurrentValue.page) {
          queryParams.page = this.getCurrentValue.page;
        }

        if (this.getCurrentValue.region) {
          queryParams.region = this.getCurrentValue.region;
        }

        if (this.getCurrentValue.search) {
          queryParams.search = this.getCurrentValue.search;
        }

        this.$router.push({
          name: this.$router.currentRoute.name,
          params: params,
          query: queryParams
        }).catch(err => {
        });
        console.log(this.getBidCatState);
        // const path = this.$router.history.current.path;
				// this.$router.push(
				// `${path}?${Api.serializeQueryParams(this.getCurrentValue)}`
				// ).catch(err => {});
			},
			deep: true
		},
    subCategories(newVal) {
    },
	},
	created() {
    const currentParams = this.$router.currentRoute.params;
    const currentVal = Object.assign({}, this.getDefaultValue);
    if (currentParams.parentSlug && currentParams.slug) {
      this.$set(currentVal, "category", currentParams.slug);
      this.$set(currentVal, "parentSlug", currentParams.parentSlug);
      this.$set(currentVal, "slug", currentParams.slug);
    } else if (currentParams.parentSlug && !currentParams.slug) {
      this.$set(currentVal, "category", currentParams.parentSlug);
      this.$set(currentVal, "parentSlug", currentParams.parentSlug);
    }
    this.setNewVal(currentVal);

    this.type = this.$route.meta.type
		this.getParamsfromRoute();

		const path = this.$router.history.current.path;

		// переход по замененному пути, с фильтром из хранищища объекта текущего состояния. Именно отсюда появляются параметры в адресной строке
		this.$router.replace(`${path}?${Api.serializeQueryParams(this.getCurrentValue)}`)
			.catch(err => {});

		this.getData();

	},
	mounted() {
		if(localStorage) {
			let lastBidCatState = JSON.parse(localStorage.getItem("bidCatState"));
			this.bidCategoryAct(lastBidCatState);
		}
	},

};
</script>

<style lang="scss" scoped>
@import "~styleguide";
@import "~mixins";

.bids-search {
	font-family: $font-family;

	&-filter {
		position: fixed;
		top: $height-header;
		left: 0;
		right: 0;
		z-index: 900;

		@include media-breakpoint-down(sm) {
			top: $height-header-sm;
			overflow: hidden;
			transition: max-height 0.2s ease;
			max-height: 0;
			background: fff;
			box-shadow: $box-shadow;
		}

		&.active {
			@include media-breakpoint-down(sm) {
				max-height: 99rem;
			}
		}
	}
}

.bids-intro {
	background: url(/images/bidlist/intro-bg.png) no-repeat;
	background-size: cover;
	//padding-top: 155px;
	margin-top: -24px;
	padding-bottom: 80px;
	@media all and (max-width: 767px) {
		margin-top: 0;
	}
	@media all and (max-width: 425px) {
		padding-top: 20px;
		padding-bottom: 70px;
	}

	&__inner {
		display: flex;
		align-items: center;
		margin-bottom: 30px;
		position: relative;
		// padding-top: 50px;
	}

	&__title {
		font-style: normal;
		font-weight: 800;
		font-size: 54px;
		line-height: 60px;
		margin-right: 88px;
		flex-shrink: 0;
		position: relative;
		@media screen and (max-width: 1100px) {
			margin-right: 60px;
		}
		@media screen and (max-width: 1024px) {
			font-size: 46px;
			line-height: 56px;
		}
		@media (max-width: 640px) {
			font-size: 22px;
			line-height: 28px;
			margin-right: 10px;
		}
		@media (max-width: 425px) {
			z-index: 2;
		}
		@media (max-width: 320px) {
			font-size: 20px;
		}
	}

	&__picture {
		width: 25%;
		// flex-shrink: 2;
		img {
			width: 100%;
			height: auto;
		}

		@media screen and (max-width: 1024px) {
			// display: none;
		}
		@media (max-width: 640px) {
			margin-left: auto;
		}
		@media (max-width: 425px) {
			width: 30%;
			position: absolute;
			right: 0;
			top: 50%;
			transform: translateY(-50%);
		}
		@media (max-width: 320px) {
			width: 25%;
		}
	}

	&__filters {
		width: 100%;
		// max-width: 1196px;
	}
}

.bids-main {
	&__breadcrumbs {
		margin-top: 22px;
		@media (max-width: 640px) {
			display: none;
		}
	}

	&__title {
		margin-top: 38px;
		font-weight: bold;
		font-size: 24px;
		line-height: 29px;
		color: #000000;
		@media (max-width: 640px) {
			display: none;
		}
	}

	&__list {
		list-style: none;
		display: flex;
		flex-wrap: wrap;
		margin: 0 -10px;
	}
}

.bids-more {
	padding-top: 80px;
	padding-bottom: 120px;

	@media(max-width: 768px) {
		padding-bottom: 100px;
		padding-top: 64px;
	}

	@media(max-width: 425px) {
		padding-top: 40px;
		padding-bottom: 90px;
	}

	&__btn {
		margin: 0 auto;
		width: 160px;
		height: 40px;
		border: none;
		border-radius: 35px;
		box-shadow: 0 2px 6px 0 rgba(69, 91, 99, 0.18);
		background-color: #ffffff;
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 14px;
		font-weight: 400;

		&:hover {
			box-shadow: none;
			border: 1px solid $color-base-accent;
		}

		@media(max-width: 425px) {
			width: 144px;
			font-size: 13px;
		}
	}
}

.bidlist-sells-list {
	&__item {
		margin: 0 10px;
		width: calc(50% - 20px);
		margin-bottom: 22px;
		@media screen and (max-width: 768px) {
			margin-bottom: 16px;
			width: calc(100% / 12 * 12 - 20px);
		}
		@media screen and (max-width: 640px) {
			width: calc(100% - 20px);
		}

		a {
			display: block;
			text-decoration: none;
			height: 100%;
		}
	}
}

.bidlist-buy-list {
	&__item {
		margin: 0 10px;
		margin-bottom: 22px;
		width: calc(100% / 12 * 6 - 20px);
		@media screen and (max-width: 768px) {
			margin-bottom: 16px;
			width: calc(100% / 12 * 12 - 20px);
		}
		@media screen and (max-width: 640px) {
			width: calc(100% - 20px);
		}

		a {
			display: block;
			text-decoration: none;
			height: 100%;
		}

		&--full {
			width: calc(100% / 12 * 4 - 20px);
			@media screen and (max-width: 768px) {
				margin-bottom: 16px;
				width: calc(100% / 12 * 6 - 20px);
			}
			@media screen and (max-width: 640px) {
				width: calc(100% - 20px);
			}
		}
	}
}

.bids-layout {
	display: flex;
	margin: 0 -15px;
	margin-top: 54px;

	&__categories {
		width: calc(100% / 12 * 3 - 30px);
		margin: 0 15px;
		@media(max-width: 768px) {
			width: calc(100% / 12 * 6 - 30px);
		}
		@media(max-width: 640px) {
			display: none;
		}
	}

	&__content {
		width: calc(100% / 12 * 9 - 30px);
		margin: 0 15px;
		@media(max-width: 768px) {
			width: calc(100% / 12 * 6 - 30px);
		}
		@media(max-width: 640px) {
			width: calc(100% - 30px);
		}
	}

	&__help {
		width: calc(100% / 12 * 3 - 30px);
		margin: 0 15px;
		@media(max-width: 640px) {
			display: none;
		}

		&-title {
			font-weight: 600;
			font-size: 22px;
			line-height: 22px;
			color: #000000;
			margin-bottom: 20px;
		}

		&-links {
			padding-bottom: 15px;
			margin-bottom: 16px;
			list-style: none;
			border-bottom: 1px solid #E6E6E6;

			li {
				&:not(:last-child) {
					margin-bottom: 3px;
				}
			}

			a {
				font-style: normal;
				font-weight: 600;
				font-size: 14px;
				line-height: 18px;
				color: #2FC06E;
			}
		}

		&-note {
			font-weight: 600;
			font-size: 14px;
			line-height: 18px;
			color: #000000;
			margin-top: 16px;
		}

		&-ask {
			display: flex;
			justify-content: center;
			margin-top: 25px;
			background: #2FC06E;
			border-radius: 5px;
			font-weight: bold;
			font-size: 14px;
			line-height: 18px;
			color: #FFFFFF;
			width: 100%;
			padding: 12px 20px;
		}
	}

	&--buy {
		.bids-layout__content--full {
			width: calc(100% - 20px);
		}
	}

	&--sells {
		.bids-layout__content {
			@media(max-width: 768px) {
				width: calc(100% / 12 * 8 - 30px);
			}
			@media(max-width: 640px) {
				width: calc(100% - 30px);
			}
		}

		.bids-layout__help {
			@media(max-width: 768px) {
				width: calc(100% / 12 * 4 - 30px);
			}
		}
	}
}

.aside-cat-list {
	list-style: none;

	&__item {
		&:not(:last-child) {
			margin-bottom: 12px;
		}
	}

	&__link {
		font-weight: 400;
		font-size: 16px;
		line-height: 20px;
		color: #888888;

		&.is-active, &:hover, &:active, &:focus {
			font-weight: 500;
			color: #000000;
			text-decoration: none;
		}
	}
}
</style>