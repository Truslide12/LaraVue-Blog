<template>
    <div>
        <h1>The current view count is: {{views}}</h1>
        <button @click="updateViews(1)">Increment</button>
        <button @click="updateViews(-1)">Decriment</button>
        <br>
        <br><br>

        <div v-for="(blog, i) in blogs" :key='i'>
            <!-- <div v-for="(blog, i) in blogs" :key='i' v-if="blogs.length"> -->
            <h1>{{blog.title}}</h1>
            <p>{{blog.post}}</p>
        </div>

        <br>
        <br><br>

        <div>
            <!-- As long as the v-if and v-else are in the same div element this will work -->
            <h1 v-if="showItem">show this item if showItem is true</h1>
            <h1 v-else>show this item if showItem is false</h1>
        </div>

        <button @click="showItem = !showItem">change showItem</button>

    </div>
</template>

<script>
export default {
    data(){
        return {
            views: 0,
            blogs: [],
            showItem: false,
        }
    },
    methods: {
        updateviews(number){
            this.views += number
        }
    },
    created() {
        // call teh server to get the views
        this.views = 100
        // Get the blog posts
        let posts =
            [ //test array
                {title: 'this is the blog title 1', post: 'this is the blog post 1', id: 1},
                {title: 'this is the blog title 2', post: 'this is the blog post 2', id: 2},
                {title: 'this is the blog title 3', post: 'this is the blog post 3', id: 3},
                {title: 'this is the blog title 4', post: 'this is the blog post 4', id: 4},
                {title: 'this is the blog title 5', post: 'this is the blog post 5', id: 5},
                {title: 'this is the blog title 6', post: 'this is the blog post 6', id: 6},
                {title: 'this is the blog title 7', post: 'this is the blog post 7', id: 7},
            ]
        this.blogs = posts
    }
}
</script>