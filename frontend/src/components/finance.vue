<template lang="pug">
	section.finance
		h2.finance__title Финансовые операции
		div.finance__box
			ul.finance__tab-controls
				li.finance__tab-control.finance__tab-control--active История пополнений
				li.finance__tab-control История списаний
			ul.finance__tab-content
				li.finance__tab-screen.tabscreen.tabscreen--adds
					.finance-table.finance-table--adds
						.finance-table__header
							.finance-table__header-row.finance-table__row
								.finance-table__header-cell Дата
								.finance-table__header-cell Компания
								.finance-table__header-cell № операции
								.finance-table__header-cell Сумма сделки
								.finance-table__header-cell Сумма
						.finance-table__body
							.finance-table__body-row.finance-table__row
								.finance-table__cell(data-name="date") вчера 17:43
								.finance-table__cell(data-name="company") ООО «Брянская мясная компания»
								.finance-table__cell.finance-table__cell--center(data-name="number")
									span.finance-table__cell-label № операции
									p №2558425545
								.finance-table__cell.finance-table__cell--center(data-name="dealsumm")
									span.finance-table__cell-label Сумма сделки
									p 5 000 000  ₽
								.finance-table__cell.finance-table__cell--center(data-name="summ") 4 000  ₽
							.finance-table__body-row.finance-table__row
								.finance-table__cell(data-name="date") 04 октября 2019 #[br]10:00
								.finance-table__cell(data-name="company") ООО «Брянская мясная компания»
								.finance-table__cell.finance-table__cell--center(data-name="number") 
									span.finance-table__cell-label № операции
									p №2558425545
								.finance-table__cell.finance-table__cell--center(data-name="dealsumm") 
										span.finance-table__cell-label Сумма сделки
										p 5 000 000  ₽
								.finance-table__cell.finance-table__cell--center(data-name="summ") 4 000  ₽
							.finance-table__body-row.finance-table__row
								.finance-table__cell(data-name="date") 04 октября 2019 #[br]10:00
								.finance-table__cell(data-name="company") ООО «Брянская мясная компания»
								.finance-table__cell.finance-table__cell--center(data-name="number") 
									span.finance-table__cell-label № операции
									p №2558425545
								.finance-table__cell.finance-table__cell--center(data-name="dealsumm") 
										span.finance-table__cell-label Сумма сделки
										p 5 000 000  ₽
								.finance-table__cell.finance-table__cell--center(data-name="summ") 4 000  ₽
				li.finance__tab-screen.tabscreen.tabscreen--offs
					.finance-table.finance-table--offs
						.finance-table__header
							.finance-table__header-row.finance-table__row
								.finance-table__header-cell Дата
								.finance-table__header-cell № операции
								.finance-table__header-cell Способ зачисления
								.finance-table__header-cell Сумма
						.finance-table__body
							.finance-table__body-row.finance-table__row
								.finance-table__cell(data-name="date") вчера 17:43
								.finance-table__cell.finance-table__cell--center(data-name="number") 
									span.finance-table__cell-label № операции 
									p №2558425545
								.finance-table__cell.finance-table__cell--center(data-name="method") 
										span.finance-table__cell-label Способ зачисления
										p Mastercard
								.finance-table__cell.finance-table__cell--center(data-name="summ") 4 000  ₽
							.finance-table__body-row.finance-table__row
								.finance-table__cell(data-name="date") 04 октября 2019 #[br]10:00
								.finance-table__cell.finance-table__cell--center(data-name="number") 
									span.finance-table__cell-label № операции
									p №2558425545
								.finance-table__cell.finance-table__cell--center(data-name="method") 
									span.finance-table__cell-label Способ зачисления
									p Mastercard
								.finance-table__cell.finance-table__cell--center(data-name="summ") 4 000  ₽
							.finance-table__body-row.finance-table__row
								.finance-table__cell(data-name="date") 04 октября 2019 #[br]10:00
								.finance-table__cell.finance-table__cell--center(data-name="number") 
									span.finance-table__cell-label № операции 
									p №2558425545
								.finance-table__cell.finance-table__cell--center(data-name="method") 
									span.finance-table__cell-label Способ зачисления
									p Mastercard
								.finance-table__cell.finance-table__cell--center(data-name="summ") 4 000  ₽
</template>
<script>
export default {
	
}
</script>

<style scoped lang="scss">
.finance {
	&__title {
		@include blocktitle;
	}
	&__box {
		@include contentbox;
		overflow: hidden;
		padding: 0;
	}
	&__btn {
		background: $color-base-accent;
		color: $color-text-light;
		border-radius: 22px;
		width: 150px;
		height: 42px;
		display: flex;
		justify-content: center;
		align-items: center;
		text-decoration: none;
		margin-left: 20px;
		@media(max-width: 600px) {
			justify-self: center;
		}
	}
	&__fields-box {
		display: flex;
		width: 70%;
		@media(max-width: 768px) {
			width: 100%;
		}
		@media(max-width: 600px) {
			display: grid;
			row-gap: 20px;
		}
	}
	&__fieldgroup {
		display: flex;
		flex-grow: 2;
	}
	&__field {
		@include hamster-field;
		height: 43px;
		flex-grow: 2;
		&--symbol {
			display: flex;
			justify-content: center;
			align-items: center;
			width: 43px;
			flex-grow: 0;
			flex-shrink: 0;
			margin-left: 10px;
		}
	}
	&__tab-controls {
		display: flex;
	}
	&__tab-control {
		list-style: none;
		padding: 10px;
		background-color: $color-base-gray-light;
		font-size: 16px;
		color: #000;
		font-weight: 600;
		border: 1px solid #ececec;
		min-height: 72px;
		width: 50%;
		display: flex;
		justify-content: center;
		align-items: center;
		text-align: center;
		border-left: none;
		@media(max-width: 768px) {
			font-size: 14px;
		}
		@media(max-width: 600px) {
			font-size: 11px;
			word-break: break-all;
		}
		&--active {
			background-color: #fff;
			border-top-left-radius: 10px;
			border-top-right-radius: 10px;
			border: 1px solid #ececec;
		}
	}
	&__tab-screen {
		list-style: none;
	}
	.tabscreen {
		&--out {
			padding: 25px 20px;
		}
	}
}
.finance-table {
	width: 100%;
	border-collapse: collapse;
	&__row {
		display: grid;
		@media(max-width: 600px) {
			padding: 10px;
		}
	}
	&--adds {
		.finance-table__row {
			grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
			@media(max-width: 600px) {
				grid-template-columns: 1fr 1fr;
				grid-template-areas: 
					"date summ"
					"company company"
					"number number"
					"dealsumm dealsumm";
				[data-name='summ'] {
					&::before {
						content: '+';
					}
				}
			}
		}
	}
	&--offs {
		.finance-table__row {
			grid-template-columns: 1fr 1fr 1fr 1fr;
			@media(max-width: 600px) {
				grid-template-columns: 1fr 1fr;
				grid-template-areas: 
					"date summ"
					"number number"
					"method method";
			}
			[data-name='summ'] {
				&::before {
					content: '-';
				}
			}
		}
	}
	&__header-row {
		@media(max-width: 600px) {
			display: none;
		}
	}
	&__header-cell {
		text-align: center;
		background-color: #d4f5de;
		border: solid 1px #8fc1a5;
		padding: 20px 10px;
		font-weight: 600;
		min-height: 72px;
		display: flex;
		align-items: center;
		font-size: 12px;
		justify-content: center;
		word-break: break-all;
	}
	&__cell{
		border: 1px solid #ececec;
		padding: 10px 10px;
		display: flex;
		font-size: 12px;
		line-height: 19px;
		align-items: center;
		min-height: 60px;
		word-break: break-all;
		&--center {
			text-align: center;
			justify-content: center;
		}
		@media(max-width: 600px) {
			border: none;
			font-size: 13px;
			min-height: auto;
			
			&[data-name='date'] {
				grid-area: date;
				padding: 0;
				align-self: center;
				justify-self: start;
			}
			&[data-name='number'] {
				grid-area: number;
				// justify-content: space-around;
				column-gap: 20px;
				display: grid;
				grid-template-columns: 1fr 1fr;
				justify-items: start;
				padding: 0;
				margin-top: 20px;

			}
			&[data-name='method'] {
				grid-area: method;
				// justify-content: space-around;
				display: grid;
				column-gap: 20px;
				grid-template-columns: 1fr 1fr;
				justify-items: start;
				padding: 0;
			}
			&[data-name='summ'] {
				grid-area: summ;
				padding: 4px 10px;
				border: 2px solid $color-base-accent;
				background-color: #d4f5de;
				color: $color-base-accent;
				justify-self: end;
				align-self: start;
				border-radius: 20px;
				font-weight: 600;
				&::before {
					content: '-';
					margin-right: 5px;
				}
			}
			&[data-name='dealsumm'] {
				grid-area: dealsumm;
				// justify-content: space-around;
				display: grid;
				grid-template-columns: 1fr 1fr;
				column-gap: 20px;
				justify-items: start;
				padding: 0;
			}
			&[data-name='company'] {
				grid-area: company;
				justify-content: center;
				border: 1px solid #ececec;
				width: 100%;
				margin-top: 20px;
			}
		}
		p {
			font-size: inherit;
		}
		&-label {
			font-weight: 600;
			text-align: left;
			word-break: keep-all;
			@media(min-width: 426px) {
				display: none;
			}
		}
	}
	&__body-row {
		margin-bottom: 20px;
	}
}
</style>