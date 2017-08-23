<template>
	<div>
		<div class="form-group">
	        <label>Images</label>
	        <input type="file" name="screenshots[]" accept="image/*" multiple @change="onChange">
	    </div>
	    <div class="row">
            <div class="col-sm-3">
                <div class="thumbnail">
                    <img src="" width="100%">
                </div>
            </div>
	    </div>
	</div>
</template>

<script>
	export default {
		props: ['data', 'id'],
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
					.then((r) => { console.log(r)
						Bus.$emit('flash', {
							message: r.data.message,
							type: 'success'
						})
					}).catch((r) => { console.log(r.response)
						Bus.$emit('flash', {
							message: r.response.data,
							type: 'danger'
						})
					})
			}
		}
	}
</script>