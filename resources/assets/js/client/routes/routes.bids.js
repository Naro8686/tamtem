import BidsList from '../views/Catalog/views/BidsList.vue'
import BidDetail from '../views/Catalog/views/BidDetail.vue'

const routes = [{
    // path: '/',
    path: '/optovyye-obyavleniya/bids/:parentSlug?/:slug?',
    name: 'bids.list',
    component: BidsList,
    meta: {
        breadcrumb: false,
        title: `${APPNAME} - сервис оптовых заказов`,
        type: 'buy',
        cyrName: 'Заказы'
    },
},
    {
        path: '/bids/:id',
        redirect: "/optovyye-obyavleniya/bid/:id/detail",
    },
    {
        path: '/optovyye-obyavleniya/bid/:id/detail',
        name: 'bids.detail',
        component: BidDetail,
        meta: {
            title: `${APPNAME} - Заявка`,
            type: 'buy',
            cyrName: "Заявка"
        },
    },
    {
        path: "/sales/:id",
        redirect: "/optovyye-obyavleniya/sale/:id/detail",
    },
    {
        path: '/optovyye-obyavleniya/sale/:id/detail',
        name: 'sells.detail',
        component: BidDetail,
        meta: {
            title: `${APPNAME} - Заявка`,
            type: 'sell'
        },
    },
    {
        //path: '/!sales',
        path: '/optovyye-obyavleniya/sales/:parentSlug?/:slug?',
        name: 'sells.list',
        component: BidsList,
        meta: {
            breadcrumb: false,
            title: `${APPNAME} - Объявления`,
            type: 'sell',
            cyrName: "Объявления"
        }
    }
]

export default routes