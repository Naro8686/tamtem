<template lang="pug">
section.infobar
	div.infobar__container.container
		div.infobar__statbox
			ul.infobar__counts
				p 
				b Подробнее о работе с сервисом в нашей группе &nbsp;
				a(href="https://vk.com/tamtem_b2b") vk.com
				//-li(:class="{'active' : countItem==1}").infobar-companies.infobar__item
					p.infobar__label Привлеченных компаний
					p.infobar__count
						stat-count(str="502")
				//-li(:class="{'active' : countItem==2}").infobar-users.infobar__item
					p.infobar__label Зарегистрированных агентов
					p.infobar__count
						stat-count(str="945")
				//-li(:class="{'active' : countItem==3}").infobar-money.infobar__item
					p.infobar__label Выведено денежных средств, ₽ 
					p.infobar__count
						stat-count(str="105945")
			//-ul.infobar__controls
				li(v-show="countItem!==3" @click="nextSlide").infobar__control.infobar__control--right
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
				li(v-show="countItem!==1" @click="prevSlide").infobar__control.infobar__control--left
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
			//-ul.infobar__slidebar
				li(:class="`active-${countItem}`").infobar__caret
</template>

<script>
import statCount from "@/components/statCount"

export default {
	components: {
		statCount,
	},
	data() {
		return {
			countItem: 1,
		}
	},
	methods: {
		nextSlide() {
			if(this.countItem<3) {
				this.countItem++
			} else {
				this.countItem = 1
			}
		},
		prevSlide() {
			if(this.countItem>1) {
				this.countItem--
			} else {
				this.countItem = 3
			}
		},
	},
	mounted() {
		if(window.innerWidth <= 1030) {
			setInterval(() => {
				this.nextSlide()
			}, 10000)
		}
		let swipedetect = (el, callback) => {
			let swipedir = 'none'
			let startX
			let startY
			let distX
			let distY
			let threshold = 50
			let restraint = 50
			let allowedTime = 300
			let elapsedTime
			let startTime
			//-let ismousedown = false
			let handleswipe = callback || //-function(swipedir) {}
			el.addEventListener("touchstart", function(e){
				let obj = e.changedTouches[0]
				swipedir = 'none'
				distX = 0
				startX = obj.pageX
				startY = obj.pageY
				startTime = new Date().getTime()
			})
			el.addEventListener("touchend", function(e){
				let obj =  e.changedTouches[0]
				distX = obj.pageX - startX
				distY = obj.pageY - startY
				elapsedTime = new Date().getTime() - startTime
				if (elapsedTime <= allowedTime) {
					if(Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){
						swipedir = (distX < 0) ? 'left' : 'right'
					}
				}
				handleswipe(swipedir)
			})
		}
		let countList = document.querySelector('.infobar__counts');
		swipedetect(countList, (swipedir) => {
			if(swipedir == "left") {
				this.nextSlide()
			}
			if(swipedir == "right") {
				this.prevSlide()
			}
		})
	}
}
</script>

<style lang="scss" scoped>
.infobar {
	box-shadow: 0 2px 6px 0 rgba(69,91,99,0.18);
	background-color:#fff;
	font-family: $font-family;
	&__statbox {
		display: flex;
		align-items: center;
		min-height: 68px;
		position: relative;
		@media(max-width: 1030px) {
			flex-direction: column;
			width: 100%;
		}
		@media(max-width: 500px) {
			min-height: 80px;
		}
	}
	&__counts {
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		//justify-content: space-between;
		//jjustify-content: center;
		//jtext-align: center;
		@media(max-width: 1030px) {
			position: relative;
			height: 55px;
		}
		@media(max-width: 500px) {
			height: 65px;
		}
	}
	&__item {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		@media(max-width: 1030px) {
			position: absolute;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			justify-content: center;
			// unactive
			opacity: 0;
			transition: 0.4s;
			z-index: -2;
			&.active {
				opacity: 1;
				z-index: 0;
			}
		}
		@media(max-width: 500px) {
			flex-direction: column;
		}
	}
	&__label {
		font-size: 14px;
		margin: 5px 0;
		margin-right: 14px;
		@media(max-width: 500px) {
			font-size: 12px;
		}
	}
	&__count {
		margin: 5px 0;
	}
	&__controls {
		@media(min-width: 1031px) {
			display: none;
		}
		display: flex;
	}
	&__control {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		&--right {
			right: 0;
		}
		&--left {
			left: 0;
		}
	}
	&__slidebar {
		@media(min-width: 1031px) {
			display: none;
		}
		width: 100%;
		height: 3px;
		display: flex;
		background: $color-pale-green;
	}
	&__caret {
		width: 33.3%;
		background-color: $color-base-accent;
		transition: 0.4s;
		&.active-1 {
			transform: translateX(0);
		}
		&.active-2 {
			transform: translateX(100%);
		}
		&.active-3 {
			transform: translateX(200%);
		}
	}
}
</style>