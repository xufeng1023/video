<template>
	<article @click="play">
		<img :src="video.thumbnail.slug | SRC" width="100%">
	</article>
</template>

<script>
	export default {
		props: ['video'],
		filters: {
			SRC(value) {
				return '/storage/' + value
			}
		},
		methods: {
			play() {
				Bus.$emit('play', this.video.link)
			}
		}
	}
</script>