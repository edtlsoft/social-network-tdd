<template>
    <div @click="redirectIfGuest">
        <transition-group name="status-list-transition">
            <status-list-item
                v-for="status in statuses"
                :key="status.id"
                :status="status"
            ></status-list-item>
        </transition-group>
    </div>
</template>

<script>

import StatusListItem from "./StatusListItem";

export default {
    components: {
        StatusListItem,
    },
    props: {
        url: String
    },
    data() {
        return ({
            statuses: [],
        })
    },
    computed: {
        getUrl() {
            return this.url ? this.url : '/statuses'
        }
    },
    methods: {
        loadListOfStatuses() {
            axios.get(this.getUrl)
                .then(response => this.statuses = response.data.data)
                .catch(errors => console.log(errors))
        },

    },
    mounted() {
        this.loadListOfStatuses();

        EventBus.$on('status-created', status => this.statuses.unshift(status))

        Echo.channel('statuses')
            .listen(
                'StatusCreated',
                event => {
                    console.log(event, event.status);
                    this.statuses.unshift(event.status);
                }
            )
    }
}
</script>

<style scoped>
    .status-list-transition-move {
        transition: all 0.5s;
    }
</style>
