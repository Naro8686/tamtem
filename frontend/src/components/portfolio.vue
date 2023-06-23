<template lang="pug">
	section.portfolio(v-if="isAuth")
		h1.portfolio__title Портфель компаний
		addCompany
		.portfolio__total Всего в портфеле: 
			b {{paginationData.total|pluralizeRus(itemsVariable)}}
		section.portfolio__companies
			portfolioCompaniesTable(v-if="width>600" :companiesList="companiesList")
			ul.companies-cards(v-else)
				portfolioCompanyCard(:key="company.id" :company="company" v-for="company in companiesList")
			footer.portfolio-controls
				div.portfolio-controls__showed
					div(@click="openedPerPage=true" :class='{"active" : openedPerPage==true}') {{paginationData.per_page}}
					p.overlay(@click="openedPerPage=false" v-if="openedPerPage")
					ul.per-page--list(v-if="openedPerPage")
						li.per-page--item(@click="setPerPage(10)") 10
						li.per-page--item(@click="setPerPage(15)") 15
						li.per-page--item(@click="setPerPage(20)") 20
						li.per-page--item(@click="setPerPage(25)") 25
						li.per-page--item(@click="setPerPage(30)") 30
					span Показано на странице
				nav.pagination
					ul.pagination__list
						li.pagination__item(v-for="n in 5")
							//- класс .active для текущего
							button(@click="setPage(startPage+n-1)" :disabled="startPage+n-1>paginationData.lastPage" :class="{'disabled' : startPage+n-1>paginationData.lastPage,'active': startPage+n-1==paginationData.current_page}") {{startPage+n-1}}
	section(v-else)
		p Чтобы пользоваться личным кабинетом, нужно авторизоваться
</template>
<script>
import portfolioCompanyCard from "@/components/portfolioCompanyCard.vue";
import portfolioCompaniesTable from "@/components/portfolioCompaniesTable.vue";
import addCompany from "@/components/addCompany.vue";
import { mapState, mapActions } from "vuex";
export default {
  components: {
    addCompany,
    portfolioCompanyCard,
    portfolioCompaniesTable
  },
  data() {
    return {
			itemsVariable:[
				'компания', 'компании', 'компаний'
			],
      openedPerPage: false,
			companiesList: [],
			queryParams: {
				page: 1,
				per_page: 15
			},
      paginationData: {
				current_page: 1,
				per_page: 15,
				has_prev: false,
				has_next: true,
				total: 0,
				lastPage: 0,
      }
    };
  },
  created() {
    if (this.isAuth) {
      this.loadCompaniesList();
    }
  },
  computed: {
    ...mapState(["width"]),
		...mapState("user", ["profile", "token"]),
		url(){
			let queryParams = this.urlConstructor(this.queryParams);
			return `/api/v1/organizations?${queryParams}`
		},
		startPage(){
      if (this.paginationData.current_page<=2){
        return 1
      }else if (this.paginationData.current_page>=this.paginationData.lastPage-1){
         if(this.paginationData.lastPage-4>0) {return this.paginationData.lastPage-4} else{ return 1}
      } else{
        return this.paginationData.current_page - 2
      }
    },
    isAuth() {
      return (
        !!this.token && this.profile && Object.keys(this.profile).length > 0
      );
    }
  },
  watch: {
    isAuth(newVal) {
      if (newVal === false) {
        this.$router.push({ name: "account" });
      } else {
        this.loadCompaniesList();
      }
		}
  },
  methods: {
    ...mapActions("portfolio", ["loadCompanies"]),
    loadCompaniesList() {
      this.loadCompanies(this.url)
        .then(response => {
          if (response.data.result == true) {
            this.companiesList = response.data.data.data;
              // response.data.data ={
              //   data: [],
              //   current_page: this.queryParams.page,
              //   per_page: this.queryParams.per_page,
              //   total: 666,
              //   lastPage: Math.ceil((666/this.queryParams.per_page)),
              //   has_next: true,
              //   has_next: true
              // }
            this.paginationData = Object.assign(
              {},
              this.setPaginationData(response.data.data)
						);
						
						this.queryParams.page = this.paginationData.current_page;
						this.queryParams.per_page = this.paginationData.per_page;

          } else {
            this.showError("Произошла ошибка загрузки компаний");
          }
        })
        .catch(() => {
          this.showError("Произошла ошибка загрузки компаний");
        });
		},
		urlConstructor(objParams){
			let result = ''
			for (let key in objParams){
				result += `${key}=${objParams[key]}&`	
			}
			return result.slice(0,result.length-1);
		},
		setPage(newPage){
			this.queryParams.page = newPage;
			
			this.$nextTick(()=>{
				this.loadCompaniesList();
			})
		},
    setPerPage(value) {
			this.queryParams.per_page = value;
			this.queryParams.page = 1;
			this.openedPerPage = false;
			
			this.$nextTick(()=>{
				this.loadCompaniesList();
			})
			
    },
    setPaginationData(responseDataData) {
      const paginationData = {
        current_page: responseDataData.current_page,
				per_page: responseDataData.per_page,
				total: responseDataData.total,
				lastPage: responseDataData.last_page,
        has_next: responseDataData.next_page_url != null,
        has_prev: responseDataData.prev_page_url != null
      };
      return paginationData;
    }
  }
};
</script>

<style lang="scss" scoped>

$arrow-down: 'data:image/svg+xml;base64,PHN2ZyBkYXRhLXYtMDc0NTIzNzM9IiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgICAgc3Ryb2tlPSJjdXJyZW50Q29sb3IiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj4gICAgPHBvbHlsaW5lIHBvaW50cz0iNiA5IDEyIDE1IDE4IDkiPjwvcG9seWxpbmU+PC9zdmc+';

@mixin w-h($width, $height: $width) {
  width: $width;
  height: $height;
}
@mixin flex-centerizer {
  display: flex;
  align-items: center;
  justify-content: center;
}
.portfolio {
  &__title {
    @include blocktitle;
  }
	&__total{
		margin-bottom: 24px;
		font: $font-regular;
		font-size: $fontsize-base;
		b{
		font: $font-semibold;
		font-size: $fontsize-base;
		}
	}

  &__companies {
		// margin-top: 40px;
    @include contentbox;
    padding: 0;
  }
}
.cell-category {
  width: 100%;
  max-width: 164px;
  display: flex;
  padding: 6px 3px;
  padding-left: 7px;
  background: #ececec;
  border-radius: 35px;
  align-items: center;
  font-size: 10px;
  line-height: 14px;
  word-break: break-word;
  &::before {
    content: "";
    @include w-h(12px);
    background: #000;
    border-radius: 50%;
    margin-right: 7px;
    flex-shrink: 0;
  }
  &--products {
    background-color: #d4f5de;
    &::before {
      background: linear-gradient(24deg, #2fc06e, #5fefc0);
    }
  }
  &--kids {
    background-color: #fef5de;
    &::before {
      background: linear-gradient(26deg, #ffbb00, #ffed4e);
    }
  }
  &--cloth {
    background-color: #dffcff;
    &::before {
      background: linear-gradient(26deg, #36f7e3, #00b1ff);
    }
  }
  &--furniture {
    background-color: #ffe7cf;
    &::before {
      background: linear-gradient(24deg, #ff6a33, #ffdd57);
    }
  }
  &--farm {
    background-color: #f3fff1;
    &::before {
      background: linear-gradient(26deg, #34a70b, #3aff00);
    }
  }
  &--arc {
    background-color: #feffec;
    &::before {
      background: linear-gradient(24deg, #fff830, #ffffe2);
    }
  }
  &--build {
    background-color: #ffefef;
    &::before {
      background: linear-gradient(26deg, #c81111, #ff7878);
    }
  }
  &--general {
    background-color: #f3faf3;
    &::before {
      background: linear-gradient(26deg, #4d8b56, #b1ffc0);
    }
  }
  &--transport {
    background-color: #ffe8ea;
    &::before {
      background: linear-gradient(26deg, #f7366b, #fd7b88);
    }
  }
  &--events {
    background-color: #fff2fd;
    &::before {
      background: linear-gradient(26deg, #43ecec, #fd7bfd);
    }
  }
  &--services {
    background-color: #eafbfd;
    &::before {
      background: linear-gradient(26deg, #43ecec, #fd7bfd);
    }
  }
  &--tobacco {
    background-color: #fbf2ff;
    &::before {
      background: linear-gradient(26deg, #6443ec, #fd7bc5);
    }
  }
  &--others {
    background-color: #efffee;
    &::before {
      background: linear-gradient(26deg, #a3ec43, #f0fd7b);
    }
  }
}

.portfolio-controls {
  display: flex;
  padding: 20px 13px;
  @media (max-width: 500px) {
    flex-direction: column;
    align-items: flex-end;
    padding-top: 35px;
  }
  &__showed {
    display: flex;
    align-items: center;
    position: relative;
    @media (max-width: 500px) {
      order: 2;
      margin-top: 15px;
      div {
        order: 2;
        margin-left: 10px;
      }
      span {
        margin: 0;
        order: 1;
      }
    }
    div {
      cursor: pointer;
      position: relative;
      @include w-h(50px, 30px);
      @include flex-centerizer;
      font-weight: 400;
      background: #fff;
      border-radius: 35px;
      font-size: 12px;
			border: 1px solid $color-border-gray;
			padding-left: 5px;
			justify-content: space-evenly;
			&:after{
				content: '';
				@include w-h(14px);
				background: url($arrow-down);
				background-size: contain;
				background-position: center;
				transition: all 0.25s 0.01s;
			}
			&.active{
				&:after{
					transition: all 0.25s 0.01s;
					transform: rotate(-180deg);
				}
			}
    }
    .overlay {
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
    }
    .per-page {
      &--list {
        position: absolute;
        top: 100%;
        left: 0;
        width: 48px;
        text-align: left;
				background: white;
				border-radius: 4px;
				border: 1px solid $color-border-gray;
				@media (max-width: 500px) {
					right: 0;
					left: auto;
				}
      }
      &--item {
				padding-left: 10px;
				height: 19px;
				cursor: pointer;
				font: $font-regular;
				font-size: $fontsize-smaller;
        &:hover {
          background: $color-pale-green;
        }
      }
    }
    span {
      font-size: 12px;
      margin-left: 14px;
    }
  }
  .pagination {
    margin-left: auto;
    display: flex;
    align-items: center;
    @media (max-width: 500px) {
      margin: 0;
      order: 1;
    }
    button {
      // общее для кнопок
      border: 1px solid transparent;
      cursor: pointer;
      transition: 0.3s;
      &:hover {
        border-color: $color-base-accent;
      }
      &:active {
        border-color: $color-border-gray;
      }
      &.disabled{
        &:hover{
          border-color: transparent;
          cursor: default;
        }
        }
    }
    &__list {
      display: flex;
      list-style: none;
    }
    &__item {
      &:not(:last-child) {
        margin-right: 3px;
      }
      button {
        @include w-h(30px);
        @include flex-centerizer;
        background: transparent;
        border-radius: 50%;
        font-size: 13px;
        color: $color-text-gray;
        &.active {
          background-color: $color-base-accent;
          color: #fff;
          border-color: $color-base-accent;
        }
        &.disabled{
        color: #cdcdcd;
        }
      }
    }
    &__next {
      border-radius: 35px;
      background: #fff;
      padding: 0 10px;
      min-width: 90px;
      height: 30px;
      font-size: 12px;
      margin-left: 10px;
    }
  }
}
</style>