<template>
	<div class="form-group">
        <label>Video</label>
        <input type="file" name="video" accept="video/*" @change="onChange">
        <p v-show="progress">{{ progress }}</p>
    </div>
</template>

<script>
	export default {
		props: ['post', 'slug'],
		data() {
			return {
				videoId: '',
				progress: 0,
				ajax: '/admin/videos'
			}
		},
		methods: {
			upload(file, start, end, step, size, fm, loaded) {
				var blob = file.slice(start, end)
				fm.delete('video')
				fm.append('video', blob)
				fm.append('postId', this.post)
				
				if(this.videoId) {
					this.ajax = '/admin/videos/' + fm.get('slug')
					fm.append('_method', 'PUT')
				} else {
					fm.delete('_method')
					this.ajax = '/admin/videos'
				}

				axios.post(this.ajax, fm)
					.then( r => { 
					if(r.data.videoId != undefined) this.videoId = r.data.videoId
					loaded += end - start
					this.progress = ((loaded / size) * 100) + '%'
					start += step
					if(start >= size || end >= size) {
						location.reload()
						return
					}
					end = start + step
					if(end > size) end = size

					this.upload(file, start, end, step, size, fm, loaded)
        		})
			},
			onChange(e) {
				var loaded = 0
				var start = 0
				let step = 2 * 1024 * 1024 // 1m
				var end = start + step

				let file = e.target.files[0]
				let size = file.size

				if(end > size) end = size
				

				let fm = new FormData
				fm.append('slug', this.slug)

				this.upload(file, start, end, step, size, fm, loaded)
			}
		}
	}
</script>
