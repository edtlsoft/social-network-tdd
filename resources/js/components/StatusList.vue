<template>
    <div @click="redirectIfGuest">
        <status-list-item
            v-for="status in statuses"
            :key="status.id"
            :status="status"
        ></status-list-item>
    </div>
</template>

<script>

import StatusListItem from "./StatusListItem";

export default {
    components: {
        StatusListItem,
    },
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
