import { Validator } from "vee-validate";

export default {
	/* eslint-disable-next-line */
	install(Vue) {
		Validator.extend("mobilePhone", {
			field: field => `Поле ${field} имеет ошибочный формат`,
			validate: value => {
				return value.replace(/[^0-9]/gi, "").replace(/^[78]/, "").length == 10;
			}
		});
		Validator.extend("inn", {
			getMessage: field => `Поле ${field} может содержать 10 или 12 цифр`,
			validate: value => {
				return !/[^0-9]/.test(value) && [10, 12].indexOf(value.length) !== -1;
			}
		});
		Validator.extend("money", {
			getMessage: field =>
				`Поле ${field} должно быть числом и может содержать 2 знака после запятой`,
			validate: value => {
				return /^\d*[,.]?\d{0,2}$/.test(value);
			}
		});
		Validator.extend("minimal", {
			getMessage: (field, arg) => `Поле ${field} должно быть больше или равно ${arg[0]}`,
			validate: (value, arg) => {
				return parseFloat(value.replace(",", ".")) >= parseFloat(arg[0]);
			}
		});
	}
};
