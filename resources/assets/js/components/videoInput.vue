<template>
	<div class="form-group">
        <label>Video</label>
        <input type="file" name="video" accept="video/*" @change="onChange">
        <p>{{ progress }}</p>
    </div>
</template>

<script>
	export default {
		data() {
			return {
				progress: 0
			}
		},
		methods: {
			onChange(e) {
				var loaded = 0
				var start = 0
				let step = 10000 * 1024 // 5m
				var end = start + step

				let file = e.target.files[0]
				let size = file.size

				if(end > size) end = size

				var blob = file.slice(start, end)

				let reader = new FileReader()
				//reader.readAsBinaryString(blob)
				reader.readAsDataURL(blob)

				// var fm = new FormData
				// fm.append('video', blob)
				// fm.append('aa', 123)

				let self = this

				reader.onload = function() {

					axios.post('/admin/videos/video', {'video': reader.result})
					.then( () => {
						loaded += end - start
						self.progress = ((loaded / size) * 100) + '%'

						start += step
						if(start >= size) return

						end = start + step
						if(end > size) end = size

	                    blob = file.slice(start, end);
	                    reader.readAsDataURL(blob);
            		})              

        		};
			}
		}
	}
</script>
