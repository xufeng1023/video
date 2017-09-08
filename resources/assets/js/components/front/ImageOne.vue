<template>
	<a href="javascript:;" data-toggle="modal" data-target="#viewImageModal" @click="show">
        <img :src="this.image.slug | FILE" width="100%">
    </a>
</template>

<script>
	export default {
		props: ['image'],
		methods: {
			show() {
				Bus.$emit('showImage', this.image.slug);
			}
		}
	}
</script>