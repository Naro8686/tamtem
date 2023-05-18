import Vue from "vue";
import Vuex from "vuex";
import filtersModule from "./filters-module";
import profileModule from "./profile-module";
import serviceModule from "./service-module";
import categoriesModule from "./categories-module";
import regionsModule from "./regions-module";
import createBidModule from "./createBid-module";
import favouritesModule from "./favourites-module";
import newsModule from "./news-module"

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        filters: filtersModule,
        profile: profileModule,
        service: serviceModule,
        categories: categoriesModule,
        regions: regionsModule,
        createBid: createBidModule,
        news: newsModule,
        favourites: favouritesModule
    }
});