<template>
    <div>
        <ul class="list-group">
            <li v-for="status in statuses" :key="status.id" class="list-group-item">
                {{ status.body }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return ({
            statuses: [],
        })
    },
    methods: {
        loadListOfStatuses() {
            axios.get('/statuses')
                .then(response => this.statuses = response.data.data)
                .catch(errors => console.log(errors))
        },
    },
    mounted() {
        this.loadListOfStatuses();

        EventBus.$on('status-created', status => this.statuses.unshift(status))
    }
}
</script>

<style scoped>

</style>
