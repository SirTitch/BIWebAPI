<!-- General Filter Function, that takes in values and a function to send the filter value back to the parent -->
<template>
    <div class="row">
        <div class="dropdown">
            <input
                class="dropdownButton"
                id="dropdownValue"
                @click="openFunction()"
                placeholder="Select Option"
                name="dropdownName"
                type="text"
                required
                v-model="dropdownValue"
            />
            <div id="generalDropdown" class="dropdown-content">
                <div v-for="item in values" :key="item.id">
                    <a href="#" @click="changeFunction(item)">{{
                        item.label
                    }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'GeneralDropdown',
    components: {},
    props: {
        method: { type: Function },
        values: { type: Array },
        initialValue: { type: String },
    },
    data() {
        return {
            dropdownValue: '',
        }
    },

    methods: {
        openFunction() {
            document.getElementById('dropdownValue').blur()
            document.getElementById('generalDropdown').classList.toggle('show')
        },
        changeFunction(value) {
            this.dropdownValue = value.label
            document.getElementById('dropdownValue').value = value.label
            document.getElementById('dropdownValue').blur()
            document.getElementById('generalDropdown').classList.toggle('show')

            //Emit dropdown to parent class
            this.$emit('emitFilter', value.value)
        },
    },
    beforeMount() {
        if (this.initialValue != undefined) {
            this.dropdownValue = this.initialValue
        }
    },
}
</script>
<style scoped>
* {
    margin: 0 !important;
    display: flex;
    width: 100%;
}
input[type='text'] {
    cursor: pointer;
    outline: none;
    padding-bottom: 5px;
    padding-top: 5px;
    display: flex;
    flex-grow: 1;
    z-index: 2;
}
.container {
    display: inline-block;
    width: inherit;
    background-color: #ff6900;
}
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 3;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.show {
    display: block;
}
</style>
