<template>
    <!-- The Modal (contains the Sign Up form) -->
    <div class="modal">
        <form class="modalContent" v-on:submit.prevent="send" id="inputForm">
            <div class="container">
                <h1>{{ modalType }} Policy</h1>
                <p>Please Enter Policy Details.</p>
                <hr />
                <label for="policyType"><b>Policy Type</b></label>
                <input
                    type="text"
                    placeholder="Enter Policy Type"
                    name="policyType"
                    v-model="policyType"
                    required
                />
                <label for="policyPremium"><b>Policy Premium</b></label>
                <input
                    type="number"
                    placeholder="Enter Policy Premium"
                    name="policyPremium"
                    v-model.number="policyPremium"
                    required
                />
                <label for="insurerName"><b>Insurer name</b></label>
                <input
                    type="text"
                    placeholder="Enter Insurer name"
                    name="insurerName"
                    v-model="insurerName"
                    required
                />

                <label for="customer">Customer</label>
                <GeneralDropdown
                    id="customer"
                    name="customer"
                    :values="dropdownValues"
                    @emitFilter="updateDropdown"
                    :initialValue="initialId"
                />

                <div class="container" v-if="newCustomer == true">
                    <label for="customerName"><b>Customer Name</b></label>
                    <input
                        type="text"
                        placeholder="Enter Customer name"
                        name="customerName"
                        v-model="customerName"
                        required
                    />
                    <label for="customerAddress"><b>Customer Address</b></label>
                    <input
                        type="text"
                        placeholder="Enter Customer Address"
                        name="customerAddress"
                        v-model="customerAddress"
                        required
                    />
                </div>

                <div class="clearFix">
                    <button
                        type="button"
                        @click="closeModal"
                        class="cancelButton"
                    >
                        Cancel
                    </button>
                    <button type="submit" @click="submitFunction">
                        {{ modalType }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import GeneralDropdown from './GeneralDropdown.vue'
export default {
    name: 'PolicyModal',
    components: {
        GeneralDropdown,
    },
    props: {
        method: { type: Function },
        dropdownValues: { type: Array },
        modalType: { type: String },
        editData: { type: Array },
    },
    data() {
        return {
            newCustomer: false,
            customerId: 0,
            policyId: '',
            policyType: '',
            policyPremium: 0,
            insurerName: '',
            customerName: '',
            customerAddress: '',
            initialId: '',
        }
    },
    methods: {
        closeModal() {
            this.$emit('cancelFunction')
        },
        async submitFunction() {
            let submitData = {
                policyId: this.policyId,
                customerId: this.customerId,
                policyType: this.policyType,
                policyPremium: this.policyPremium,
                insurerName: this.insurerName,
                customerName: this.customerName,
                customerAddress: this.customerAddress,
            }
            this.$emit('submitFunction', submitData, this.customerId)
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
        //Maps the passed in data for the edit modal.
        mapData(data) {
            this.policyId = data.policy_id
            this.customerId = data.customer_id
            this.policyType = data.policy_type
            this.policyPremium = data.policy_premium
            this.insurerName = data.insurer_name
            this.customerName = data.customer_name
            this.customerAddress = data.customer_address
            this.initialId = data.customer_name + ', ' + data.customer_address
            // document.getElementById('policyType').value = data.policy_type
        },
    },
    beforeMount() {
        if (this.modalType == 'Edit') {
            this.mapData(this.editData)
        }
    },
    onUnmounted() {},
}
</script>

<style scoped>
* {
    box-sizing: border-box;
}
/* Full-width input fields */
input[type='text'],

/* Add a background color when the inputs get focus */
input[type='text']:focus,
input[type='password']:focus {
    /* background-color: #ddd; */
    outline: none;
    padding-bottom: 5px;
    padding-top: 5px;
}

/* Set a style for all buttons */
button {
    background-color: #ff6900;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

button:hover {
    opacity: 1;
}

/* Extra styles for the cancel button */
.cancelButton {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Add padding to container elements */
.container {
    display: flex;
    flex-direction: column;
    padding: 16px;
}

.modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    padding-top: 50px;
}

.modalContent {
    background-color: #171a1f;
    margin: 5% auto 15% auto;
    border: 1px solid #888;
    width: 80%;
}

hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

.clearFix {
    display: flex;
    flex-direction: 'row';
}
/* Clear floats */
.clearFix::after {
    content: '';
    clear: both;
    display: flex;
    flex-direction: 'row';
}
</style>
