<template>
    <div>
        <Topmenu></Topmenu>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import Topmenu from "./common/Topmenu";

    export default {
        components: {
            Topmenu
        }
    }
</script>
