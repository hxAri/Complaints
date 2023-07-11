
<script>
	
	// Import Widgets
	import Report from "/src/widgets/Report.vue";
	
	export default {
		data: () => ({
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
		components: {
			Report
		}
	};
	
</script>

<template>
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
	<div class="report flex flex-center">
		<div class="report-wrapper">
			<div class="report-group pd-14">
				<div class="report-single pd-14 rd-square" v-scroll-reveal="{ delay: 700 }">
					<h3 class="title">REPORT COMPLETE</h3>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<p class="text mg-bottom-14">The following is a list of reports that have been processed and verified by officers who were reported by the public</p>
					<Report :data="$store.state.reports.commons" />
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Report Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.report {
		width: 100%;
		height: auto;
	}
	@media (max-width: 750px) {
		.report {
			display: block;
		}
	}
		.report-wrapper {
			width: 70%;
			height: auto;
		}
		@media (max-width: 750px) {
			.report-wrapper {
				width: 100%;
			}
		}
			.report-group {
				background: var(--background-2);
			}
			@media (max-width: 750px) {
				.report-group {
					padding: 0;
					border: 0;
					border-radius: 0;
				}
			}
				.report-single {
					background: var(--background-1);
				}
					.report-single .horizontal {
						width: 100%;
					}
	
</style>