<template>
	<div class="input-group">
        <input type="text" name="title" class="form-control" v-model="computedTitle">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-success">add</button>
        </span>
    </div>
</template>

<script>
	export default {
		data() {
			return {
				'titleValue': ''
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
