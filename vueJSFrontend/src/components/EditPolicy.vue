<template>
    <!-- Button to open the modal -->
    <button @click="openModal" class="button">
        <i class="fa fa-edit"></i>
        Edit Policy
    </button>

    <!-- Policy Modal for entering the data, send through props and methods needed -->
    <PolicyModal
        id="id02"
        :key="createModalKey"
        v-if="responseAvailable && showModal == true"
        :dropdownValues="dropdownValues"
        :modalType="modalType"
        @submitFunction="submitFunction"
        @cancelFunction="closeModal"
        :editData="editItem"
    />
</template>

<script>
import GeneralDropdown from './GeneralDropdown.vue'
import PolicyModal from './PolicyModal.vue'
import { ref } from 'vue'
import { SERVERURL } from '../constants'
export default {
    name: 'EditPolicy',
    components: {
        GeneralDropdown,
        PolicyModal,
    },
    props: {
        method: { type: Function },
        clientId: { type: Number },
        editItem: { type: Object },
    },
    data() {
        return {
            newCustomer: false,
            customerId: 0,
            dropdownValues: [
                { id: 'new', label: 'Create New Customer', value: 'new' },
            ],
            responseAvailable: false,
            modalType: 'Edit',
            createModalKey: ref(0),
            showModal: false,
        }
    },
    methods: {
        openModal() {
            this.showModal = true
            document.getElementById('id02').style.display = 'block'
        },
        closeModal() {
            this.showModal = false
            document.getElementById('id02').style.display = 'none'
        },
        //Calls the edit function and updates the object accordingly. Also creates a new customer if that option is selected
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
            let newPolicy = await this.updatePolicy(
                submitData.policyType,
                submitData.policyPremium,
                submitData.insurerName,
                submitData.customerId,
                submitData.policyId
            )
            // Run function to create policy
            if (newPolicy != undefined) {
                document.getElementById('id02').style.display = 'none'
                this.$emit('resetList', '')
                this.showModal = false
            } else {
                document.getElementById('id02').style.display = 'none'
                this.$emit('resetList', '')
                this.showModal = false
            }
        },
        //Callback from the dropdown to update the customer id if a current or new one is selected.
        updateDropdown(value) {
            if (value == 'new') {
                this.newCustomer = true
                this.customerId = value
            } else {
                this.customerId = value
                this.newCustomer = false
            }
        },
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
        //Creates a new customer object using the api and data provided in the modal.
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
        //Triggers the update function on the api and returns when its true
        async updatePolicy(type, premium, insurer, customer, id) {
            return await fetch(
                SERVERURL +
                    'index.php/user/update/policy' +
                    '?policyType=' +
                    type +
                    '&policyPremium=' +
                    premium +
                    '&insurerName=' +
                    insurer +
                    '&customer=' +
                    customer +
                    '&policyId=' +
                    id,
                {
                    method: 'PUT',
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
    },
    beforeMount() {
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
.button {
    background-color: #ff6900;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
    border-radius: 10px;
}

button:hover {
    opacity: 1;
    background-color: #ff9c56;
}
</style>
