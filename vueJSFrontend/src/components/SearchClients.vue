<template>
    <div class="container">
        <div class="row">
            <div class="col-md-7 mrgnbtm">
                <h2>Please Enter Client Name</h2>
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
                                placeholder="Client Name"
                            />
                            <button
                                class="searchBarbutton"
                                type="button"
                                @click="clientSearch()"
                            >
                                <i class="fa fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <DisplayClient
                v-if="responseAvailable"
                :clients="clients"
                @emit-display-Policies="emitDisplayPolocies"
            />
        </div>
    </div>
</template>

<script>
import DisplayClient from './DisplayClient.vue'
export default {
    name: 'SearchClients',
    components: {
        DisplayClient,
    },
    props: {
        method: { type: Function },
    },
    data() {
        return {
            clientName: '',
            clients: ' ',
            responseAvailable: false,
        }
    },

    methods: {
        emitDisplayPolocies(value) {
            this.$emit('display-policies', value)
        },
        clientSearch() {
            this.responseAvailable = false
            fetch(
                'http://localhost:5174/index.php/user/list/client?searchTerm=' +
                    this.clientName +
                    '',
                {
                    method: 'GET',
                    // mode: 'no-cors',
                    headers: {
                        'Content-Type': 'text/plain',
                    },
                }
            )
                .then((response) => {
                    console.log(response)
                    if (response.ok) {
                        return response.json()
                    } else {
                        alert(
                            'Server returned ' +
                                response.status +
                                ' : ' +
                                response.statusText
                        )
                    }
                })
                .then((response) => {
                    console.log('-----------------------', response)
                    this.clients = response
                    this.responseAvailable = true
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
    },
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
