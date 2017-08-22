<template>
    <input type="text" name="title" class="form-control" v-model="computedTitle">
</template>

<script>
	export default {
		props: ['title'],
		data() {
			return {
				'titleValue': this.title
			}
		},
		computed: {
			computedTitle: {
				get() {
					return this.titleValue
				},
				set(v) {
					let capitalized = v.replace(/\s+/g, ' ').split(' ').map(function(value) {
						if(value) {
							return value[0].toUpperCase() + value.slice(1)
						}
					})

					this.titleValue = capitalized.join(' ')
				}
			}
		}
	}
</script>
