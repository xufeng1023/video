<script>
	export default {
		data() {
			return {
				src: ''
			}
		},
		created() {
			Bus.$on('showImage', src => {
				this.src = src
			});
		}
	}
</script>