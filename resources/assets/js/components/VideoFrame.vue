<template>
	<video 
		id="video-player" 
		class="video-js vjs-big-play-centered"
		:poster="this.preview.thumbnail.slug | SRC"
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
				video: null
			}
		},
		filters: {
			SRC(value) {
				return '/storage/' + value
			}
		},
		mounted() {
			this.video = videojs('video-player', {errorDisplay: false});

			this.video.src({
				type: "video/mp4",
				src: '/video/' + this.preview.slug
			});

			Bus.$on('play', video => {
				this.video.pause();

				this.video.poster('/storage/' + video.thumbnail.slug);

				this.video.src({
					type: "video/mp4",
					src: '/video/' + video.slug
				});
				
				this.video.load();
				this.video.play();
			})

			this.video.ready(function() {
				this.hotkeys({
					seekStep: 10,
				});
			});

			this.video.on('error', (e) => {
				console.log(this.video.error());
			})
		}
	}
</script>