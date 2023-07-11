
<script>
	
	import { RouterLink } from "vue-router";
	
	// Import Scripts
	import Choice from "/src/scripts/Choice.js";
	
	export default {
		data: () => ({
			image: Choice([
				"https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/animes/1679790473;8awC2VZFr2.png",
				"https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/animes/1679790488;e8vB3VRArc.png",
				"https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/animes/1679790502;aeklVNfU.8.png",
				"https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/animes/1679790519;23ctpzKlx8.png",
				"https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/animes/1679790537;b2MtUlRvVA.png",
				"https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/animes/1679790638;7bJ3k6IQYK.png"
			]),
			models: [
				{
					name: "username",
					type: "text",
					label: "Username",
					pattern: "[a-z_\x80-\xff][a-z0-9_\x80-\xff]*",
					value: null
				},
				{
					name: "password",
					type: "password",
					label: "Password",
					pattern: null,
					value: null
				},
			],
			trigger: {
				type: null,
				text: null
			}
		}),
		created: function()
		{
			this.trigger.type = this.$route.query.trigger ?? null;
			this.trigger.text = this.$route.query.text ?? null;
		},
		mounted: function()
		{
			this.image = { backgroundImage: `url(${this.image})` };
		}
	};
	
</script>

<template>
	<div class="template">
		<div class="alert" v-if="( trigger.text && trigger.type )">
			<div class="alert-group">
				<div :class="[ 'alert-single', 'flex', 'flex-left', trigger.type ]">
					<div class="alert-slot">
						{{ trigger.text }}
					</div>
					<button class="alert-close flex flex-center" @click="[ trigger.text = null, trigger.type = null ]">
						<i class="bx bx-x"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="signin flex flex-center">
			<div class="signin-wrapper flex rd-square">
				<div class="signin-info" :style="image">
					<div class="signin-cover"></div>
				</div>
				<div class="signin-action flex flex-center">
					<div class="signin-action-block">
						<div class="mg-bottom-14">
							<h4 class="title">SIGNIN</h4>
							<p class="text">Please enter your username & password</p>
						</div>
						<form class="signin-form" method="POST" action="signin">
							<div class="form-group flex flex-left" v-for="model in models">
								<label class="form-label" :for="model.name">{{ model.label }}</label>
								<input class="form-input" :name="model.name" :type="model.type" :ref="model.name" v-model="model.value" :pattern="model.pattern" required />
							</div>
							<input class="" name="signin" type="hidden" value="publics" />
							<p class="text">SignIn as officer? <RouterLink to="/signin/officer">Here</RouterLink></p>
							<div class="form-group">
								<button class="button form-input form-submit">
									SignIn
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * signin Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.signin {
		width: 100vw;
		height: 730px;
	}
		.signin-wrapper {
			width: 85%;
			height: 80%;
			overflow: hidden;
			background: var(--background-1);
			box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
		}
			.signin-info,
			.signin-action {
				width: 50%;
				height: 100%;
			}
			.signin-info {
				background-color: var(--background-2);
				background-position: bottom;
				background-size: cover;
				border-radius: 3px 0px 0px 3px;
				position: relative;
			}
				.signin-cover {
					width: 100%;
					height: 100%;
					background: rgba(0,0,0,.6);
				}
		.signin-action {
			background: var(--background-1);
		}
	@media (max-width: 750px) {
		.signin {
			height: auto;
			display: block;
		}
			.signin-wrapper {
				width: 100%;
				height: auto;
				display: block;
				box-shadow: none;
				border-radius: 0;
			}
				.signin-info {
					display: none;
				}
				.signin-action {
					width: 100%;
					height: auto;
				}
				.signin-action {
					padding-top: 24px;
					padding-bottom: 24px;
				}
					.signin-action-block {
						height: 90%;
					}
	}
	
</style>