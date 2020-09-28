<template>
    <div>
        <h1 ref="myName">My First Vue Page!!</h1>
        <h2>My name is: {{name}}</h2>
    </div>
</template>

<script>
// local state memeory
export default {
    data() {
        return {
            name: 'Carlos'
        }
    },

    beforeCreate(){
        // this data is available before the page is creation
        // for detecting logged in or not (example)
    },

    created() {
        // These happen after the js file is completely rendered on the webpage
        // Mostly for calling initial data access data with this.dataItem
        console.log('data and other functions are available but not html', this.name)
    },

    mounted() {
        // used for accessing local storage - can access html
        console.log(this.$refs.myName)
    }
}
</script>