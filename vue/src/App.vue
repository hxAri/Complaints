
<script>
	
	import { RouterView } from "vue-router";
	
	export default {
		data: () => ({
			date: new Date(),
			tabs: []
		}),
		mounted: function()
		{
			try
			{
				var json = document.getElementById( "data" );
					json = JSON.parse( json.textContent );
				this.$store.commit( "login", json.login.level, json.login.session );
				this.$store.commit( "account", json.account );
				this.$store.commit( "profile", json.profile );
				this.$store.commit( "reports", json.reports );
			}
			catch( error )
			{}
			
			// Create menu tabs
			var tabs = [
				{ path: "/", inner: "Home" },
				{ path: "/signin", inner: "Signin", auth: false },
				{ path: "/signup", inner: "Signup", auth: false },
				{ path: "/report", inner: "Reports" }
			];
			
			// Mapping tabs.
			for( let i in tabs )
			{
				// If tab has defined auth property.
				if( typeof tabs[i].auth !== "undefined" )
				{
					// If tab must be authenticated.
					if( tabs[i].auth )
					{
						// If user has authenticated.
						if( this.$store.getters.logged )
						{
							this.tabs.push( tabs[i] );
						}
					}
					else {
						
						// If user has no authenticated.
						if( this.$store.getters.logged === false )
						{
							this.tabs.push( tabs[i] );
						}
					}
				}
				else {
					this.tabs.push( tabs[i] );
				}
			}
		}
	};
	
</script>

<template>
	<header class="header">
		<div class="header-banner flex flex-right scroll-hidden">
			<div :class="[ 'tab', 'text', $route.path === tab.path ? 'active' : '' ]" @click="$router.push({ path: tab.path })" v-for="tab in tabs">
				<div class="tab-content flex flex-center pd-left-14 pd-right-14">
					{{ tab.inner }}
				</div>
			</div>
		</div>
	</header>
	<div class="breakr"></div>
	<main class="main">
		<RouterView />
	</main>
	<footer class="footer flex flex-center">
		<div class="footer-wrapper">
			<div class="footer-single">
				<p class="title">&copy Ari Setiawan (hxAri) - {{ date.getFullYear().toString() }}</p>
			</div>
		</div>
	</footer>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Header Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.header {
		top: 0;
		width: 100%;
		z-index: 999;
		position: fixed;
		background: var(--background-1);
		box-shadow: 0 2px 1.5px rgba(0,0,0,.1);
	}
		.header-banner {
			width: 100%;
			overflow-y: scroll;
			position: relative;
		}
		@media (max-width: 750px) {
			.header-banner {
				justify-content: left;
			}
		}
			.tab {
				background: var(--background-1);
			}
				.tab-content {
					width: auto;
					height: 68px;
				}
				.tab.active .tab-content {
					color: var(--color-1);
				}
	.breakr {
		width: 100%;
		height: 69px;
	}
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Footer Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.footer {
		color: #e5e5e5;
		background: #282d32;
		flex-direction: column;
	}
		.footer .title {
			color: #ffffff;
		}
		.footer-wrapper {
			width: 71.4%;
			margin: auto;
			margin-top: 140px;
			margin-bottom: 140px;
		}
			.footer-single {
				color: #ffffff;
				padding: 14px;
				text-align: center;
			}
	@media (max-width: 750px) {
		.footer {
			flex-direction: column;
		}
			.footer-wrapper {
				width: 94%;
				margin: 0;
				margin-top: 80px;
				margin-bottom: 80px;
			}
	}
	
</style>