export default function unit() {
    return {

        // STATE
        units: {},
        search: '',
        loading: false,

        // INIT
        init() {
            this.fetchData()

            this.$watch('search', value => {
                this.fetchData()
            })
        },

        // FETCH DATA
        fetchData(url = '/units-data') {
            this.loading = true

            let fullUrl = url.includes('?')
                ? url + '&search=' + this.search
                : url + '?search=' + this.search

            fetch(fullUrl)
                .then(res => res.json())
                .then(data => {
                    this.units = data
                    this.loading = false
                })
        },

        // DELETE
        deleteUnit(id) {
            fetch(`/units/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                }
            })
            .then(() => {
                this.fetchData(this.units.current_page_url ?? '/units-data')

                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        message: 'Unit deleted',
                        type: 'success'
                    }
                }))
            })
        }
    }
}