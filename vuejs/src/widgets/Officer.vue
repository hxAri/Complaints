
<script>
	
	// Import Widgets
	import Profile from "/src/widgets/Profile.vue";
	import Report from "/src/widgets/Report.vue";
	import Sidebar from "/src/widgets/Sidebar.vue";
	import Validate from "/src/widgets/Validate.vue";
	import Verify from "/src/widgets/Verify.vue";
	
	export default {
		data: () => ({
			routes: [
				{
					query: "profile",
					text: "Profile",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "verify-report",
					text: "Verify Report",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "validate-report",
					text: "Validate Report",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "report-finish",
					text: "Report Complete",
					icon: {
						active: [],
						default: []
					}
				}
			]
		}),
		components: {
			Profile,
			Report,
			Sidebar,
			Validate,
			Verify
		}
	};
	
</script>

<template>
	<div class="public flex">
		<Sidebar :routes="routes" />
		<div class="contents">
			<div class="contents-wrapper">
				<div class="content-single pd-20" id="profile" v-scroll-reveal="{ delay: 700 }" v-if="( $route.query.tab === 'profile' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'profile' } })">Profile</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Profile />
				</div>
				<div class="content-single pd-20" id="verify-report" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'verify-report' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'verify-report' } })">Verify Report</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Verify />
				</div>
				<div class="content-single pd-20" id="validate-report" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'validate-report' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'validate-report' } })">Validate Report</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Validate />
				</div>
				<div class="content-single pd-20" id="report-finish" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'report-finish' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'report-finish' } })">Report Complete</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Report :data="$store.state.reports.commons" />
				</div>
				<div class="content-single pd-20 flex flex-center main" v-scroll-reveal="{ delay: 700 }" v-else>
					<div id="main">
						<h1 class="title fb-55">Welcome To</h1>
						<h1 class="title fb-55">The Board</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Publics Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.public {
	}
	@media (max-width: 750px) {
		.public {
			display: block;
		}
	}
		.contents {
			width: 70%;
			height: auto;
		}
		@media (max-width: 750px) {
			.contents {
				width: 100%;
			}
			.contents-wrapper {
				padding: 0;
			}
		}
			.content-single {
				background: var(--background-2);
			}
			.content-single.main {
				width: 100%;
				height: 30vh;
				background: none;
				border: 0;
			}
			@media (max-width: 750px) {
				.content-single {
					border: 0;
					border-radius: 0;
				}
				.content-single.main {
					height: 50vh;
				}
			}
				.content-single.main #main {
					text-align: center;
					text-transform: uppercase;
				}
				.content-single .horizontal {
					width: 100%;
				}
	
</style>