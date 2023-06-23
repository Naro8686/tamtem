<template functional lang="pug">
    div.message-container.container
        p.message-container__text {{props.text}}
        button(@click="listeners['close']").message-container__close Закрыть
</template>
<script>
export default {
  props: {
    text: {
      type: String
    },
  },
};
</script>
<style lang="scss" scoped>
.message-container {
  position: fixed;
  left: 0;
  right: 0;
  top: 30%;
  width: 100%;
  background-color: #d4f5de;
  border: 1px solid $color-base-accent;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 5px 30px;
  min-height: 43px;
  &::before {
    content: "";
    @include w-h(21px);
    background-color: $color-base-accent;
    border-radius: 50%;
    background: url(../assets/img/tick.svg) no-repeat, $color-base-accent;
    background-position: center;
    flex-shrink: 0;
    margin-right: 15px;
  }
  &__text {
    font-size: 12px;
  }
  &__close {
    border: none;
    background: none;
    color: $color-base-accent;
    cursor: pointer;
  }
}
</style>