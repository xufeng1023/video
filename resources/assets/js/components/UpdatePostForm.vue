<template>
	<form :action="post.slug | action" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label>Title</label>
            <div class="input-group">
                <title-input :title="post.title"></title-input>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success">update</button>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label>Views: <span class="badge">{{ post.views }}</span></label>
        </div>
    </form>
</template>

<script>
	import titleInput from './PostTitleInput.vue'

	export default {
		props: ['data'],
		data() {
			return {
				post: JSON.parse(this.data)
			}
		},
		filters: {
			action(value) {
				return '/admin/posts/' + value
			}
		},
		components: { 'title-input': titleInput },
	}
</script>