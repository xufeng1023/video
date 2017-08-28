<template>
	<div class="thumbnail">
		<img :src="src | IMG" v-if="src">
		<div class="caption">
			<h4 v-text="video.slug"></h4>
			<p>
				<input type="file" accept="image/*" @change="onChange">
			</p>
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
			}
		},
		methods: {
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