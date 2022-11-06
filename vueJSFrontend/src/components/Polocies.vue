<template>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="container"></div>
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
    <div class="tableWrapper">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Policy Id</th>
                    <th>
                        <button
                            type="button"
                            @click="FilterPolicy('p.policy_type')"
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
                <tr v-for="item in polociesArr" :key="item.id">
                    <td>{{ item.policy_id }}</td>
                    <td>{{ item.policy_type }}</td>
                    <td>{{ item.policy_premium }}</td>
                    <td>{{ item.insurer_name }}</td>
                    <td>{{ item.customer_name }}</td>
                    <td>{{ item.customer_address }}</td>
                    <td>
                        <button
                            type="button"
                            @click="editPolicy(item)"
                            class="fa fa-edit"
                        >
                            Edit Policy
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import FilterDropdown from './FilterDropdown.vue'
import SearchBar from './SearchBar.vue'
import { ref } from 'vue'
export default {
    name: 'Polocies',
    components: {
        FilterDropdown,
        SearchBar,
    },
    props: {
        method: { type: Function },
        clientId: { type: Number },
    },
    data() {
        return {
            polociesArr: [],
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
        clearFilter() {
            this.FilterPolicy('p.policy_id')
            this.searchBarKey += 1
            this.filterBy = ''
            this.searchBy = ''
        },
        FilterPolicy(orderBy) {
            let orderByVar = 'p.policyId'
            if (this.clientId) {
                let id = this.clientId
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
                        this.polociesArr = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.displayPolicies = true
            }
        },
        updateFilterBy(value) {
            this.filterBy = value
        },
        searchPolicy(searchValue) {
            this.searchBy = searchValue
            let orderByVar = 'p.policyId'
            if (this.clientId) {
                let id = this.clientId
                orderByVar = 'p.policy_Id'
                fetch(
                    'http://localhost:5174/index.php/user/list/clientPolicyFilter?searchTerm=' +
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
                        this.polociesArr = response
                        this.responseAvailable = true
                    })
                    .catch((err) => {
                        console.log('ERROR LOG', err)
                    })
                this.displayPolicies = true
            }
        },
    },
    beforeMount() {
        this.FilterPolicy('p.policy_id')
    },
}
</script>

<style scoped>
.tableWrapper {
    padding: 1%;
    width: 100%;
}

.headerButton {
    border: none;
    background-color: inherit;
    color: inherit;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
}
.editButton {
    text-align: center;
    cursor: pointer;
    height: 100%;
}
.filterBar {
    padding: 1%;
    display: flex;
    flex-direction: row;
    align-items: center;
}
</style>
