<template lang="pug">
section.dtbid(v-if="bidData")
	message(v-if="showMessage" text='Вставьте ссылку в эл. письмо для поставщика, не забудьте указать свое имя и отправьте эл. почту поставщику' @close="showMessage=false")
	header.dtbid-header
		.container.dtbid-header__container
			.dtbid-header__goback
				goback
			.dtbid-header__info
				.dtbid-header__title
					h1 Заказ:&nbsp; #[br] {{bidData.name}}
				.dtbid-header__budget
					| {{bidData.budget_from|priceFormat}} - {{bidData.budget_to|priceFormat}} &nbsp;₽
				.dtbid-header__period
					| Период закупки: {{bidData.date_of_event}}
	div.dtbid-body
		//- этот для планшетов и меньше, вместо боковой колонки
		.dtbid-body__outerblock(v-if="activeCompany")
			.container.dtbid-vendors
				div.dtbid-vendors__controls
					ul
						li(v-for="item,i in organizationsList")
							button(@click="activeCompanyId=item.id" :class="{'active' : activeCompanyId==item.id}") Поставщик №{{i+1}}
				div.dtbid-aside__footer(v-if="paginationData.total>0")
						ul.pagination-list
							li.pagination__item(v-for="n in 5")
								button(@click="setNewPage(startPage+n-1)" :disabled="startPage+n-1>paginationData.lastPage" :class="{'disabled' : startPage+n-1>paginationData.lastPage,'active': startPage+n-1==paginationData.current_page}") {{startPage+n-1}}
						ul.pagination-controls
							li.pagination-controls__prev
								button(@click="setNewPage(paginationData.current_page-1)" :disabled="!paginationData.has_prev" :class="{'disabled': paginationData.has_prev==false, 'active' : paginationData.has_prev}")
									feather-chevron-left
							li.pagination-controls__next
								button(@click="setNewPage(paginationData.current_page+1)" :disabled="paginationData.has_next==false" :class="{'disabled': paginationData.has_next==false, 'active' : paginationData.has_next}")
									feather-chevron-right
				div.dtbid-vendors__card.vendor-card
					div.vendor-card__info
						p {{activeCompany.name}}
						p 
							b ИНН: {{activeCompany.inn}}
						p(v-for="phone in phonesSplitter(activeCompany.phone)") {{phone}} 
						a.vendor-card__info--sitelink(:href="activeCompany.site" v-if="activeCompany.site") Официальный сайт компании
						p {{activeCompany.address_legal}}
					
					div.vendor-card__linkbox
						//-span Ссылка для регистрации компании
						div.vendor-card__createlink
							//-input(:value="activeCompany.link" readonly)
							button(@click="createReferalLinkForCompany(activeCompany.link,activeCompany.inn,activeCompany.name,activeCompany.okved,activeCompany.index)") {{activeCompany.link ? 'Копировать реф.ссылку' : 'Создать реф.ссылку'}}
							
		.dtbid-body__mainblock
			.container.dtbid-body__container
				div.dtbid-content
					ul.dtbid-content__list
						li.dtbid-condition
							b.dtbid-condition__key Спецификация
							p.dtbid-condition__value {{bidData.dqh_specification}}
						li.dtbid-condition
							b.dtbid-condition__key Тип сделки
							p.dtbid-condition__value {{bidData.dqh_type_deal}}
						li.dtbid-condition
							b.dtbid-condition__key Объём
							p.dtbid-condition__value {{bidData.dqh_volume}} {{bidData.unit_for_all}}
						li.dtbid-condition
							b.dtbid-condition__key Минимальная партия
							p.dtbid-condition__value {{bidData.dqh_min_party}}
						li.dtbid-condition
							b.dtbid-condition__key Логистика
							p.dtbid-condition__value {{bidData.dqh_logistics}}
						li.dtbid-condition
							b.dtbid-condition__key Документы подтверждающие качество
							p.dtbid-condition__value {{bidData.dqh_doc_confirm_quality}}
						li.dtbid-condition
							b.dtbid-condition__key Способ оплаты
							p.dtbid-condition__value {{bidData.dqh_payment_method}}, {{bidData.budget_with_nds ? 'с' : 'без'}} НДС
						li.dtbid-condition
							b.dtbid-condition__key Условия оплаты
							p.dtbid-condition__value {{bidData.dqh_payment_term}}
					p.dtbid-content__period
					|	Срок сбора предложения до {{bidData.deadline_deal|dateFormat}}
					p.dtbid-content__date
					| Добавлена {{bidData.published_at|dateFormat}}
					div.dtbid-content__category
						p {{bidData.category}}
					div.dtbid-content__location
						feather-map-pin
						span {{bidData.region}}
				div.dtbid-aside(v-if="organizationsList.length>0")
					h2.dtbid-aside__title Список поставщиков
					ul.dtbid-aside__vendors
						li.dtbid-aside__item(v-for="item,i in organizationsList" :key="item.inn")
							.vendor-card
								.vendor-card__info
									p {{item.name}}
									p 
									b ИНН: {{item.inn}}
									p(v-for="p in phonesSplitter(item.phone)") {{p}}
									p {{item.address_legal}}
									//-a.vendor-card__info--sitelink(:href="item.site" v-if="item.site") Официальный сайт компании
								.vendor-card__linkbox
									//-span Ссылка для регистрации компании
									div.vendor-card__createlink
										//-input(:value="item.link" readonly)
										button(@click="createReferalLinkForCompany(item.link,item.inn,item.name,item.okved,i)") {{item.link ? 'Копировать реф.ссылку' : 'Создать реф.ссылку'}}
					div.dtbid-aside__footer(v-if="paginationData.total>0")
						ul.pagination-list
							li.pagination__item(v-for="n in 5")
								button(@click="setNewPage(startPage+n-1)" :disabled="startPage+n-1>paginationData.lastPage" :class="{'disabled' : startPage+n-1>paginationData.lastPage,'active': startPage+n-1==paginationData.current_page}") {{startPage+n-1}}
						ul.pagination-controls
							li.pagination-controls__prev
								button(@click="setNewPage(paginationData.current_page-1)" :disabled="!paginationData.has_prev" :class="{'disabled': paginationData.has_prev==false, 'active' : paginationData.has_prev}")
									feather-chevron-left
							li.pagination-controls__next
								button(@click="setNewPage(paginationData.current_page+1)" :disabled="paginationData.has_next==false" :class="{'disabled': paginationData.has_next==false, 'active' : paginationData.has_next}")
									feather-chevron-right

</template>

<script>
// this.$route.params.id
import message from "@/components/message.vue";
import goback from "@/components/Goback.vue";
import featherMapPin from "@/components/icons/featherMapPin.vue";
import featherChevronLeft from "@/components/icons/featherChevronLeft.vue";
import featherChevronRight from "@/components/icons/featherChevronRight.vue";
import paginationMixin from "@/mixins/pagination.mixin.js";
export default {
  components: {
    goback,
    message,
    featherMapPin,
    featherChevronLeft,
    featherChevronRight
  },
  mixins: [paginationMixin],
  data() {
    return {
      showMessage: false,
      number: null,
      bidData: {},
      activeCompanyId: -1,
      organizationsList: []
    };
  },
  created() {
    this.queryParams.per_page = 3;
    this.number = this.$route.params.id;

    this.getBid().then(() => {
      this.getOrganizations().then(() => {
        this.loadOrganizationsList(this.url);
      });
    });
  },
  computed: {
    activeCompany() {
      let result =
        this.organizationsList.find(item => item.id == this.activeCompanyId) ||
        this.organizationsList[0];

      result ? (result.index = this.organizationsList.indexOf(result)) : "";

      return result;
    },
    url() {
      let queryParams = this.urlConstructor(this.queryParams);
      return `/api/v1/hypothesis/organizations/deal/${this.number}?${queryParams}`;
    }
  },
  methods: {
    phonesSplitter(value) {
      return value.split(",") || [];
    },
    setNewPage(page) {
      if (page != this.queryParams.page) {
        this.setPage(page);
        this.$nextTick(() => {
          this.loadOrganizationsList(this.url);
        });
      }
    },
    async getOrganizations() {
      if (this.bidData.organizations_count == 0) {
        await this.attachCompanies(this.bidData.tamtem_organization_okved);
      }
    },
    async getBid() {
      if (!this.$route.params.bid) {
        await this.loadBidData(this.$route.params.id);
      } else {
        this.bidData = Object.assign({}, this.$route.params.bid);
      }
    },
    /**
     * Attach companies to bid.
     * @param {String} bidOkved okved added to bid
     */
    attachCompanies(bidOkved) {
      let data = {
        okved: bidOkved
      };
      // eslint-disable-next-line
      axios
        .post("/api/v1/hypothesis/organizations/attach", data)
        .then(response => {
          console.log(response);
        })
        .catch(err => {
          console.log(err);
        });
    },
    /**
     * Loading companies Array, attached to bid.
     * @param {String} url api url for foading items
     */
    loadOrganizationsList(url) {
      let result = [];
      // eslint-disable-next-line
      axios
        .get(url)
        .then(response => {
          if (response.data.result == true) {
            result = response.data.data.data;
            this.paginationData = Object.assign(
              {},
              this.setPaginationData(response.data.data)
            );
            this.queryParams.page = this.paginationData.current_page;
            this.queryParams.per_page = this.paginationData.per_page;
          } else {
            this.showError(response.data.error);
          }
        })
        .catch(() => {
          this.showError("Произошла ошибка, попробуйте позднее");
        })
        .then(() => {
          this.organizationsList = [...result];
        });
    },
    /**
     * Sending request to server for creating referal link
     * @param {[String]} link referalLink
     * @param {[String,Number]} companyInn INN company
     * @param {String} companyName Name company
     * @param {[String,Number]} bidId Bid identificator
     * @param {Number} index company index in array
     */
    createReferalLinkForCompany(link, companyInn, companyName, bidId, index) {
      if (link) {
				link="Вас приветствует B2B биржа оптовых заказов tamtem.ru.\n"+"На нашем сервисе есть заказ: "+this.bidData.name+"\nОбъем заказа: "+this.bidData.dqh_volume+" "+this.bidData.unit_for_all+"\nСредняя сумму заказа: "+this.bidData.budget_all+" ₽"+"\nДля подробной информации о заказе перейдите по ссылке: "+link+"\n\nИнформацию о сервисе можно просмотреть на нашем сайте https://tamtem.ru/postavschic в соц сетях https://vk.com/tamtem_b2b и по телефону +7 (930) 720-23-00\n"+"Приглашаем компании к постоянному сотрудничеству!";
				this.copyToClipboard(link);
        this.showMessage = true;
        setTimeout(() => {
          this.showMessage = false;
        }, 10000);
      } else {
        const data = {
          inn: companyInn,
          name: companyName,
          bid: bidId
        };
        // eslint-disable-next-line
        axios
          .post("/api/v1/user/refgenerate", data)
          .then(response => {
            if (response.data.result == true) {
              this.updateLink(index, response.data.data);
            } else {
              this.showError("Произошла ошибка, попробуйте позднее");
            }
          })
          .catch(() => {
            // console.log(err);
            this.showError("Произошла ошибка, попробуйте позднее");
          });
      }
    },
    /**
     * updating `link` property in company data by company index.
     * @param {Number} index company index in companies array.
     * @param {String} link referal link for company.
     */
    updateLink(index, link) {
      let item = this.organizationsList[index];
      item.link = link;
      this.$set(this.organizationsList, index, item);
    },
    /**
     * get bidData by her id.
     * @param {[Number,String]} id bidId for loading data
     */
    async loadBidData(id) {
      let result = {};
      // eslint-disable-next-line
      await axios
        .get(`/api/v1/hypothesis/deals/${id}`)
        .then(response => {
          if (response.data.result == true) {
            result = response.data.data;
          } else {
            this.showError(response.data.error);
          }
        })
        .catch(() => {
          this.showError("Ошибка загрузки данных");
        })
        .then(() => {
          this.bidData = Object.assign({}, result);
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.dtbid {
  font-size: 14px;
  button {
    background: none;
    border: none;
    cursor: pointer;
  }
}
.dtbid-header {
  background-color: $color-base-accent;
  color: $color-base-light;
  padding-top: 38px;
  padding-bottom: 30px;
  &__container {
    display: grid;
    grid-template-columns: auto 1fr;
    column-gap: 26px;
    @media (max-width: 420px) {
      grid-template-columns: 1fr;
      position: relative;
    }
  }
  &__goback {
    & /deep/ .feather {
      width: 2.4rem;
      height: 2.4rem;
      svg {
        width: 100%;
        height: 100%;
      }
    }
    @media (max-width: 420px) {
      position: absolute;
      top: 0;
      left: 0.7rem;
    }
  }
  &__info {
    display: flex;
    flex-direction: column;
  }
  &__title {
    margin-bottom: 10px;
    h1 {
      margin: 0;
      font: $font-medium;
      font-size: 32px;
      line-height: 27px;
      -moz-hyphens: auto;
      -webkit-hyphens: auto;
      -ms-hyphens: auto;
      hyphens: auto;
      @media (max-width: 768px) {
        font-size: 26px;
      }
      @media (max-width: 420px) {
        font-size: 18px;
        text-align: center;
      }
      br {
        @media (min-width: 421px) {
          display: none;
        }
      }
    }
  }
  &__budget {
    margin-bottom: 10px;
    font-size: 17px;
    font-weight: 600;
    @media (max-width: 420px) {
      font-size: 16px;
      text-align: center;
      margin-top: 15px;
    }
  }
  &__period {
    font-size: 14px;
    font-weight: 500;
    @media (max-width: 420px) {
      text-align: center;
    }
  }
}
.dtbid-body {
  @media (max-width: 768px) {
    background: #f1f1f6;
    padding-top: 42px;
    // background: #f6f6f6;
  }
  &__outerblock {
    @media (min-width: 769px) {
      display: none;
    }
  }
  &__mainblock {
    @media (max-width: 768px) {
      background: #ffffff;
      box-shadow: 0 2px 6px 0 rgba(69, 91, 99, 0.18);
      border-top-left-radius: 32px;
      border-top-right-radius: 32px;
      margin-top: 35px;
    }
  }
  &__container {
    padding-top: 44px;
    padding-bottom: 110px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    column-gap: 50px;
    grid-template-areas: "content content aside";
    @media (max-width: 768px) {
      grid-template-columns: 1fr;
      grid-template-areas: "content";
    }
  }
}

.dtbid-content {
  grid-area: content;
  display: flex;
  flex-direction: column;
  &__list {
    margin-bottom: 20px;
  }
  &__period {
    margin-top: auto;
  }
  &__date {
    margin-top: 20px;
  }
  &__category {
    margin-top: 33px;
    display: flex;
    p {
      @include flex-centerizer;
      border: 1px solid $color-base-accent;
      border-radius: 32px;
      font-size: 14px;
      padding: 6px 18px;
      text-align: center;
      @media (max-width: 768px) {
      }
      @media (max-width: 420px) {
        font-size: 11px;
        padding: 5px 6px;
      }
    }
  }
  &__location {
    margin-top: 30px;
    padding: 4px 0;
    display: flex;
    align-items: center;
    & /deep/ svg {
      color: $color-base-accent;
      height: 15px;
    }
  }
}
.dtbid-aside {
  grid-area: aside;
  justify-self: end;
  max-width: 310px;
  width: 100%;
  min-height: 100px;
  @media (max-width: 768px) {
		display: none;
  }
  &__title {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border: 1px solid $color-border-gray;
    border-bottom: none;
    background: #f6f6f6;
    padding: 28px 20px 35px;
    text-align: center;
    font-weight: 500;
    font-size: 18px;
  }
  &__vendors {
    border: 1px solid $color-border-gray;
    border-bottom: none;
    background: #f6f6f6;
  }
  &__item {
    border-top: 1px solid $color-border-gray;
    border-bottom: 1px solid $color-border-gray;
    padding: 15px 18px;
    background: #ffffff;
    &:not(:last-child) {
      margin-bottom: 26px;
    }
  }
  &__footer {
    display: flex;
    align-items: center;
    background: #f6f6f6;
    border: 1px solid $color-border-gray;
    border-top: none;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    padding: 20px 20px;
  }
}
.pagination-list {
  display: flex;
  margin-right: 15px;
  button {
    @include flex-centerizer;
    @include w-h(30px);
    font-size: 13px;
    color: $color-text-gray;
    font-size: 13px;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 50%;
    margin-right: 4px;
    transition: 0.3s;
    &:hover {
      border-color: $color-base-accent;
    }
    &:active {
      border-color: $color-border-gray;
    }
  }
  button.active {
    background: $color-base-accent;
    color: #fff;
  }
  button.disabled {
    &:hover {
      border-color: transparent;
      cursor: default;
    }
  }
}
.pagination-controls {
  display: flex;
  margin-left: auto;
  button {
    @include flex-centerizer;
    @include w-h(39px, 30px);
    background: #fff;
    border: 1px solid $color-border-gray;
    & /deep/ svg {
      height: 14px;
      stroke-width: 1px;
    }
  }
  .disabled {
    background: #f6f6f6;
    & /deep/ svg {
      opacity: 0.2;
    }
  }
  &__next {
  }
  &__prev {
    button {
      border-right: none;
    }
  }
}
.dtbid-vendors {
  &__controls {
    margin-bottom: 30px;
    ul {
      display: flex;
      width: 100%;
      overflow-x: scroll;
      scrollbar-width: none;
    }
    ul::-webkit-scrollbar {
      height: 0px;
    }
    li {
      &:not(:last-child) {
        margin-right: 15px;
      }
    }
    button {
      @include flex-centerizer;
      outline: none;
      min-width: 160px;
      flex-shrink: 0;
      padding: 8px 20px;
      border: 1px solid $color-border-gray;
      border-radius: 32px;
      color: #b8b8b8;
      background: #ffffff;
      &.active {
        background: $color-base-accent;
        color: #fff;
        border-color: $color-base-accent;
      }
    }
  }
  &__card {
    background: #fff;
    padding: 15px;
    padding-bottom: 25px;
    border-radius: 4px;
    border: solid 1px $color-border-gray;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    @media (max-width: 500px) {
      grid-template-columns: 1fr;
      gap: 20px;
    }
  }
  .vendor-card__linkbox {
    margin: 0;
  }
  .vendor-card__createlink {
    width: 100%;
    @media (max-width: 500px) {
      flex-direction: column;
      height: auto;
      input {
        width: 100%;
        margin-bottom: 10px;
        height: 36px;
        min-width: 10px;
      }
      button {
        border-radius: 32px;
        min-width: 133px;
        height: 38px;
        margin: 0 auto;
      }
    }
  }
}
.vendor-card {
  &__info {
    font-size: 12px;
    line-height: 18px;
    &--sitelink {
      color: $color-base-accent;
      margin-top: 5px;
      display: block;
    }
  }
  &__linkbox {
    margin-top: 20px;
    span {
      display: block;
      color: $color-text-gray;
      font-size: 12px;
      margin-bottom: 7px;
    }
  }
  &__createlink {
    display: flex;
    width: 100%;
    height: 38px;
    input {
      min-width: 50px;
      height: 100%;
      border: 1px solid $color-border-gray;
      border-right: none;
      border-top-left-radius: 4px;
      border-bottom-left-radius: 4px;
      padding: 0 10px;
    }
    button {
      @include flex-centerizer;
      height: 100%;
      width: 100%;
			flex-shrink: 0;
      background: $color-pale-green;
      color: $color-base-accent;
      cursor: pointer;
      border: 1px solid $color-pale-green;
      border-radius: 4px;
    }
  }
}
.dtbid-condition {
  &:not(:last-child) {
    margin-bottom: 25px;
  }
  &__key {
    display: block;
    font-weight: 500;
    font-size: 16px;
    margin-bottom: 5px;
  }
  &__value {
    font-size: 14px;
    line-height: 19px;
  }
}
</style>