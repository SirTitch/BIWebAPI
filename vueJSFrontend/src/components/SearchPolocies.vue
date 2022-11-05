<!-- Add Dropdown for filters(https://www.w3schools.com/howto/howto_js_dropdown.asp), for each policy label, and create the function  -->
<template>
    <div class="container">
        <div class="row">
            <div>
                <h2>Filters:</h2>
                <form>
                    <div class="row">
                        <div class="searchBar">
                            <label class="searchBarLabel">Client Name: </label>
                            <input
                                type="text"
                                class="searchBarinput"
                                v-model="clientName"
                                name="clientname"
                                id="clientname"
                                placeholder="Policy Type"
                            />
                            <button
                                class="searchBarbutton"
                                type="button"
                                @click=""
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
    name: 'SearchPolocies',
    components: {},
    props: {
        method: { type: Function },
    },
    data() {
        return {
            policySearch: '',
        }
    },

    methods: {},
}
</script>

<style scoped>
.searchBar {
    padding: 5px;
}

.searchBarLabel {
}
.searchBarinput {
    padding: 5px;
}
.searchBarbutton {
    padding: 5px;
}
</style>
