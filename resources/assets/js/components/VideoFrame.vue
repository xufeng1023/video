<template>
	<video id="video-player" class="video-js vjs-big-play-centered" data-setup="{}" controls autoplay>
    </video>
</template>

<script>
	export default {
		props: ['init'],
		data() {
			return {
				video: null
			}
		},
		mounted() {
			this.video = videojs('video-player');

			this.video.src({
				type: "video/mp4",
				src: '/video/' + this.init
			});

			Bus.$on('play', link => {
				this.video.pause();

				this.video.src({
					type: "video/mp4",
					src: '/video/' + link
				});
				
				this.video.load();
				this.video.play();
			})
			// this.video.ready(function() {

			// 	this.hotkeys({
			// 		seekStep: 10,
			// 	});
			// });

			// this.video.on('seeking', () => {
			// 	console.log();
			// })
		}
	}
</script>