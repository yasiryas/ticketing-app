export default function toast() {
    return {
        show: false,
        message: '',
        type: 'success',

        get typeClasses() {
            return {
                'bg-green-500/70 border-green-300/40': this.type === 'success',
                'bg-red-500/70 border-red-300/40': this.type === 'error',
                'bg-yellow-500/70 border-yellow-300/40': this.type === 'warning',
                'bg-indigo-500/70 border-indigo-300/40': this.type === 'info',
            }
        },

        init() {
            // 🔥 Listen JS event
            window.addEventListener('toast', e => {
                if (typeof e.detail === 'string') {
                    this.showToast(e.detail, 'success')
                } else {
                    this.showToast(
                        e.detail.message,
                        e.detail.type ?? 'success'
                    )
                }
            })

            // 🔥 Ambil dari data attribute (session)
            const sessionMessage = this.$el.dataset.message
            const sessionType = this.$el.dataset.type

            if (sessionMessage) {
                this.showToast(sessionMessage, sessionType ?? 'success')
            }
        },

        showToast(msg, type = 'success') {
            this.message = msg
            this.type = type
            this.show = true

            setTimeout(() => this.show = false, 3000)
        }
    }
}