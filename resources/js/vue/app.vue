<template>
    <div class="Container">
        <div class="top">
            <h1 id="title">Livros</h1>
            <span id="name">{{ this.user.name }} <input type="number" @change="getUser()" v-model="user_id"></span>
            <span class="clear"></span>
        </div>

        <div class="body">

            <div id="list">
                <div id="list-buttoms">
                    <button @click="allBookList()">Todos os Livros</button>
                    <button @click="userLendBookList()">Suas Reservas</button>
                    <button @click="userBookList()">Seus Livros</button>
                </div>
                <div id="book-list-container">
                    <book-list :items="items" :user_id="user_id" 
                        v-on:itemid="changeItemId($event)"
                        v-on:editBook="editBook($event)"
                        v-on:deleteBook="deleteBook($event)"
                    />
                </div>
            </div>

            <div id="main-view">
                <div id="add-book">
                    <button @click="openCreateBookPage()">Adicionar um Livro</button>
                </div>
                <div id="main-view-center">
                    <book-show v-if="book_page" :user_id="user_id" :item="item" v-on:userLendBookList="userLendBookList()"/>
                    <book-create v-if="create_page" :user_id="user_id" v-on:userBookList="userBookList()"/>
                    <book-update v-if="update_page" :user_id="user_id" :item="item" v-on:userBookList="userBookList()"/>
                </div>
            </div>

            <span class="clear"></span>
        </div>


            
    
    </div>
</template>

<script>
import BookCreate from './bookCreate.vue'
import BookList from './bookList.vue'
import BookShow from './bookShow.vue'
import BookUpdate from './bookUpdate.vue'
export default {
    components: {
        BookList,
        BookShow,
        BookCreate,
        BookUpdate, 
    },
    data:
        function(){
        return {
            book_page: false,
            create_page: false,
            update_page: false,
            items: [],
            item: [],
            user_id: 1,
            user: [],
        }
    },
    methods: {
        getUser() {
            axios.get('api/users/' + this.user_id)
            .then( response => {
                this.user = response.data.data
                this.user_id = id
            }).catch( e => {
                console.log(e)
            })
        },
        allBookList() {
            axios.get('api/books')
            .then( response => {
                this.items = response.data.data
            }).catch( e => {
                console.log(e)
            })
        },
        userLendBookList() {
            axios.get('api/users/lends/' + this.user_id)
            .then( response => {
                this.items = response.data.data
            }).catch( e => {
                console.log(e)
            })
        },
        userBookList() {
            axios.get('api/users/books/' + this.user_id)
            .then( response => {
                this.items = response.data.data
            }).catch( e => {
                console.log(e)
            })
        },
        changeItemId(id) {
            axios.get('api/books/' + id)
            .then( response => {
                this.item = response.data.data
                this.book_page = true
                this.create_page = false
                this.update_page = false
            }).catch( e => {
                console.log(e)
            })
        },
        openCreateBookPage()
        {
            this.book_page = false
            this.create_page = true
            this.update_page = false
        },
        editBook(id)
        {
            axios.get('api/books/' + id)
            .then( response => {
                this.item = response.data.data
                this.book_page = false
                this.create_page = false
                this.update_page = true
            }).catch( e => {
                console.log(e)
            })
        },
        deleteBook(id)
        {
            axios.delete('api/books/' + id)
            .then( response => {
                console.log(response.data.data)
                this.userBookList()
            }).catch( e => {
                console.log(e)
            })
        }
    },
    created() {
        this.allBookList();
        this.getUser();
    }
}
</script>

<style scoped>
.clear {
    clear: both;
}

.Container {
    margin: 0px;
    padding: 0px;
}

.top {
    height: 50px;
    background-color: #e6e6e6;
    width: 100%;
    
}

.top #title {
    float: left;
    margin-top: 5px;
    margin-left: 15px;

}

.top #name {
    float: right;
    margin-right: 15px;
    margin-top: 15px;
}

.top #name input{
    width: 40px;
}

.body #list {
    float: left;
    width: 40%;
}

.body #main-view {
    float: right;
    width: 50%;
}

#list-buttoms {
    padding: 30px;
}

#add-book {
    padding: 30px;
}
</style>