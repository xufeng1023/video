<script>
	export default {
		props: ['init'],
		data() {
			return {
				src: this.init
			}
		},
		created() {
			Bus.$on('play', link => {
				this.src = '/storage/' + link
			})
		}
	}
</script>