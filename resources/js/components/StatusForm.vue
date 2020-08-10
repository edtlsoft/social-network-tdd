<template>
    <div>
        <form @submit.prevent="storeStatus">
            <div class="card-body">
                <textarea v-model="status.body" class="form-control border-0 bg-light" name="body" id="body" placeholder="What's on your mind, Edward?"></textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="create-status">Publish</button>
            </div>
        </form>
        <div>
            <ul class="list-group">
                <li v-for="status in statuses" :key="status.id" class="list-group-item">
                    {{ status.body }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return ({
                status: {
                    body: '',
                },
                statuses: [],
            })
        },
        methods: {
            storeStatus() {
                axios.post('/statuses', this.status)
                    .then(response => {
                        this.statuses.push(response.data)
                        this.status.body = ''
                    })
                    .catch(errors => console.log(errors))
            }
        },
    }
</script>

<style scoped>

</style>
