<template>
    <button :class="getBtnClass" @click="toggle()">
        <i :class="getIconClass"></i> {{ getText }}
    </button>
</template>

<script>
export default {
    props: {
        model: {
            type: Object,
            required: true,
        },
        url: {
            type: String,
            required: true,
        }
    },
    computed: {
        getText() {
            return this.model.is_liked ? 'Unlike' : 'Like'
        },
        getBtnClass() {
            return [
                'btn', 'btn-link', 'btn-sm',
                this.model.is_liked ? '' : 'font-weight-bold'
            ]
        },
        getIconClass() {
            return [
                this.model.is_liked ? 'fas' : 'far',
                'fa-thumbs-up', 'text-primary', 'mr-1',
            ]
        },
    },
    methods: {
        toggle() {
            let method = this.model.is_liked ? 'delete' : 'post'

            axios[method](this.url)
                .then(response => {
                    this.model.is_liked = !this.model.is_liked
                    this.model.likes_count += method === 'post' ? 1 : -1
                })
                .catch(errors => console.log(errors))
        },
    },
}
</script>

<style scoped>

</style>
