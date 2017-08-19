<template>
	<div>
		<div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" v-model="computedTitle">
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" :value="titleSlug || computedSlug">
        </div>
	</div>
</template>

<script>
	export default {
		props: ['title', 'slug'],
		data() {
			return {
				'titleValue': this.title,
				'titleSlug': this.slug
			}
		},
		computed: {
			computedSlug() {
				return this.titleValue.toLowerCase().replace(/\s+/g, '-')
			},
			computedTitle: {
				get() {
					return this.titleValue
				},
				set(v) {
					this.titleSlug = ''
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