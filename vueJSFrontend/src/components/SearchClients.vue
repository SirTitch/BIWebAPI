<template>
    <div class="container">
        <div class="row">
            <div class="col-md-7 mrgnbtm">
                <h2>Please Enter Client Name</h2>
                <form>
                    <div class="row">
                        <div>
                            <label htmlFor="exampleInputEmail1"
                                >Client Name:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="clientName"
                                name="clientname"
                                id="clientname"
                                aria-describedby="emailHelp"
                                placeholder="Client Name"
                            />
                            <button
                                type="button"
                                @click="clientSearch()"
                                class="btn btn-danger"
                            >
                                Search
                            </button>
                        </div>
                    </div>

                    <!-- <button
                        type="button"
                        @click="createUser()"
                        class="btn btn-danger"
                    >
                        Create
                    </button>
                    <button
                        type="button"
                        @click="createUser()"
                        class="btn btn-danger"
                    >
                        Create
                    </button> -->
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
