
<script>
	
	export default {
		data: () => ({
			picture: null,
			changed: false,
			dropdown: false,
			avatar: {
				admin: "/dist/img/1681439839;f7WYVV7.mG.png",
				officer: "/dist/img/1681439839;ddLgSJGhL..png",
				publics: "/dist/img/1681439839;68jqGs2jcp.png"
			}
		}),
		props: {
			routes: {
				type: Array,
				require: true
			}
		},
		created: function()
		{
			this.picture = this.$store.state.profile.avatar;
		},
		methods: {
			display: function()
			{
				this.dropdown = this.dropdown ? false : "active";
				this.picture = this.$store.state.profile.avatar;
				this.changed = false;
				this.reset();
			},
			handle: function( e )
			{
				this.picture = URL.createObjectURL( e.target.files[0] );
				this.changed = true;
			},
			remove: function()
			{
				if( this.$refs.file.files.length )
				{
					this.reset();
				}
				this.picture = this.avatar[this.$store.state.login.level];
				this.changed = true;
			},
			reset: function()
			{
				this.$refs.file.value = null;
			}
		}
	};
	
</script>

<template>
	<div class="sidebar">
		<div class="sidebar-wrapper">
			<div class="sidebar-common">
				<div class="sidebar-picture flex flex-center rd-circle" v-scroll-reveal="{ delay: 700 }">
					<div class="sidebar-picture-border flex flex-center rd-circle">
						<div class="sidebar-picture-spaces flex flex-center rd-circle">
							<div class="avatar flex flex-center sidebar-avatar">
								<div class="avatar-wrapper flex flex-center sidebar-avatar-wrapper rd-circle">
									<div class="sidebar-avatar-hidden rd-circle flex flex-center">
										<img class="avatar-image" :title="$store.state.profile.fullname" :alt="$store.state.profile.fullname + '(' + $store.state.profile.username + ')'" :src="picture" v-if="changed" />
										<img class="avatar-image lazy" :title="$store.state.profile.fullname" :alt="$store.state.profile.fullname + '(' + $store.state.profile.username + ')'" :data-src="picture" v-lazyload v-else />
									</div>
									<div class="avatar-cover flex flex-center">
										<div class="sidebar-dropdown" v-if="( $route.query.tab === 'profile' )">
											<button class="sidebar-dropdown-button button flex flex-center rd-circle" @click="display">
												<i :class="[ 'bx', dropdown ? 'bx-x' : 'bxs-camera', 'fs-20' ]"></i>
											</button>
											<div :class="[ 'sidebar-dropdown-display', dropdown ]">
												<form class="sidebar-form pd-top-14" method="POST" action="/update/profile" enctype="multipart/form-data">
													<input class="form-input file" name="avatar-name" type="hidden" v-model="picture" required />
													<div class="sidebar-form-group flex flex-center rd-circle mg-bottom-14">
														<input class="form-input file" name="avatar-file" type="file" accept="image/*" @change="handle" ref="file" />
														<i class="bx bxs-cloud-upload fs-20"></i>
													</div>
													<div class="sidebar-form-group flex flex-center rd-circle mg-bottom-14" @click="remove" v-if="( picture !== avatar[$store.state.login.level] )">
														<i class="bx bxs-trash fs-20"></i>
													</div>
													<div class="sidebar-form-group flex flex-center rd-circle" v-if="changed">
														<button class="button flex flex-center">
															<i class="bx bx-check-double fs-20"></i>
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="sidebar-common-info mg-top-20" v-scroll-reveal="{ delay: 700 }">
					<p class="title fs-20 fb-45 mg-0 fullname">{{ $store.state.profile.fullname }}</p>
					<p class="text fs-14 fb-35 mg-0 biography">{{ $store.state.login.level }}</p>
				</div>
			</div>
			<div class="sidebar-about pd-20" v-scroll-reveal="{ delay: 700 }">
				<a href="/logout">
					<button class="button button-logout mg-bottom-14 pd-14">
						<span class="title fb-45">Logout</span>
					</button>
				</a>
				<div class="sidebar-routes">
					<div class="sidebar-tabs">
						<div :class="[ 'sidebar-tab', $route.query.tab  === route.query ? 'active' : '' ]" @click="$router.push({ query: { tab : route.query } })" v-for="route in routes">
							<div class="sidebar-tab-inner flex flex-left pd-14" v-scroll-reveal="{ delay: 700 }">
								{{ route.text }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Sidebar Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.sidebar {
		width: 30%;
		height: auto;
		background: var(--background-3);
	}
	@media (max-width: 750px) {
		.sidebar {
			width: 100%;
			background: var(--background-1);
		}
	}
		.sidebar-wrapper{
			width: 100%;
			height: fit-content;
			/*
			top: 0;
			z-index: 99999;
			position: -webkit-sticky;
			position: sticky;
			*/
			background: var(--background-1);
			border-right: 1px solid var(--border-4);
		}
		@media (max-width: 750px) {
			.sidebar-wrapper {
				position: static;
			}
		}
			.sidebar-common {
				padding: 20px;
				padding-bottom: 0;
			}
				.sidebar-picture-border {
					padding: 3px;
					background: linear-gradient( 
						95deg, 
						rgba(210,209,236,1), 
						rgba(231,239,255,0.9761015635270339)
					);
				}
					.sidebar-picture-spaces {
						padding: 3px;
						background: var(--background-1);
					}
						.sidebar-avatar-wrapper {
							width: 245px;
							height: 245px;
							overflow: visible;
						}
							.sidebar-avatar-hidden {
								width: inherit;
								height: inherit;
								overflow: hidden;
							}
							.sidebar-dropdown {
								right: -20px;
								z-index: 9;
								width: 40px;
								height: auto;
								position: absolute;
							}
								.sidebar-dropdown-button,
								.sidebar-form-group {
									width: 40px;
									height: 40px;
									border: 0;
									background: var(--background-4);
									position: relative;
								}
								.sidebar-dropdown-display {
									height: 0;
									max-height: 0;
									overflow: hidden;
									transition: all .3s ease-in-out;
								}
								.sidebar-dropdown-display.active {
									height: auto;
									max-height: 162px;
									overflow: visible;
								}
									.form-input.file {
										position: absolute;
										top: 0;
										left: 0;
										width: 100%;
										height: 100%;
										opacity: 0;
										cursor: pointer;
									}
									.form-input.file::-webkit-file-upload-button {
										visibility: hidden;
									}
									.form-input.file::before {
										content: 'Choose File';
										display: inline-block;
										background-color: #007bff;
										color: #fff;
										padding: 0.5rem 1rem;
										border-radius: 0.25rem;
										cursor: pointer;
									}
									.form-input.file:hover::before {
										background-color: #0062cc;
									}
									.form-input.file:focus::before {
										outline: none;
										box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
									}
									.sidebar-form-group .button {
										border: 0;
										background: none;
									}
				.sidebar-common-info {
					text-align: center;
					text-transform: capitalize;
				}
				.button-logout {
					width: 100%;
					background: var(--background-3);
				}
				.sidebar-tab {
					background: var(--background-1);
					border-top: 1px solid var(--border-2);
				}
				.sidebar-tab.active {
					background: var(--background-2);
				}
				.sidebar-tab:last-child {
					border-bottom: 1px solid var(--border-2);
				}
					.sidebar-tab-inner {
						width: 100%;
						color: var(--color-2);
					}
					.sidebar-tab-inner:hover {
						background: var(--background-3);
					}
					.sidebar-tab.active .sidebar-tab-inner {
						color: var(--color-1);
					}
	
</style>