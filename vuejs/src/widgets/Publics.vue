
<script>
	
	// Import Widgets
	import Make from "/src/widgets/Make.vue";
	import Profile from "/src/widgets/Profile.vue";
	import Report from "/src/widgets/Report.vue";
	import Sidebar from "/src/widgets/Sidebar.vue";
	
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
					query: "report-make",
					text: "Make Report",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "report-pending",
					text: "Report Pending",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "report-process",
					text: "Report Process",
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
				},
			]
		}),
		components: {
			Make,
			Profile,
			Report,
			Sidebar
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
				<div class="content-single pd-20" id="report-make" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'report-make' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'report-make' } })">Make Report</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Make />
				</div>
				<div class="content-single pd-20" id="report-pending" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'report-pending' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'report-pending' } })">Report Pending</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Report :data="$store.state.reports.pending" />
				</div>
				<div class="content-single pd-20" id="report-process" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'report-process' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'report-process' } })">Report Process</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Report :data="$store.state.reports.process" />
				</div>
				<div class="content-single pd-20" id="report-finish" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'report-finish' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'report-finish' } })">Report Complete</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Report :data="$store.state.reports.finish" />
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