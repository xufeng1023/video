<template>
	<div>
		<div class="form-group">
	        <label>Images</label>
	        <input type="file" name="screenshots[]" accept="image/*" multiple @change="onChange">
	    </div>
	    <div class="row" v-for="pic in computedImages">
            <div class="col-sm-4" v-for="slug in pic">
                <div class="thumbnail" :class="{'is-thumbnail':slug.is_thumbnail}">
                    <img :src="slug.slug | SRC(src)" width="100%">
                    <button type="button" class="btn btn-success btn-xs" @click="thumb(slug.id)">
                    	<span class="glyphicon glyphicon-thumbs-up"></span>
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" @click="remove(slug.id)">
                    	<span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
            </div>
	    </div>
	</div>
</template>

<script>
	export default {
		props: ['data', 'id', 'src', 'image'],
		data() {
			return {
				images: JSON.parse(this.image)
			}
		},
		filters: {
			SRC: function(value, baseUrl) {
				return baseUrl + '/' + value
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

				data.append('post_id', this.id)
				axios.post('/admin/images', data)
					.then((r) => {
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
			thumb(id) {
				axios.post('/admin/images/'+id, {_method: 'PUT'})
					.then(r => {
						this.images.forEach(image => {
							image.is_thumbnail = 0
							if(image.id == id) image.is_thumbnail = 1
						})

						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					})
			},
			remove(id) {
				axios.post('/admin/images/'+id, {_method: 'DELETE'})
					.then(r => {
						this.removeImage(id)

						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					})
			},
			removeImage(id) {
				this.images = this.images.filter(image => {
					return image.id != id
				})
			}
		}
	}
</script>