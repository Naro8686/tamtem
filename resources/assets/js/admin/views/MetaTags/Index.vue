<template>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="tablesettings">
        <div class="search-post--wrapper">

        </div>
      </div>
      <mytable
          ref="metatagstable"
          :eventPrefix="eventPrefix"
          :tabledata="tabledata"
          :tablekey="key"
          :fieldslist="tablecols"
          :nodata="nodata"
          :activesort="queryParams.sort"
          :isFixedHead="isfixedhead"
      >
      </mytable>
      <pagination
          v-if="tabledata.length > 0"
          :eventPrefix="eventPrefix"
          :paginationsettings="paginationsettings"
          :hasnext="pagination.hasnext"
          :hasprev="pagination.hasprev"
          :firstPage="pagination.firstPage"
          :lastPage="pagination.lastPage"
          :total="pagination.total"
          :perPage="pagination.perPage"
          :currentPage="queryParams.page"
      ></pagination>
      <!-- /.box-body -->
    </div>
  </section>
  <!-- /.content -->
</template>

<script>
import Vue from "vue";
import ViewMixins from "../../mixins/view";
import mytable from "../Components/mytable";
import pagination from "../Components/pagination";

Vue.component("mytable", mytable);
Vue.component("pagination", pagination);

Vue.component("page", {
  template: `
    <router-link :to="propert.link || '' ">
                       {{propert.page}}
                    </router-link>
  `,
  props: {
    propert: {
      type: Object
    }
  }
});

let tablefields = [
  {
    name: "id",
    title: "Номер",
    disabled: true,
    visible: true,
    sortable: false
  },
  {
    name: "__component:page",
    title: "Страница",
    disabled: true,
    visible: true,
    sortable: false
  },

  {
    name: "title",
    title: "Название",
    disabled: false,
    visible: true,
    sortable: false
  },
  {
    name: "description",
    title: "Описание",
    disabled: false,
    visible: true,
    sortable: false
  },
];
export default {
  name: "Index",
  mixins: [ViewMixins],
  props: {
    page: {
      type: [Number, String],
      default: 1
    },
    perPage: {
      type: [Number, String],
      default: 10
    },
    search: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      eventPrefix: "metatags:",
      tabledata: [],
      key: "id",
      searchPost: "",
      tablecols: tablefields,
      isfixedhead: true,
      nodata: "Нет данных",
      queryParams: {
        page: 1,
        perPage: 10,
        sort: "id|asc"
      },
      searchField: "",
      pagination: {
        hasprev: "",
        hasnext: "",
        perPage: 10,
        total: 0,
        firstPage: "",
        lastPage: "",
        currentPage: ""
      },
      paginationsettings: {
        viewcount: true,
        viewperpage: true,
        viewpagination: true,
        elemsname: "новость"
      }
    };
  },
  created() {
    this.updateParams();

    this.$router
        .replace({ name: "metatags", query: this.queryParams })
        .catch(() => {});

    this.addEventListeners();
    this.getdataforTable();
  },
  beforeDestroy() {
    this.removeEventListeners();
  },
  watch: {
    $route() {
      this.updateParams();
      this.getdataforTable();
    }
  },
  methods: {
    updateParams() {
      this.queryParams.page = this.page;
      this.queryParams.perPage = this.perPage;

      if (this.search) {
        this.queryParams.search = this.search;
        this.searchPost = this.search;
      } else {
        this.searchPost = "";
      }
    },
    updateRoute() {
      this.$router
          .push({ name: "metatags", query: this.queryParams })
          .catch(() => {});
    },
    addEventListeners() {
      this.$root.$on(this.eventPrefix + "changeperpage", (payload) => {
        let fr = 0;
        fr = (this.queryParams.page - 1) * this.queryParams.perPage + 1;
        this.queryParams.page = Math.ceil(fr / payload);
        this.queryParams.perPage = payload;

        this.updateRoute();
      });
      // изменение страницы
      this.$root.$on(this.eventPrefix + "newpage", (payload) => {
        if (
            this.queryParams.page != payload &&
            payload > 0 &&
            payload <= this.pagination.lastPage
        ) {
          this.queryParams.page = +payload;
        } else {
          this.queryParams.page = 1;
        }
        this.updateRoute();
      });
    },
    removeEventListeners() {
      let events = [
        this.eventPrefix + "changeperpage",
        this.eventPrefix + "newpage"
      ];

      for (let item of events) {
        this.$root.$off(item);
      }
    },
    setSearch() {
      if (this.searchClient.length < 1) {
        this.showError("Минимальная длина поиска 1 символ");
        return false;
      } else {
        // this.getdataforTable();
        this.$set(this.queryParams, "search", this.searchClient);
        this.updateRoute();
      }
    },
    resetSearch() {
      this.searchClient = "";
      this.$delete(this.queryParams, "search");

      this.updateRoute();
    },
    serializeData(obj, prefix) {
      var str = [],
          p;
      for (p in obj) {
        if (obj.hasOwnProperty(p)) {
          var k = prefix ? prefix + "[" + p + "]" : p,
              v = obj[p];
          str.push(
              v !== null && typeof v === "object"
                  ? this.serializeData(v, k)
                  : encodeURIComponent(k) + "=" + encodeURIComponent(v)
          );
        }
      }
      return str.join("&");
    },
    getdataforTable() {
      let params = {
        page: this.queryParams.page,
        per_page: this.queryParams.perPage,
      };
      if (this.searchPost != "") {
        params.search = this.searchClient;
        this.queryParams.page = 1;
        params.page = 1;
      }

      let uri = this.serializeData(params);
      axios
          .get("/admin/api/metatags?" + uri)
          .then((resp) => {
            // подготавливаем данные для таблицы
            this.processdata(resp.data.data);
            // подготавливаем данные для пагинации
            this.getpaginationdata(resp);
          })
          .catch((error) => {
            this.messageLoadError();
          });
    },
    processdata(data) {
      this.tabledata = [];
      for (let i in data) {
        this.tabledata.push(data[i]);
        this.tabledata[i].link = "/admin/metatags/edit/" + data[i].id;
        this.tabledata[i].status = this.getOrgStatus(data[i].status);

      }
    },
    getpaginationdata(response) {
      this.pagination.currentPage = response.data.current_page;
      this.pagination.perPage = response.data.per_page;
      this.pagination.total = response.data.total;
      this.pagination.firstPage = 1;
      this.pagination.lastPage = response.data.last_page;
      this.pagination.hasnext =
          response.data.next_page_url == null ? false : true;
      this.pagination.hasprev =
          response.data.prev_page_url == null ? false : true;
    }
  }
}
</script>

<style scoped>
.content >>> .my__table tr.fakeDeal {
  background-color: rgba(0, 0, 0, 0.1);
}
.no-bg {
  background: transparent !important;
}
.addMetatags-wrap {
  padding-top: 10px;
  padding-left: 5px;
}
.create-metatags {
  border: 1px solid #908e8e;
  border-radius: 2px;
  padding: 5px;
  display: inline-block;
  margin-bottom: 10px;
}

.tablesettings {
  display: flex;
  justify-content: space-between;
}
.showblock-wrapper {
  align-self: end;
  margin-right: 5px;
}
</style>