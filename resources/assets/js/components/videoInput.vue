<template>
	<div class="form-group">
        <label>Video</label>
        <input type="file" name="video" accept="video/*" @change="onChange">
        <p>{{ progress }}</p>
    </div>
</template>

<script>
	export default {
		props: ['postId', 'slug'],
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
				if(this.videoId) {
					this.ajax = '/admin/videos/' + this.videoId
					fm.append('_method', 'PUT')
				}
				axios.post(this.ajax, fm)
					.then( r => { 
					this.videoId = r.data.videoId
					loaded += end - start
					this.progress = ((loaded / size) * 100) + '%'
					start += step
					if(start >= size || end >= size) return
					
					end = start + step
					if(end > size) end = size

					//setTimeout(() => {
						this.upload(file, start, end, step, size, fm, loaded)
					//}, 500)
					
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
				fm.append('postId', this.postId),
				fm.append('slug', this.slug.toLowerCase().replace(/\s+/g, '-'))

				this.upload(file, start, end, step, size, fm, loaded)

				//var blob = file.slice(start, end)

				//let reader = new FileReader()
				//reader.readAsDataURL(blob)

				// let self = this

				// reader.onload = function() {
				// 	if(self.videoId) {
				// 		self.ajax = '/admin/videos/' + self.videoId
				// 	}
				// 	axios.post(self.ajax, {
				// 		'postId': self.postId,
				// 		'slug': self.slug.toLowerCase().replace(/\s+/g, '-'),
				// 		'video': reader.result
				// 	}).then( r => { 
				// 		self.videoId = r.data.videoId
				// 		loaded += end - start
				// 		self.progress = ((loaded / size) * 100) + '%'

				// 		start += step
				// 		if(start >= size || end >= size) {
				// 			location.reload()
				// 		}

				// 		end = start + step
				// 		if(end > size) end = size

				// 		blob = file.slice(start, end);
    //             		reader.readAsDataURL(blob);
    //         		})              
    //     		};
			}
		}
	}
</script>
