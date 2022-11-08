<template>
    <!-- Button to open the modal -->
    <button @click="openModal">Create New Policy</button>

    <!-- Policy Modal for entering the data, send through props and methods needed -->
    <PolicyModal
        id="id01"
        :key="createModalKey"
        v-if="responseAvailable && showModal == true"
        :dropdownValues="dropdownValues"
        :modalType="modalType"
        @submitFunction="submitFunction"
        @cancelFunction="closeModal"
    />
</template>

<script>
import GeneralDropdown from './GeneralDropdown.vue'
import PolicyModal from './PolicyModal.vue'
import { ref } from 'vue'
import { SERVERURL } from '../constants'
export default {
    name: 'NewPolicy',
    components: {
        GeneralDropdown,
        PolicyModal,
    },
    props: {
        method: { type: Function },
        clientId: { type: Number },
    },
    data() {
        return {
            newCustomer: false,
            customerId: 0,
            dropdownValues: [
                { id: 'new', label: 'Create New Customer', value: 'new' },
            ],
            responseAvailable: false,
            modalType: 'Create',
            createModalKey: ref(0),
            showModal: false,
        }
    },
    methods: {
        openModal() {
            this.showModal = true
            document.getElementById('id01').style.display = 'block'
        },
        closeModal() {
            this.showModal = false
            document.getElementById('id01').style.display = 'none'
        },
        //The submit function handles the creation of a new policy, as well as the linking object and customer if needed.
        async submitFunction(formData, customerId) {
            let submitData = formData //Gets form data
            if (customerId != 'new') {
                submitData.customerId = customerId
            } else {
                let newId = await this.createCutomer(
                    submitData.customerName,
                    submitData.customerAddress
                )
                if (newId != undefined) {
                    submitData.customerId = newId
                }
                //Get Customer ID, create new cusomer, update formData
            }
            let newPolicy = await this.createPolicy(
                submitData.policyType,
                submitData.policyPremium,
                submitData.insurerName,
                submitData.customerId
            )
            // Run function to create policy
            if (newPolicy != undefined && this.clientId != '') {
                //then run the function to link the objects
                let newClientPolicy = await this.createClientPolicy(newPolicy)
                if (newClientPolicy != undefined) {
                    this.createModalKey += 1
                    document.getElementById('id01').style.display = 'none'
                    this.$emit('resetList', '')
                    this.showModal = false
                }
            } else {
                console.log('ITS Creating it with no client ID')
                document.getElementById('id01').style.display = 'none'
                this.$emit('resetList', '')
                this.showModal = false
            }
        },
        updateDropdown(value) {
            if (value == 'new') {
                this.newCustomer = true
                this.customerId = value
            } else {
                this.customerId = value
                this.newCustomer = false
            }
        },
        //Gets all the customers for the dropdown
        fetchCustomers() {
            fetch(SERVERURL + 'index.php/user/list/allCustomers', {
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
                    // this.policiesArr = response
                    for (let customer of response) {
                        this.dropdownValues.push({
                            id: customer.customer_id,
                            value: customer.customer_id,
                            label:
                                customer.customer_name +
                                ', ' +
                                customer.customer_address,
                        })
                    }
                    this.responseAvailable = true
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
        //Creates a customer object in the DB from the variables entered by the user via the modal, and returns the insterted ID.
        async createCutomer(name, address) {
            return await fetch(
                SERVERURL +
                    'index.php/user/insert/customer' +
                    '?customerName=' +
                    name +
                    '&customerAddress=' +
                    address,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'text/plain',
                    },
                }
            )
                .then(async (response) => {
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
                .then(async (response) => {
                    console.log('Customer Created', response)
                    return response
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
        //Creates the policy object via the rest api, and returns the objectId
        async createPolicy(type, premium, insurer, customer) {
            return await fetch(
                SERVERURL +
                    'index.php/user/insert/policy' +
                    '?policyType=' +
                    type +
                    '&policyPremium=' +
                    premium +
                    '&insurerName=' +
                    insurer +
                    '&customer=' +
                    customer,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'text/plain',
                    },
                }
            )
                .then(async (response) => {
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
                .then(async (response) => {
                    console.log('Policy Created', response)
                    return response
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
        //Creates the linking object between a client and a policy, using the new id provided from @createPolicy
        async createClientPolicy(policyId) {
            return await fetch(
                SERVERURL +
                    'index.php/user/insert/clientPolicy' +
                    '?clientId=' +
                    this.clientId +
                    '&policyId=' +
                    policyId,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'text/plain',
                    },
                }
            )
                .then(async (response) => {
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
                .then(async (response) => {
                    console.log('Client Policy Created', response)
                    return response
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
    },
    beforeMount() {
        //Fetches all the customers on mount for the dropdown in the modal
        this.fetchCustomers()
    },
}
</script>

<style scoped>
* {
    box-sizing: border-box;
}

input[type='text'],
/* background colour when the inputs get focus */
input[type='text']:focus,
input[type='password']:focus {
    outline: none;
    padding-bottom: 5px;
    padding-top: 5px;
}

/* Button Style */
button {
    background-color: #ff6900;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 50%;
    opacity: 0.9;
    border-radius: 10px;
}

button:hover {
    opacity: 1;
}
</style>
