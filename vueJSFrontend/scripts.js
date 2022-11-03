const app = new Vue({
    el: '#main',

    data: {
        result: ' ',
        responseAvailable: false,
    },

    methods: {
        fetchAPIData() {
            this.responseAvailable = false
            fetch('http://localhost:5174/index.php/user/list/policy?limit=20', {
                method: 'GET',
                // mode: 'no-cors',
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
                    console.log('-----------------------', response)
                    this.result = response
                    this.responseAvailable = true
                })
                .catch((err) => {
                    console.log('ERROR LOG', err)
                })
        },
    },
})
