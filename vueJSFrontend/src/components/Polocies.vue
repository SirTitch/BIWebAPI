<template>
    <div class="container"></div>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Policy Id</th>
                    <th>
                        <button
                            type="button"
                            @click="FilterPolicy('p.policy_type')"
                            class="btn btn-danger"
                        >
                            Policy Type
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
