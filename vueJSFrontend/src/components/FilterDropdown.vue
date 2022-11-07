<!-- General Filter Function, that takes in values and a function to send the filter value back to the parent -->
<template>
    <div class="container">
        <div class="row">
            <div class="dropdown">
                <i class="fa fa-filter"></i>
                <button @click="openFunction()" class="dropbtn">
                    Filter: {{ dropdownValue }}
                </button>
                <div id="filterDropdown" class="dropdown-content">
                    <div v-for="item in values" :key="item.id">
                        <a href="#" @click="changeFunction(item)">{{
                            item.label
                        }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FilterDropdown',
    components: {},
    props: {
        method: { type: Function },
        values: { type: Array },
    },
    data() {
        return {
            dropdownValue: '',
        }
    },

    methods: {
        openFunction() {
            document.getElementById('filterDropdown').classList.toggle('show')
        },
        changeFunction(value) {
            this.dropdownValue = value.label
            //Emit dropdown to parent class
            this.$emit('emitFilter', value.value)
            if (!event.target.matches('.dropbtn')) {
                var dropdowns =
                    document.getElementsByClassName('dropdown-content')
                var i
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i]
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show')
                    }
                }
            }
        },
    },
}
</script>
<style scoped>
.container {
    display: flex;
    flex: 1;
    background-color: #ff6900;
}
.dropbtn {
    display: flex;
    background-color: #ff6900;
    color: white;

    height: 100%;
    padding-top: 6px;
    padding-bottom: 6px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    flex: 1;
    padding-left: 5px;
}
.dropbtn:hover,
.dropbtn:focus {
    background-color: #eb9d65;
}
.dropdown {
    display: flex;
    flex: 1;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
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
