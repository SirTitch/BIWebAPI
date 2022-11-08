<template>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="container">
        <div class="filterBar">
            <!--  Filter & Search In Row -->
            <FilterDropdown
                :key="searchBarKey"
                :values="filterValues"
                @emitFilter="updateFilterBy"
            />
            <SearchBar :key="searchBarKey" @emitSearch="searchPolicy" />
            <button
                v-if="filterBy != '' || searchBy != ''"
                type="button"
                @click="clearFilter()"
                class="headerButton"
            >
                <i class="fa fa-close"></i>
                Clear
            </button>
        </div>
        <div class="buttonContainer">
            <NewPolicy :clientId="clientId" @resetList="clearFilter" />
        </div>
        <div class="tableWrapper">
            <table>
                <thead>
                    <tr>
                        <th>Policy Id</th>
                        <th>
                            <button
                                type="button"
                                @click="filterPolicy('p.policy_type')"
                                class="headerButton"
                            >
                                Policy Type
                                <i class="fa fa-sort"></i>
                            </button>
                        </th>
                        <th>Policy Premium</th>
                        <th>Insurer name</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in policiesArr" :key="item.id">
                        <td>{{ item.policy_id }}</td>
                        <td>{{ item.policy_type }}</td>
                        <td>{{ item.policy_premium }}</td>
                        <td>{{ item.insurer_name }}</td>
                        <td>{{ item.customer_name }}</td>
                        <td>{{ item.customer_address }}</td>
                        <td>
                            <div class="buttonContainer">
                                <EditPolicy
                                    :clientId="clientId"
                                    @resetList="clearFilter"
                                    :editItem="item"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import FilterDropdown from './FilterDropdown.vue'
import SearchBar from './SearchBar.vue'
import { ref } from 'vue'
import NewPolicy from './NewPolicy.vue'
import EditPolicy from './EditPolicy.vue'
import { SERVERURL } from '../constants'
export default {
    name: 'Policies',
    components: {
        FilterDropdown,
        SearchBar,
        NewPolicy,
        EditPolicy,
    },
    props: {
        method: { type: Function },
        clientId: { type: Number },
        isFromClient: { type: Boolean },
    },
    data() {
        return {
            policiesArr: [],
            displayPolicies: false,
            responseAvailable: false,
            filterValues: [
                { id: 1, label: 'Policy Id', value: 'p.policy_id' },
                { id: 2, label: 'Policy Type', value: 'p.policy_type' },
                { id: 3, label: 'Policy Premium', value: 'p.policy_premium' },
                { id: 4, label: 'Insurer name', value: 'p.insurer_name' },
                { id: 5, label: 'Customer Name', value: 'cr.customer_name' },
                {
                    id: 6,
                    label: 'Customer Address',
                    value: 'cr.customer_address',
                },
            ],
            filterBy: '',
            searchBy: '',
            searchBarKey: ref(0),
        }
    },
    methods: {
        // Clears the filter and search variables to re-set the policy list being displayed
        clearFilter() {
            this.filterPolicy('p.policy_id')
            this.searchBarKey += 1
            this.filterBy = ''
            this.searchBy = ''
        },
        //Function that lets the user order the list by certain columns, only used once as i missunderstood filter intially
        filterPolicy(orderBy) {
            let orderByVar = 'p.policyId'
            if (this.clientId) {
                let id = this.clientId
                orderByVar = 'p.policy_Id'
                if (orderBy != undefined) {
                    orderByVar = orderBy
                }
                fetch(
                    SERVERURL +
                        'index.php/user/list/clientPolicy?searchTerm=' +
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
                        this.policiesArr = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.displayPolicies = true
            } else {
                //Fetch all instead
                this.getAllPolicies()
            }
        },
        //Updates the filter using an emit from the searchBar
        updateFilterBy(value) {
            this.filterBy = value
        },
        //Takes the search value and the filter, and sends it to the api to get all the policies that match the chosen filter and search
        searchPolicy(searchValue) {
            this.searchBy = searchValue
            let orderByVar = 'p.policyId'
            if (this.clientId) {
                let id = this.clientId
                orderByVar = 'p.policy_Id'
                fetch(
                    SERVERURL +
                        'index.php/user/list/clientPolicyFilter?searchTerm=' +
                        id +
                        '&orderBy=' +
                        orderByVar +
                        '&filterBy=' +
                        this.filterBy +
                        '&filterValue=' +
                        searchValue,
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
                        this.policiesArr = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.displayPolicies = true
            } else {
                orderByVar = 'p.policy_Id'
                fetch(
                    SERVERURL +
                        'index.php/user/list/allPoliciesFilter?searchTerm=' +
                        '' +
                        '&orderBy=' +
                        orderByVar +
                        '&filterBy=' +
                        this.filterBy +
                        '&filterValue=' +
                        searchValue,
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
                        this.policiesArr = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.displayPolicies = true
            }
        },
        //Fetches all the policies when just viewing all the policies
        getAllPolicies() {
            fetch(SERVERURL + 'index.php/user/list/allPolicies', {
                method: 'GET',
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
                    this.policiesArr = response
                    this.responseAvailable = true
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
            this.displayPolicies = true
        },
    },
    beforeMount() {
        //On the mount of the component, its checking to see if its viewing the policies of a certain client or all the policies
        if (this.isFromClient) {
            this.filterPolicy('p.policy_id')
        } else {
            this.getAllPolicies()
        }
    },
}
</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    flex-direction: column;
}
.tableWrapper {
    padding-top: 2.5px;
    padding-bottom: 2.5px;
    width: 100%;
    display: flex;
    justify-content: center;
}

.headerButton {
    border: none;
    background-color: inherit;
    color: inherit;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
}
.filterBar {
    padding-top: 20px;
    padding-bottom: 20px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    align-self: center;
    width: 50%;
    flex: 4;
}

.buttonContainer {
    padding-top: 2.5px;
    padding-bottom: 2.5px;
    display: flex;
    flex-direction: row;
    align-items: center;
    width: 100%;
    justify-content: center;
}
</style>
