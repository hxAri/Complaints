
<script>
	
	// Import Widgets
	import Admin from "/src/widgets/Admin.vue";
	import Officer from "/src/widgets/Officer.vue";
	import Publics from "/src/widgets/Publics.vue";
	
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
			Admin,
			Officer,
			Publics
		}
	};
	
</script>

<template>
	<div class="home">
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
		<div class="section" v-if="$store.getters.logged">
			<Admin v-if="$store.getters.isAdmin" />
			<Officer v-else-if="$store.getters.isOfficer" />
			<Publics v-else />
		</div>
		<div class="section" v-else>
			<div class="banner">
				<div class="banner-group">
					<div class="banner-album"></div>
					<div class="banner-cover flex flex-center">
						<div class="block">
							<h1 class="title fb-55">Comunity Complaints</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="about flex flex-center">
				<div class="about-wrapper">
					<div class="about-group pd-14">
						<div class="about-single pd-14 mg-bottom-14 rd-square">
							<h3 class="title">Abouts</h3>
							<hr class="horizontal mg-top-14 mg-bottom-14" />
							<p class="text">This website has been created and developed by <a class="sub-title" href="https://hxari.github.io/" target="_blank" rel="noopener noreferrer">Ari Setiawan (hxAri)</a> as a student at Pelita Madani Pringsewu Vocational High School, and this was made as a result of the 2023 Software Engineering Department Skills Competency Test at Pelita Madani Pringsewu Vocational School.</p>
						</div>
						<div class="about-single pd-14 rd-square">
							<h3 class="title">Objective</h3>
							<hr class="horizontal mg-top-14 mg-bottom-14" />
							<p class="text">The purpose of this website is to serve as a forum for complaints for the general public against officers who are authorized to respond to their complaints.</p>
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
	 * Title Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.title {
		text-transform: uppercase;
	}
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Banner Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.banner {
		width: 100vw;
		height: 250px;
		background-color: var(--background-2);
	}
		.banner-group {
			width: auto;
			height: 100%;
			position: relative;
		}
			.banner-album {
				width: 900px;
				height: 100%;
				margin: auto;
				background-color: var(--background-1);
				background-image: url(https://raw.githubusercontent.com/hxAri/hxAri/main/public/images/1677866924;deVw5x2Uzx.png);
				background-position: center;
				background-size: cover;
			}
			.banner-cover {
				top: 0;
				width: 100%;
				height: 100%;
				position: absolute;
				background: rgba(0,0,0,.4);
			}
				.banner-cover .title {
					color: #ffffff;
					text-align: center;
				}
	@media (max-width: 750px) {
		.banner {
			height: 360px;
		}
			.banner-album {
				width: 100%;
			}
	}
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * About Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.about {
	}
	@media (max-width: 750px) {
		.about {
			display: block;
		}
	}
		.about-wrapper {
			width: 70%;
			height: auto;
		}
		@media (max-width: 750px) {
			.about-wrapper {
				width: auto;
			}
		}
			.about-group {
				width: auto;
				height: auto;
			}
				.about-single {
					width: auto;
					border: 1px solid var(--border-2);
					background: var(--background-1);
				}
				.about-single .horizontal {
					width: 100%;
				}
	
</style>