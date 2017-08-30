<template>
	<div id="post-search-bar" class="form-group">
		<div class="input-group">
			<input type="text" class="form-control" @keyup="search">
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-search"></span>
			</span>
		</div>
		<div class="list-group" v-if="posts">
			<a :href="post.slug | LINK" class="list-group-item" v-for="post in posts">
				{{ post.title }}
			</a>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				posts: []
			}
		},
		filters: {
			LINK(value) {
				return '/admin/posts/' + value + '/edit'
			}
		},
		methods: {
			search: _.debounce(function(e) {
				let query = e.target.value.trim()
				if(!query) {
					this.posts = []
					return
				}

				axios.get('/admin/posts/search?q='+query)
				.then(r => {
					this.posts = r.data
				})
			}, 500)
		}
	}
</script>