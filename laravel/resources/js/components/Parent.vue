<template>
    <div id = "app">
        <div id = "for_margin"></div>
        <navigation></navigation>
        <router-view></router-view>
    </div>
</template>

<script>
import Navigation from './Navigation.vue'
export default {
    components: {
        'navigation' : Navigation
    }
}
</script>

<style scoped>
#for_margin{
    height : 10px;
    background-color: #E9E9F2;
}
</style>