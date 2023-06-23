import Vue from "vue";
import Router from "vue-router";
import Home from "./components/Home.vue";
// import {mapState} from 'vuex';
import userData from '@/store/usermodule.js';
Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      redirect: "/home",
      name: "account",
      component: () =>
        import(/* webpackChunkName: "account" */ "./views/Account.vue"),
      children: [
				{
					path: "/home",
					name: "home",
					component: Home
				},
        {
          path: "/profile",
          name: "profile",
          component: () =>
            import(
              /* webpackChunkName: "account-profile" */ "./components/profile.vue"
            )
        },
        {
          path: "/portfolio",
          name: "portfolio",
          component: () =>
            import(
              /* webpackChunkName: "account-portfolio" */ "./components/portfolio.vue"
            )
        },
        {
          path: "/status",
          name: "status",
          component: () =>
            import(
              /* webpackChunkName: "account-status" */ "./components/status.vue"
            ),
          props:{userData: userData.state}  
        },
        {
          path: "/balance",
          name: "balance",
          component: () =>
            import(
              /* webpackChunkName: "account-balance" */ "./components/balance.vue"
            )
        },
				{
          path: "/finance",
          name: "finance",
          component: () =>
            import(
              /* webpackChunkName: "account-finance" */ "./components/finance.vue"
            )
        },
        {
          path: "/editprofile",
          name: "editprofile",
          component: () =>
            import(
              /* webpackChunkName: "account-profile-edit" */ "./components/editprofile.vue"
            )
        }
      ]
    },
   /* {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () =>
        import(/* webpackChunkName: "about" */ /*"./views/About.vue")
		},*/
		
		{
			path: "/biddetail/:id",
			name: "biddetail",
			component: () =>
				import(/* webpackChunkName: "biddetail" */ "./views/BidDetail.vue")
		},
    {
      path: '*',
      name: '404',
      component : () => import(/*webpackChunkName: "404"*/ "./views/404.vue")
    }
  ]
});
