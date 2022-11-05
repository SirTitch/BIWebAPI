<script setup>
import HelloWorld from './components/HelloWorld.vue'
import TheWelcome from './components/TheWelcome.vue'
import Header from './components/Header.vue'
import SearchClients from './components/SearchClients.vue'
import Polocies from './components/Polocies.vue'
</script>

<template>
    <Header />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <!-- <img alt="Vue logo" class="logo" src="./assets/logo.svg" width="125" height="125" /> -->

    <main>
        <SearchClients
            v-if="!displayPolicies"
            @display-Policies="displayPoliciesFunction"
        />
        <Polocies
            v-if="displayPolicies && responseAvailable"
            @displaypolicies="displayPoliciesFunction"
            :polocies="clientPolocies"
            :clientId="clientId"
        />
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
            clientPolocies: [],
            responseAvailable: false,
        }
    },
    emits: ['displaypolicies'],
    methods: {
        displayPoliciesFunction(id, orderBy) {
            // this.responseAvailable = false
            // this.displayPolicies = false
            let orderByVar = 'p.policyId'
            if (id !== this.clientId) {
                this.clientId = id
                orderByVar = 'p.policy_Id'
                if (orderBy != undefined) {
                    orderByVar = orderBy
                }
                fetch(
                    'http://localhost:5174/index.php/user/list/clientPolicy?searchTerm=' +
                        id +
                        '&orderBy=' +
                        orderByVar,
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
                        this.clientPolocies = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.displayPolicies = true
            }
        },
    },
    start(_, { emit }) {},
}
</script>

<style scoped>
/* .logo {
  display: block;
  margin: 0 auto 2rem;
} */

/* @media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-center;
    flex-wrap: wrap;
    border-width: 2px;
    border-color: brown;
    background-color:crimson;
  }
} */
</style>
