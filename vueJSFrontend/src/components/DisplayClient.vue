<template>
    <div class="container">
        <h2>Clients</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Client Id</th>
                    <th>Client Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in clients" :key="item.id">
                    <td>{{ item.client_id }}</td>
                    <td>{{ item.client_name }}</td>
                    <td>
                        <button
                            type="button"
                            @click="
                                this.$emit(
                                    'emit-display-Policies',
                                    item.client_id
                                )
                            "
                            class="btn btn-danger"
                        >
                            View Policies
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'DisplayClient',
    props: {
        method: { type: Function },
        clients: { type: Object },
    },
}
</script>
