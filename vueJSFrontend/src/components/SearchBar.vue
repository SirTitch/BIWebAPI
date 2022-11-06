<!-- General SearchBar component that returns a search value to the parent  -->
<template>
    <div class="container">
        <div class="row">
            <div>
                <form>
                    <div class="row">
                        <div class="searchBar">
                            <!-- <label class="searchBarLabel">Client Name: </label> -->
                            <input
                                type="text"
                                class="searchBarinput"
                                v-model="searchText"
                                name="searchText"
                                id="searchText"
                                placeholder=""
                            />
                            <button
                                class="searchBarbutton"
                                type="button"
                                @click="handleSearch(searchText)"
                            >
                                <i class="fa fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SearchBar',
    components: {},
    props: {
        method: { type: Function },
    },
    data() {
        return {
            searchText: '',
        }
    },

    methods: {
        handleSearch(text) {
            this.$emit('emitSearch', text)
        },
    },
}
</script>

<style scoped>
.searchBar {
    /* padding: 5px; */
}

.searchBarLabel {
}
.searchBarinput {
    padding: 5px;
    font-size: 16px;
}
.searchBarbutton {
    padding: 5px;
    font-size: 16px;
}
</style>
