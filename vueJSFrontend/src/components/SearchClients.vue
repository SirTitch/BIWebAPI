<template>
    <div class="container">
        <div class="row">
            <h2 class="header1">Please Enter Client Name</h2>

            <div class="searchBar">
                <!-- <label class="searchBarLabel">Client Name: </label> -->
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
        <div>
            <DisplayClient
                v-if="responseAvailable"
                :clients="clients"
                @emit-display-Policies="emitDisplayPolicies"
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
        emitDisplayPolicies(value) {
            this.$emit('display-policies', value)
        },
        //Seraches the client by name in the search bar
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
                    this.clients = response
                    this.responseAvailable = true
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
        getAllClients() {
            this.responseAvailable = false
            fetch('http://localhost:5174/index.php/user/list/allClient', {
                method: 'GET',
                // mode: 'no-cors',
                headers: {
                    'Content-Type': 'text/plain',
                },
            })
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
                    this.clients = response
                    this.responseAvailable = true
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
    },
    beforeMount() {
        this.getAllClients()
    },
}
</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    flex-direction: column;
}
.searchBar {
    padding: 5px;
    display: flex;
    justify-content: center;
}

.searchBarLabel {
    display: flex;
    justify-content: center;
    flex-direction: column;
}
.searchBarinput {
    padding: 5px;
}
.searchBarbutton {
    padding: 5px;
}

.header1 {
    text-align: center;
}
</style>
