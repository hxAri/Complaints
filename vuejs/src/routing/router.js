
import { createRouter, createWebHistory } from "vue-router";

// Import Stores
import Store from "/src/stores/store.js";

// Import Views
import Home from "/src/views/Home.vue";
import None from "/src/views/None.vue";
import Reports from "/src/views/Reports.vue";
import Signin from "/src/views/Signin.vue";
import SigninOfficer from "/src/views/SigninOfficer.vue";
import Signup from "/src/views/Signup.vue";

// The router instance.
const router = createRouter({
	
	// Router history mode.
	history: createWebHistory( import.meta.env.BASE_URL ),
	
	// Define some routes.
	// Each route should map to a component.
	routes: [
		{
			path: "/",
			name: "home",
			component: Home
		},
		{
			path: "/report",
			name: "report",
			meta: {
				auth: false
			},
			component: Reports
		},
		{
			path: "/signin",
			name: "signin",
			meta: {
				auth: false
			},
			component: Signin
		},
		{
			path: "/signin/officer",
			name: "signin-officer",
			meta: {
				auth: false
			},
			component: SigninOfficer
		},
		{
			path: "/signup",
			name: "signup",
			meta: {
				auth: false
			},
			component: Signup
		},
		{
			path: "/:none(.*?)*",
			name: "none",
			component: None
		}
	],
	
	/*
	 * Guards may be resolved asynchronously,
	 * and the navigation is considered pending
	 * before all hooks have been resolved.
	 *
	 * @params Object to
	 * @params Object from
	 * @params Function next
	 *
	 * @return Mixed
	 */
	beforeEach: async function( to, from, next )
	{
		// Check if route have meta.
		if( to.meta )
		{
			// Check if user is not logged.
			if( to.name !== "signin" &&
				to.name !== "signup" && 
				to.meta.auth && 
				Store.getters.logged !== true )
			{
				return({
					name: "signin"
				});
			}
		}
	},
	
	/*
	 * Scroll Behavior.
	 *
	 * @params Mixed to
	 * @params Mixed from
	 * @params Mixed save
	 *
	 * @return Mixed
	 */
	scrollBehavior: function( to, from, save )
	{
		// If target has hash.
		if( to.hash )
		{
			return({
				el: to.hash,
				behavior: "smooth"
			});
		}
		
		// If target has query tab.
		else if( to.query.tab )
		{
			return({
				el: to.query.tab,
				behavior: "smooth"
			});
		}
		else {
			
			// If previous position is available.
			if( save )
			{
				return( save );
			}
		}
		return({
			top: 0,
			behavior: "smooth"
		});
	}
});

export default router;