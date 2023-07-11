
<script>

	export default {
		data: () => ({
			models: {
				fullname: null,
				username: null,
				callable: null,
				password: {
					new: null,
					old: null
				}
			}
		}),
		created: function()
		{
			this.models.fullname = this.$store.state.profile.fullname;
			this.models.username = this.$store.state.profile.username;
			this.models.callable = this.$store.state.profile.callable;
		}
	};

</script>

<template>
	<div class="profile">
		<div class="profile-detail">
			<div class="profile-wrapper pd-14 rd-square" v-scroll-reveal="{ delay: 700 }">
				<h5 class="title">Account</h5>
				<div class="form-group flex flex-left" v-if="$store.state.profile.id">
					<label class="form-label" for="id">ID</label>
					<input class="form-input" name="id" type="text" :value="$store.state.profile.id" disabled />
				</div>
				<div class="form-group flex flex-left" v-else>
					<label class="form-label" for="nik">NIK</label>
					<input class="form-input" name="nik" type="text" :value="$store.state.profile.nik" disabled />
				</div>
				<form class="form-account" method="POST" action="/update/profile">
					<div class="form-group flex flex-left">
						<label class="form-label" for="">Fullname</label>
						<input class="form-input" name="fullname" type="text" v-model="models.fullname" required />
					</div>
					<div class="form-group flex flex-left">
						<label class="form-label" for="username">Username</label>
						<input class="form-input" name="username" type="text" v-model="models.username" required />
					</div>
					<div class="form-group flex flex-left mg-bottom-8">
						<label class="form-label" for="callable">Phone</label>
						<input class="form-input" name="callable" type="text" v-model="models.callable" required />
					</div>
					<div class="form-group">
						<button class="button form-input form-submit">
							Save Changed
						</button>
					</div>
				</form>
				<form class="form-account delete" method="POST" action="/delete/account" v-if="( $store.state.login.level !== 'admin' )">
					<input class="" name="id" type="hidden" :value="$store.state.profile.id" v-if="$store.state.profile.id" />
					<input class="" name="nik" type="hidden" :value="$store.state.profile.nik" v-else />
					<div class="form-group">
						<button class="button form-input form-submit">
							Remove Account
						</button>
					</div>
				</form>
			</div>
		</div>
		<div class="profile-security">
			<div class="profile-wrapper pd-14 rd-square" v-scroll-reveal="{ delay: 700 }">
				<h5 class="title mg-bottom-14">Password</h5>
				<form class="form-password" method="POST" action="/update/password">
					<div class="form-group flex flex-left">
						<label class="form-label" for="password-old">Old Password</label>
						<input class="form-input" name="password-old" type="password" v-model="models.password.old" required />
					</div>
					<div class="form-group flex flex-left mg-bottom-8">
						<label class="form-label" for="password-new">New Password</label>
						<input class="form-input" name="password-new" type="password" v-model="models.password.new" required />
					</div>
					<div class="form-group">
						<button class="button form-input form-submit">
						Save Password
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * Profile Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.profile {
		display: grid;
		height: auto;
		gap: 14px;
		grid-template-columns: repeat( 2, 1fr );
	}
		@media (max-width: 750px) {
			.profile {
				grid-template-columns: repeat( 1, 1fr );
			}
		}
		.profile-detail,
		.profile-security {
		}
			.profile-wrapper {
				height: 430px;
				background: var(--background-1);
				border: 1px solid var(--border-2);
			}
			@media (max-width: 750px) {
				.profile-wrapper {
					height: fit-content;
				}
			}
				.form-account.delete .form-submit {
					background: #cd334b;
					border-color: #cd334b;
				}
	
</style>