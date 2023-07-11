
<script>
	
	export default {
		props: {
			users: {
				type: Array,
				require: true
			},
			action: {
				type: String,
				require: true
			}
		}
	};
	
</script>

<template>
	<div class="users">
		<div class="users-lists" v-if="( users && users.length )">
			<p class="sub-title mg-bottom-14">Length {{ users.length }}</p>
			<div class="users-groups">
				<div class="user mg-bottom-14 mg-lc-bottom rd-square" v-for="user in users">
					<div class="user-wrapper flex flex-left pd-14" v-scroll-reveal="{ delay: 700 }">
						<div class="user-avatar avatar-wrapper rd-circle flex flex-center mg-right-14">
							<img class="avatar-image lazy" :data-src="user.avatar" v-lazyload />
							<div class="avatar-cover"></div>
						</div>
						<div class="user-info">
							<p class="sub-title mg-0 fb-45">{{ user.fullname }}</p>
							<p class="text mg-0 fb-35">{{ user.username }}</p>
						</div>
						<form method="POST" :action="action">
							<input class="" type="hidden" name="username" :value="user.username" />
							<button class="user-delete button pd-14 rd-circle">
								<i class="bx bx-trash fs-20"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="users-none" v-else>
			No data is displayed
		</div>
	</div>
</template>

<style scoped>
	
	/*
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 * User Styling
	 * -------------------------------------------------------------------------------------------------------------------------------------------
	 *
	 */
	.users {
	}
		.users-groups {
		}
			.user {
				background: var(--background-1);
				border: 1px solid var(--border-2);
			}
				.user-wrapper {
					position: relative;
				}
					.user-avatar {
						width: 60px;
						height: 60px;
					}
					.user-info {
						width: 86%;
					}
					@media (max-width: 750px) {
						.user-info {
							width: 55%;
						}
					}
					.user-delete {
						width: 60px;
						height: 60px;
					}
	
</style>