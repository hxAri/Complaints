
<script>
	
	export default {
		data: () => ({
			response: null
		}),
		props: {
			allow: {
				type: Boolean
			},
			report: {
				type: Object,
				require: true
			}
		}
	};
	
</script>

<template>
	<div class="template flex scroll-hidden">
		<div class="report">
			<div class="report-header pd-14 flex flex-left">
				<div class="report-header-avatar avatar-wrapper flex flex-center rd-circle mg-right-14">
					<img class="avatar-image lazy" :data-src="report.complainer.avatar" v-lazyload />
					<div class="avatar-cover"></div>
				</div>
				<p class="title fb-45">{{ report.complainer.fullname }}</p>
			</div>
			<div class="report-body">
				<div class="report-body-avatar avatar-wrapper flex flex-center">
					<img class="avatar-image lazy" :data-src="report.picture" v-lazyload />
					<div class="avatar-cover"></div>
				</div>
				<div class="report-body-label pd-14">
					<p class="text fb-35">ID <span class="sub-title">{{ report.id }}</span> | Date <span class="sub-title">{{ report.date }}</span></p>
				</div>
			</div>
		</div>
		<div class="response scroll-hidden">
			<div class="response-text pd-14">
				<p :class="[ 'text', text.length ? 'mg-bottom-14 mg-lc-bottom' : '' ]" v-for="text in report.contents.split( '\n' )">{{ text }}</p>
				<form class="response-form form pd-0 mg-0" method="POST" action="/insert/response" v-if="allow">
					<input class="" type="hidden" name="id-report" :value="report.id" />
					<input class="" type="hidden" name="id-officer" :value="$store.state.profile.id" />
					<div class="form-group flex flex-left mg-bottom-6">
						<label class="form-label" for="response">Give Feedback</label>
						<textarea class="reponse-form-texta form-input texta" name="response" v-model="response" required></textarea>
					</div>
					<div class="form-group">
						<button class="response-form-button button form-input submit">
							Send Feedback
						</button>
					</div>
				</form>
				<div class="response-officer rd-square" v-else-if="report.response">
					<div class="response-officer-header pd-14 flex flex-left">
						<div class="response-officer-header-avatar avatar-wrapper flex flex-center rd-circle mg-right-14">
							<img class="avatar-image lazy" :data-src="report.response.officer.avatar" v-lazyload />
							<div class="avatar-cover"></div>
						</div>
						<p class="title fb-45">{{ report.response.officer.fullname }}</p>
					</div>
					<div class="response-officer-text pd-14">
						<p :class="[ 'text', text.length ? 'mg-bottom-14 mg-lc-bottom' : '' ]" v-for="text in report.response.response.split( '\n' )">{{ text }}</p>
					</div>
				</div>
				<div class="" v-else>
					<p class="text">There is no validation from the officer</p>
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped>

	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Template Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.template {
		height: 100%;
	}
	@media (max-width: 750px) {
		.template {
			display: block;
			overflow: scroll;
		}
	}

	.response,
	.report {
		height: 100%;
	}
	@media (max-width: 750px) {
		.response,
		.report {
			height: auto;
		}
	}

	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Report Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.report {
		width: 55%;
		border-right: 1px solid var(--border-1);
	}
		@media (max-width: 750px) {
			.report {
				width: 100%;
				border: 0;
				position: static;
			}
		}
		.report-header {
			top: 0;
			z-index: 1;
			position: -webkit-sticky;
			position: sticky;
			background: var(--background-1);
		}
		.report-body {
			width: 100%;
			height: 495px;
			position: relative;
		}
		@media (max-width: 750px) {
			.report-body {
				height: 350px;
			}
		}
			.report-body-avatar {
				width: 100%;
				height: 100%;
			}
			.report-body-label {
				width: 100%;
				height: auto;
				bottom: 0;
				background: rgba(166,166,237,.2);
				position: absolute;
			}
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Response Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.response {
		width: 45%;
		position: relative;
		overflow-x: scroll;
		background: var(--background-1);
	}
		@media (max-width: 750px) {
			.response {
				width: 100%;
				height: 30%;
				overflow-x: visible;
			}
		}
		.response-text,
		.response-form {
			background: var(--background-1);
		}
			.reponse-form-texta {
				height: 150px;
			}
			.response-form-button.button {
				color: #ffffff;
				background: #007bff;
				border-color: #007bff;
			}
		.response-officer {
			border: 1px solid var(--border-2);
		}
			.response-officer-header {
				border-bottom: 1px solid var(--border-2);
			}
			.response-officer-text {
				background: var(--background-2);
			}
	
</style>