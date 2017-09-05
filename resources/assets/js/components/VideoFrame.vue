<template>
	<video id="video-player" class="video-js vjs-big-play-centered" data-setup="{}" controls autoplay>
        <source :src="src" type="video/mp4">
    </video>
</template>

<script>
	export default {
		props: ['init'],
		data() {
			return {
				src: this.init,
				video: null
			}
		},
		mounted() {
			this.video = videojs('video-player')
			this.video.ready(function() {

				this.hotkeys({
					seekStep: 10,
				});
			});

			// this.video.on('seeking', () => {
			// 	console.log();
			// })
		},
		created() {
			Bus.$on('play', link => {
				this.src = link
				this.video.src(this.src)
			})
		}
	}
</script>