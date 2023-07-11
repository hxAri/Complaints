
<script>

	// Import Scripts
	import Response from "/src/widgets/Response.vue";

	export default {
		data: () => ({
			active: null
		}),
		components: {
			Response
		}
	};

</script>

<template>
	<div class="validate">
		<div :class="[ 'validate-modal', 'modal', 'flex', 'flex-center', active ? 'active' : '' ]">
			<div class="modal-exit" @click="active = null"></div>
			<div :class="[ 'modal-main', 'rd-square', active ? 'active' : '' ]">
				<Response :report="active" v-if="active" :allow="true" />
			</div>
		</div>
		<div class="validate-reports" v-if="( $store.state.reports.process && $store.state.reports.process.length )">
			<div class="report rd-square" v-for="report in $store.state.reports.process" v-scroll-reveal="{ delay: 700 }">
				<div class="report-body">
					<div class="report-avatar avatar-wrapper flex flex-center">
						<img class="avatar-image lazy" :data-src="report.picture" v-lazyload />
						<div class="avatar-cover"></div>
					</div>
					<div class="report-id pd-14">
						<p class="text fb-35">ID <span class="sub-title">{{ report.id }}</span> | Date <span class="sub-title">{{ report.date }}</span></p>
					</div>
				</div>
				<div class="report-contents pd-14">
					<button class="report-validate-button button pd-12 rd-square" @click="active = report">
						Validate Report
					</button>
				</div>
			</div>
		</div>
		<div class="validate-reports" v-else>
			There are no reports to validate.
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Validate Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.validate {
	}
		.validate-modal.modal {
			left: 0;
			bottom: -100%;
			z-index: 999999;
			width: 100%;
			height: 100vh;
			position: fixed;
			background: rgba( 0, 0, 0, .6 );
		}
		.validate-modal.active.modal {
			bottom: 0 !important;
		}
			.modal-exit {
				width: 100%;
				height: 100%;
				position: absolute;
			}
			.modal-main {
				bottom: -100%;
				z-index: 999999;
				width: 70vw;
				height: 90vh;
				overflow: hidden;
				border-radius: 7px;
				position: fixed;
				transition: all .3s;
				background: var(--background-2);
				border: 1px solid var(--border-1);
			}
			.modal-main.active {
				bottom: 5% !important;
			}
			@media (max-width: 750px) {
				.modal-main {
					width: 90vw;
					height: 79.4vh;
					border-bottom: 0;
					border-radius: 7px 7px 0 0;
				}
				.modal-main.active {
					bottom: 0 !Important;
				}
			}
		.validate-reports {
			display: grid;
			height: auto;
			gap: 14px;
			grid-template-columns: repeat( 2, 1fr );
		}
			.report {
				width: 100%;
				height: auto;
				overflow: hidden;
				transition: border .3s;
				border: 1px solid var(--border-1);
			}
			.report:hover {
				border-color: var(--border-2);
			}
				.report-body {
					width: auto;
					height: 300px;
					position: relative;
					background: var(--background-2);
				}
					.report-avatar.avatar-wrapper {
						width: auto;
						height: 100%;
					}
					.report-id {
						width: 100%;
						height: auto;
						bottom: 0;
						background: rgba(166,166,237,.2);
						position: absolute;
					}
				.report-contents {
					height: 100%;
					background: var(--background-1);
				}
					.report-contents .report-validate-button.button {
						width: 100%;
						color: #ffffff;
						background: #87cbb9;
					}
		@media (max-width: 750px) {
			.validate-reports {
				grid-template-columns: repeat( 1, 1fr );
			}
				.report-body {
					height: 350px;
				}
		}
	
</style>