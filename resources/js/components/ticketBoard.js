export default function ticketBoard() {
    return {
        open: [],
        progress: [],
        closed: [],

        form: {
            title: '',
            description: '',
            unit_id: ''
        },

        deleteId: null,

        init() {
            this.fetchTickets()

            window.addEventListener('ticket-create', () => {
                this.createTicket()
            })

            window.addEventListener('ticket-update', () => {
                this.updateTicket()
            })
        },

        fetchTickets() {
            fetch('/tickets-data')
                .then(res => res.json())
                .then(data => {
                    this.open = data.open
                    this.progress = data.progress
                    this.closed = data.closed
                })
        },

        createTicket() {
            fetch('/tickets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },
                body: JSON.stringify(this.form)
            })
            .then(async res => {
                if (res.redirected) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: 'Ticket berhasil dibuat!',
                        type: 'success'
                    }))
                    this.fetchTickets()
                    this.form = { title: '', description: '', unit_id: '' }
                    this.$dispatch('close-modal', 'create-ticket')
                    if (res.url) window.location.href = res.url
                    return
                }

                const data = await res.json().catch(() => ({}))
                if (!res.ok) throw data

                window.dispatchEvent(new CustomEvent('toast', {
                    detail: data.message || 'Ticket berhasil dibuat!',
                    type: 'success'
                }))

                this.fetchTickets()

                this.form = {
                    title: '',
                    description: '',
                    unit_id: ''
                }

                this.$dispatch('close-modal', 'create-ticket')
            })
            .catch(err => {
                let msg = err.errors?.title?.[0] ?? err.errors?.description?.[0] ?? 'Gagal membuat ticket'
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: msg,
                    type: 'error'
                }))
            })
        },

        editTicket(ticket) {
            window.editForm = {
                id: ticket.id,
                title: ticket.title,
                description: ticket.description,
                unit_id: ticket.unit_id,
                status: ticket.status
            }
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'edit-ticket'
            }))
            // Dispatch event untuk memberitahu modal bahwa data sudah siap
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('open-edit-modal'))
            }, 100)
        },

        updateTicket() {
            const id = window.editForm.id
            const form = {
                title: window.editForm.title,
                description: window.editForm.description,
                unit_id: window.editForm.unit_id,
                status: window.editForm.status
            }
            fetch(`/tickets/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },
                body: JSON.stringify(form)
            })
            .then(async res => {
                if (res.redirected) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: 'Ticket berhasil diupdate!',
                        type: 'success'
                    }))
                    this.fetchTickets()
                    this.form = { title: '', description: '', unit_id: '', status: '' }
                    this.$dispatch('close-modal', 'edit-ticket')
                    return
                }

                const data = await res.json().catch(() => ({}))
                if (!res.ok) throw data

                window.dispatchEvent(new CustomEvent('toast', {
                    detail: data.message || 'Ticket berhasil diupdate!',
                    type: 'success'
                }))

                this.fetchTickets()
                this.form = { title: '', description: '', unit_id: '', status: '' }
                this.$dispatch('close-modal', 'edit-ticket')
            })
            .catch(err => {
                let msg = err.errors?.title?.[0] ?? err.errors?.description?.[0] ?? 'Gagal mengupdate ticket'
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: msg,
                    type: 'error'
                }))
            })
        },

        deleteTicket(id) {
            window.deleteTicketId = id
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'confirm-delete-ticket'
            }))
        },

        confirmDeleteTicket() {
            const id = window.deleteTicketId
            fetch(`/tickets/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                }
            })
            .then(async res => {
                if (res.redirected) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: 'Ticket berhasil dihapus!',
                        type: 'success'
                    }))
                    this.fetchTickets()
                    this.$dispatch('close-modal', 'confirm-delete-ticket')
                    return
                }

                const data = await res.json().catch(() => ({}))
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: data.message || 'Ticket berhasil dihapus!',
                    type: 'success'
                }))
                this.fetchTickets()
                this.$dispatch('close-modal', 'confirm-delete-ticket')
            })
            .catch(() => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: 'Gagal menghapus ticket',
                    type: 'error'
                }))
            })
        }
    }
}
