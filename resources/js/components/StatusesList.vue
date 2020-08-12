<template>
    <div>
        <div class="card mb-3 border-0 shadow-sm" v-for="status in statuses" :key="status.id">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <img class="rounded mr-3 shadow-sm" src="/images/default-avatar.jpg" alt="user-profile" width="40px">
                    </div>
                    <div>
                        <h5 class="mb-1">Edward Lopez</h5>
                        <div class="small text-muted">Hace una hora</div>
                    </div>
                </div>
                <div>
                    <p class="card-text text-secondary" v-text="status.body"></p>
                </div>
            </div>
        </div>
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
