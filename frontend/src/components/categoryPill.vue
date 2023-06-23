<template functional lang="pug">
	p.pill-category {{props.text}}
</template>

<script>
export default {
	props: ['text']
}
</script>

<style lang="scss" scoped>
.pill-category {
	width: 100%;
	max-width: 164px;
	display: flex;
	padding: 6px 3px;
	padding-left: 7px;
	background: #ececec;
	border-radius: 35px;
	align-items: center;
	font-size: 10px;
	line-height: 14px;
	word-break: break-word;
	&::before {
		content: '';
		@include w-h(12px);
		background: #000;
		border-radius: 50%;
		margin-right: 7px;
		flex-shrink: 0;
	}
	&--products {
		background-color: #d4f5de;
		&::before {
			background: linear-gradient(24deg, #2fc06e, #5fefc0);
		}
	}
	&--kids {
		background-color: #fef5de;
		&::before {
			background: linear-gradient(26deg, #ffbb00, #ffed4e);
		}
	}
	&--cloth {
		background-color: #dffcff;
		&::before {
			background: linear-gradient(26deg, #36f7e3, #00b1ff);
		}
	}
	&--furniture {
		background-color: #ffe7cf;
		&::before {
			background: linear-gradient(24deg, #ff6a33, #ffdd57);
		}
	}
	&--farm {
		background-color: #f3fff1;
		&::before {
			background: linear-gradient(26deg, #34a70b, #3aff00);
		}
	}
	&--arc {
		background-color: #feffec;
		&::before {
			background: linear-gradient(24deg, #fff830, #ffffe2);
		}
	}
	&--build {
		background-color: #ffefef;
		&::before {
			background: linear-gradient(26deg, #c81111, #ff7878);
		}
	}
	&--general {
		background-color: #f3faf3;
		&::before {
			background: linear-gradient(26deg, #4d8b56, #b1ffc0);
		}
	}
	&--transport {
		background-color: #ffe8ea;
		&::before {
			background: linear-gradient(26deg, #f7366b, #fd7b88);
		}
	}
	&--events {
		background-color: #fff2fd;
		&::before {
			background: linear-gradient(26deg, #43ecec, #fd7bfd);
		}
	}
	&--services {
		background-color: #eafbfd;
		&::before {
			background: linear-gradient(26deg, #43ecec, #fd7bfd);
		}
	}
	&--tobacco {
		background-color: #fbf2ff;
		&::before {
			background: linear-gradient(26deg, #6443ec, #fd7bc5);
		}
	}
	&--others {
		background-color: #efffee;
		&::before {
			background: linear-gradient(26deg, #a3ec43, #f0fd7b);
		}
	}
}
</style>