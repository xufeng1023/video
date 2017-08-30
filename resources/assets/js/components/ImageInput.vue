<template>
	<div>
		<div class="form-group">
	        <label>Images</label>
	        <input type="file" name="screenshots[]" accept="image/*" multiple @change="onChange">
	    </div>
	    <div class="row" v-for="pic in computedImages">
            <div class="col-sm-3" v-for="slug in pic">
                <div class="thumbnail" :class="{'is-thumbnail':slug.is_thumbnail}">
                	<a :href="slug.slug | LINK">
                		<img :src="slug.slug | SRC" width="100%">
                	</a>
                    <button type="button" class="btn btn-success btn-xs" @click="thumb(slug.slug)">
                    	<span class="glyphicon glyphicon-thumbs-up"></span>
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" @click="remove(slug.slug)">
                    	<span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
            </div>
	    </div>
	</div>
</template>

<script>
	export default {
		props: ['post', 'image'],
		data() {
			return {
				images: JSON.parse(this.image)
			}
		},
		filters: {
			SRC: function(value) {
				return '/storage/' + value
			},
			LINK: function(value) {
				return '/admin/images/' + value.replace('upload/', '')
			}
		},
		computed: {
			computedImages() {
				return _.chunk(this.images, 3)
			}
		},
		methods: {
			onChange(e) {
				let files = e.target.files
				if(files.length === 0) return

				let data = new FormData

				for(var i = 0; i < files.length; i++) {
					data.append('images[]', files[i])
				}

				data.append('postId', this.post)

				axios.post('/admin/images', data)
					.then((r) => {
						e.target.value = ''

						r.data.slugs.forEach(element => this.images.push(element))

						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					}).catch((r) => {
						Bus.$emit('flash', {
							message: r.response.data,
							type: 'danger'
						})
					})
			},
			thumb(slug) {
				axios.post('/admin/images/'+slug.replace('upload/', ''), {_method: 'PUT'})
					.then(r => {
						this.images.forEach(image => {
							image.is_thumbnail = 0
							if(image.slug == slug) image.is_thumbnail = 1
						})

						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					})
			},
			remove(slug) {
				axios.post('/admin/images/'+slug.replace('upload/', ''), {_method: 'DELETE'})
					.then(r => {
						this.removeImage(slug)

						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					})
			},
			removeImage(slug) {
				this.images = this.images.filter(image => {
					return image.slug != slug
				})
			}
		}
	}
</script>