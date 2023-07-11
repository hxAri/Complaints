
<script>
	
	// Import Scripts
	import Response from "/src/widgets/Response.vue";

	export default {
		data: () => ({
			active: null
		}),
		props: {
			data: {
				require: true
			}
		},
		methods: {
			shortText: text => text.length >= 110 ? text.substring( 0, 110 ) + "..." : text
		},
		components: {
			Response
		}
	};
	
</script>

<template>
	<div class="template">
		<div :class="[ 'modal', 'modal', 'flex', 'flex-center', active ? 'active' : '' ]">
			<div class="modal-exit" @click="active = null"></div>
			<div :class="[ 'modal-main', 'rd-square', active ? 'active' : '' ]">
				<Response :report="active" v-if="active" :allow="false" />
			</div>
		</div>
		<div class="reports" v-if="( data && data.length )">
			<div class="report rd-square" v-for="report in data" v-scroll-reveal="{ delay: 700 }" @click="active = report">
				<div class="report-body">
					<div class="report-avatar avatar-wrapper flex flex-center">
						<img class="avatar-image lazy" :data-src="report.picture" v-lazyload />
						<div class="avatar-cover"></div>
					</div>
					<div class="report-id pd-14">
						<p class="text">ID <span class="sub-title">{{ report.id }}</span> | Date <span class="sub-title">{{ report.date }}</span></p>
					</div>
				</div>
				<div class="report-contents pd-14">
					<p class="text">{{ shortText( report.contents ?? "" ) }}</p>
				</div>
			</div>
		</div>
		<div class="" v-else>
			<p class="text">There is no complaint report data.</p>
		</div>
	</div>
</template>

<style scoped>

	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Reports Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.modal {
		left: 0;
		bottom: -100%;
		z-index: 999999;
		width: 100%;
		height: 100vh;
		position: fixed;
		background: rgba( 0, 0, 0, .6 );
	}
	.modal.active {
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
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Reports Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.reports {
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
	@media (max-width: 750px) {
		.reports {
			grid-template-columns: repeat( 1, 1fr );
		}
			.report-body {
				height: 350px;
			}
	}
	
</style>