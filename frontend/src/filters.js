function stylePhone(phone) {
  return phone
    ? phone
        .toString()
        .replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, "+7 ($1) $2-$3-$4")
    : "";
}
// возвращает сумму отформатированную по разрядам
function priceFormat(money) {
  return money ? money.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ") : 0;
}
// принимает `YYYY-MM-DD HH:MM:SS` и возвращает `DD.MM.YYYY`
function dateFormat(date) {
  return date
    ? date
        .split(" ")[0]
        .split("-")
        .reverse()
        .join(".")
    : "";
}
function pluralizeRus(count,word){
  if(typeof(word)!=='object'){
    return count % 10 == 1 && count % 100 != 11
          ? `${count} ${word}`
          : count % 10 >= 2 && count % 10 <= 4 && (count % 100 < 10 || count % 100 >= 20)
          ? `${count} ${word}а`
          : `${count} ${word}ов`;
  }else{
    return count % 10 == 1 && count % 100 != 11
          ? `${count} ${word[0]}`
          : count % 10 >= 2 && count % 10 <= 4 && (count % 100 < 10 || count % 100 >= 20)
          ? `${count} ${word[1]}`
          : `${count} ${word[2]}`;
  }
}

export default {
  install(Vue) {
    Vue.filter("stylePhone", stylePhone);
    Vue.filter("priceFormat", priceFormat);
    Vue.filter("dateFormat", dateFormat);
    Vue.filter("pluralizeRus", pluralizeRus);
  }
};
