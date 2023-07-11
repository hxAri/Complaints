
import { createStore } from "vuex";

// Create new Store instance.
const store = createStore({
	
	/*
	 * The data store in Vuex follows the
	 * same rules as the data in a Vue instance.
	 *
	 */
	state: () => ({
		login: {
			level: null,
			session: null
		},
		account: {
			officer: null,
			publics: null
		},
		profile: {
			id: 0,
			nik: null,
			avatar: null,
			callable: null,
			fullname: null,
			username: null,
			usermail: null
		},
		reports: {
			finish: [],
			process: [],
			pending: [],
			commons: []
		}
	}),
	
	/*
	 * Sometimes we may need to compute derived
	 * state based on store state.
	 *
	 */
	getters: {
		
		/*
		 * Return if current login level is Admin.
		 *
		 * @params Object state
		 *
		 * @return Boolean
		 */
		isAdmin: state => state.login.level === "admin",
		
		/*
		 * Return if current login level is Publics.
		 *
		 * @params Object state
		 *
		 * @return Boolean
		 */
		isPublic: state => state.login.level === "publics",
		
		/*
		 * Return if current login level is Officer.
		 *
		 * @params Object state
		 *
		 * @return Boolean
		 */
		isOfficer: state => state.login.level === "officer",
		
		/*
		 * Return if user has logged.
		 *
		 * @params Object state
		 *
		 * @return Boolean
		 */
		logged: state => state.login.session !== null && state.login.level !== null,
		
		login: state => state.login,
		
		/*
		 * Return Admin, Officer, or User profile.
		 *
		 * @params Object state
		 *
		 * @return Object
		 */
		profile: state => state.profile,
		
		/*
		 * Return all reports.
		 *
		 * @params Object state
		 *
		 * @return Object
		 */
		reports: state => state.reports
	},
	
	/*
	 * The only way to actually change state in a
	 * Vuex store is by committing a mutation.
	 *
	 */
	mutations: {
		
		/*
		 * Set user login.
		 *
		 * @params Object state
		 * @params String level
		 * @params String session
		 *
		 * @return Void
		 */
		login: function( state, level, session )
		{
			state.login = {
				level: level,
				session: session
			};
		},
		
		account: function( state, { officer, publics } = {} )
		{
			state.account = {
				officer: officer,
				publics: publics
			};
		},
		
		/*
		 * Set user profile.
		 *
		 * @params Object state
		 * @params Number id
		 * @params String nik
		 * @params String avatar
		 * @params String callable
		 * @params String fullname
		 * @params String username
		 *
		 * @return Void
		 */
		profile: function( state, { id, nik, avatar, callable, fullname, username } = {} )
		{
			state.profile = {
				id: id,
				nik: nik,
				avatar: avatar,
				callable: callable,
				fullname: fullname,
				username: username
			};
		},
		
		/*
		 * Set data reports.
		 *
		 * @params Object state
		 * @params Array finish
		 * @params Array process
		 * @params Array pending
		 * @params Array commons
		 *
		 * @return Void
		 */
		reports: function( state, { finish, process, pending, commons } = {} )
		{
			state.reports = {
				finish: finish,
				process: process,
				pending: pending,
				commons: commons
			};
		}
	}
	
});

export default store;
