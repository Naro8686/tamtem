import Axios from "axios";
const currencyModule = {
    state: {
        selectedCurrency: null,
        currencies: [
            {
                code: 'rur',
                symbol: '₽',
                icon: '/images/icon-ru.svg',
                country: 'Russia (Россия)'
            },
            {
                code: 'br',
                symbol: 'Br',
                icon: '/images/icon-br.svg',
                country: 'Belarus (Беларусь)'
            }
        ],
    },
    mutations: {
        setCurrency(state, payload) {
            state.selectedCurrency = payload;
        }
    },
    getters: {
        getSelectedCurrency: state => {
            return state.currencies.find(item => item.code === state.selectedCurrency);
        },
        getCurrencies: state => {
            return state.currencies;
        },
    },
    actions: {
        async getCurrency(context) {
            const result = await Axios.get("/api/v1/currency/get");
            if (result.status === 200 && result.data.result) {
                context.commit("setCurrency", result.data.data.currency);
            }
        },
        async setCurrency(context, payload) {
            const result = await Axios.post("/api/v1/currency/set", {currency: payload});
            console.log(result);
            if (result.status === 200 && result.data.result) {
                context.commit("setCurrency", result.data.data.currency);
            }
        }
    }
};
export default currencyModule;