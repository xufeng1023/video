<template>
    <form :action="action" method="POST" class="pull-right" @submit="onSubmit">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-xs btn-danger">
            <span class="glyphicon glyphicon-trash"></span>
        </button>
    </form>
</template>

<script>
    export default {
        props: ['action'],
        methods: {
            onSubmit() {
                if(confirm('delete?')) {
                    console.log(2)
                }
            }
        }
    }
</script>
