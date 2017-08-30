<template>
	<div class="thumbnail">
		<a :href="video.id | VID" v-if="src">
			<img :src="src | IMG">
		</a>
		<div class="caption">
			<h6 v-text="video.slug"></h6>
			<p>
				<input type="file" accept="image/*" @change="onChange">
			</p>
			<button type="button" class="btn btn-danger btn-xs" @click="remove(video.id)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['video'],
		data() {
			return {
				src: ''
			}
		},
		created() {
			if(this.video.thumbnail) {
				this.src = this.video.thumbnail.slug
			}
		},
		filters: {
			IMG(value) {
				return '/storage/' + value
			},
			VID(value) {
				return '/admin/videos/' + value
			}
		},
		methods: {
			remove(id) {
				axios.post('/admin/videos/'+id, {'_method': 'DELETE'})
				.then(() => {
					location.reload()
				})
			},
			onChange(e) {
				let fm = new FormData
				fm.append('image', e.target.files[0])
				axios.post('/admin/videos/thumbnail/'+this.video.id, fm)
					.then(r => {
						this.src = r.data.src
						e.target.value = null
					})
			}
		}
	}
</script>