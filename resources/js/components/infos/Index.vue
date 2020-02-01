<template>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Example Component</div>

                <div class="card-body">

                    <div v-for="info in infos" :key="info.id">
                        <h4>
                            <router-link :to="{ name:'infos', params: {id: info.id} }">{{ info.title }}
                            </router-link>
                        </h4>
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
            axios.get('/api/infos').then(response => {
                this.infos = response.data.data;
            });
        },
        data() {
            return {
                infos: []
            }
        }
    }
</script>
