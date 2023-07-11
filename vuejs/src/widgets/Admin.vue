
<script>
	
	// Import Widgets
	import Profile from "/src/widgets/Profile.vue";
	import Report from "/src/widgets/Report.vue";
	import Sidebar from "/src/widgets/Sidebar.vue";
	import Users from "/src/widgets/Users.vue";
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
					text: "Report Completed",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "publics",
					text: "Society List",
					icon: {
						active: [],
						default: []
					}
				},
				{
					query: "officer",
					text: "Officer List",
					icon: {
						active: [],
						default: []
					}
				}
			],
			sidebar: false,
			officer: [
				{
					name: "fullname",
					type: "text",
					label: "Fullname",
					pattern: null,
					value: null
				},
				{
					name: "username",
					type: "text",
					label: "Username",
					pattern: "[a-z_\x80-\xff][a-z0-9_\x80-\xff]*",
					value: null
				},
				{
					name: "callable",
					type: "text",
					label: "Phone",
					pattern: "(\\+{0,1}(0|62)){0,1}([0-9]{4})-*([0-9]{4})-*([0-9]{3,4})",
					value: null
				},
				{
					name: "password",
					type: "password",
					label: "Password",
					pattern: null,
					value: null
				}
			]
		}),
		components: {
			Profile,
			Report,
			Sidebar,
			Users,
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
				<div class="content-single pd-20" id="publics" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'publics' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'publics' } })">Society List</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<Users action="/delete/publics" :users="$store.state.account.publics" />
				</div>
				<div class="content-single pd-20" id="officer" v-scroll-reveal="{ delay: 700 }" v-else-if="( $route.query.tab === 'officer' )">
					<h2 class="title" @click="$router.push({ query: { tab: 'officer' } })">Officer List</h2>
					<hr class="horizontal mg-top-14 mg-bottom-14" />
					<div class="officer-relative">
						<Users :class="[ 'officer-display', sidebar === false ? 'active' : '' ]" action="/delete/officer" :users="$store.state.account.officer"/>
						<button class="officer-button-add button pd-14 rd-square mg-top-14" @click="sidebar = 'active'">
							Add New Officer
						</button>
						<div :class="[ 'officer-sidebar', sidebar ]">
							<div class="officer-sidebar-exit" @click="sidebar = false"></div>
							<div :class="[ 'officer-sidebar-main', sidebar ]">
								<div class="officer-sidebar-header flex flex-left pd-14">
									<i class="bx bxs-chevrons-left fs-20" @click="sidebar = false"></i>
								</div>
								<form class="officer-form pd-14" method="POST" action="/insert/officer">
									<div class="form-group flex flex-left" v-for="model in officer">
										<label class="form-label" :for="model.name">{{ model.label }}</label>
										<input class="form-input" :name="model.name" :type="model.type" :ref="model.name" v-model="model.value" :pattern="model.pattern" required />
									</div>
									<div class="form-group">
										<button class="button form-input form-submit">
											Save Officer
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
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
				.officer-relative {
					width: 100%;
					height: auto;
					overflow: hidden;
					position: relative;
				}
					.officer-display {
						opacity: 0;
						height: 592px;
						max-height: fit-content;
						transition: all .3s;
					}
					@media (max-width: 750px) {
						.officer-display {
							height: 340px;
						}
					}
					.officer-display.active {
						opacity: 1;
						height: auto;
						max-height: 450px;
					}
					.officer-button-add.button {
						width: 40%;
						color: #ffffff;
						background: #8490ff;
					}
					@media (max-width: 750px) {
						.officer-button-add.button {
							width: 50%;
						}
					}
					.officer-sidebar,
					.officer-sidebar-main {
						top: 0;
						opacity: 0;
						right: -100%;
						z-index: 1;
						width: 100%;
						height: 100%;
						overflow: hidden;
						position: absolute;
						background: rgba( 0, 0, 0, .6 );
					}
					.officer-sidebar.active,
					.officer-sidebar-main.active {
						transition: opacity .3s;
						right: 0 !Important;
						opacity: 1;
					}
						.officer-sidebar-exit {
							width: 100%;
							height: 100%;
						}
						.officer-sidebar-main {
							width: 60%;
							opacity: 1;
							transition: all .3s;
							background: var(--background-1);
						}
						@media (max-width: 750px) {
							.officer-sidebar-main {
								width: 100%;
							}
						}
							.officer-sidebar-header {
								background: var(--background-1);
								border-bottom: 1px solid var(--border-2);
							}
							.officer-form .button {
								width: 50%;
								background: #007bff;
							}
	
</style>