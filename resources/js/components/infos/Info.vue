<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ info.title }}</div>

                    <div class="card-body">
                        <p>{{ info.content }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/api/infos/' + this.$route.params.id).then(response => {
                this.info = response.data;
            });
        },
        data() {
            return {
                info: {}
            }
        }
    }
</script>
