<script setup>
import Header from './components/Header.vue'
import SearchClients from './components/SearchClients.vue'
import Policies from './components/Policies.vue'
</script>

<template>
    <Header />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="tab">
        <button class="tablinks" @click="openTab('client', 'Client', true)">
            Clients
        </button>
        <button class="tablinks" @click="openTab('policy', 'Policy', true)">
            Policy
        </button>
    </div>

    <main>
        <!-- Tab content -->
        <div id="Client" class="tabcontent">
            <SearchClients
                v-if="tabIndex == 'client'"
                @display-Policies="displayPoliciesFunction"
            />
        </div>

        <div id="Policy" class="tabcontent">
            <Policies
                v-if="tabIndex == 'policy'"
                @displaypolicies="displayPoliciesFunction"
                :policies="clientPolicies"
                :clientId="clientId"
                :isFromClient="isFromClient"
            />
        </div>
    </main>
</template>
<script>
export default {
    name: 'App',
    components: {},
    data() {
        return {
            displayPolicies: false,
            clientId: '',
            clientPolicies: [],
            responseAvailable: false,
            tabIndex: 'client',
        }
    },
    emits: ['displaypolicies'],
    methods: {
        // Fetches the clients Poloices from the api and returns it, setting the variables to show the polocies tab
        displayPoliciesFunction(id, orderBy) {
            let orderByVar = 'p.policyId'
            if (id !== this.clientId) {
                this.clientId = id
                orderByVar = 'p.policy_Id'
                if (orderBy != undefined) {
                    orderByVar = orderBy
                }
                fetch(
                    'https://web-api-code-challenge.herokuapp.com/index.php/user/list/clientPolicy?searchTerm=' +
                        id +
                        '&orderBy=' +
                        orderByVar,
                    {
                        method: 'GET',
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
                        this.clientPolicies = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.openTab('policy', 'Policy', false)
                this.isFromClient = true
            }
        },
        openTab(id, cityName, isTabBar) {
            // Declare all variables
            var i, tabcontent, tablinks
            this.tabIndex = id
            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName('tabcontent')
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = 'none'
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName('tablinks')
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(
                    ' active',
                    ''
                )
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = 'block'
            document.getElementById(cityName).className += ' active'
            if (isTabBar) {
                //Reset Client Variables for filter
                this.isFromClient = false
                this.clientId = ''
            }
        },
    },
    mounted() {
        //Set to the client tab on entry
        this.openTab('client', 'Client', true)
    },
}
</script>

<style scoped>
/* Style the tab */
.tab {
    overflow: hidden;
    /* border: 1px solid #ccc; */
    background-color: #ff6900;
}

/* Style the buttons that are used to open the tab content */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    color: #fff;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #f8a163;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
