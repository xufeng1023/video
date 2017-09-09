<template>
	<video 
		id="video-player" 
		class="video-js vjs-big-play-centered"
		data-setup="{}" 
		controls 
		autoplay 
	>
    </video>
</template>

<script>
	export default {
		props: ['preview'],
		data() {
			return {
				now: null,
				video: null
			}
		},
		watch: {
			now() {
				this.video.pause();
				//this.video.poster('/storage/' + this.now.thumbnail.slug);
				this.video.poster(null);
				this.video.src({
					type: "video/mp4",
					src: '/video/' + this.now.slug
				});
				
				this.video.load();
				this.video.play();
			}
		},
		mounted() {
			this.now = this.preview;
			
			this.video = videojs('video-player', {errorDisplay: false});

			if(this.now.thumbnail) {
				this.video.poster('/storage/' + this.now.thumbnail.slug);
			}

			this.video.src({
				type: "video/mp4",
				src: '/video/' + this.preview.slug
			});

			Bus.$on('play', video => {
				this.now = video;
			})

			this.video.ready(function() {
				this.hotkeys({
					seekStep: 10,
				});
			});

			this.video.on('ended', () => {
				axios.get('/video/next/' + this.now.slug)
				.then(({data}) => {
					this.now = data;
				})
			})
		}
	}
</script>