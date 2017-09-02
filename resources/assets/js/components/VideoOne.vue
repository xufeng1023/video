<template>
	<div class="thumbnail" :class="{'is-thumbnail':active}">
		<a :href="video.slug | VID" v-if="src">
			<img :src="src | IMG">
		</a>
		<div class="caption">
			<h6 v-text="video.slug"></h6>
			<p>
				<input type="file" accept="image/*" @change="onChange">
			</p>
			<button type="button" class="btn btn-danger btn-xs" @click="remove(video.slug)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<button type="button" class="btn btn-success btn-xs" @click="preview(video.slug)">
				<span class="glyphicon glyphicon-thumbs-up"></span>
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['video'],
		data() {
			return {
				src: '',
				active: this.video.is_free
			}
		},
		created() {
			if(this.video.thumbnail) {
				this.src = this.video.thumbnail.slug
			}
			Bus.$on('previewChanged', function(data) {
				this.active = data.slug == this.video.slug ? 1 : 0
			}.bind(this))
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
			preview(slug){
				axios.patch('/admin/videos/'+slug+'/preview')
				.then(() => {
					Bus.$emit('previewChanged', {'slug':slug})
				})
			},
			remove(slug) {
				axios.delete('/admin/videos/'+slug)
				.then((r) => {
					$(this.$el).fadeOut(300, () => {
						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					})
					//location.reload()
				})
			},
			onChange(e) {
				let fm = new FormData
				fm.append('image', e.target.files[0])
				axios.post('/admin/videos/thumbnail/'+this.video.slug, fm)
					.then(r => {
						this.src = r.data.src
						e.target.value = null
					})
			}
		}
	}
</script>