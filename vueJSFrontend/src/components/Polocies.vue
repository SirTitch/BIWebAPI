<template>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="container"></div>
    <div></div>
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
export default {
    name: 'Polocies',
    components: {},
    props: {
        method: { type: Function },
        clientId: { type: Number },
    },
    data() {
        return {
            polociesArr: [],
            displayPolicies: false,
            responseAvailable: false,
        }
    },
    methods: {
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
    /* border: none; */
    /* background-color: inherit; */
    /* color: inherit; */
    text-align: center;
    /* text-decoration: none; */
    cursor: pointer;
    height: 100%;
}
.tableContainer {
}
</style>
