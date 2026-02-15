<div x-data="toastComponent()" x-init="init()" x-show="show" x-transition x-cloak
    class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999]">
    <div :class="typeClasses"
        class="px-6 py-3 rounded-xl shadow-xl backdrop-blur-lg border text-white font-medium min-w-[250px] text-center">
        <span x-text="message"></span>
    </div>
</div>

<script>
    function toastComponent() {
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
                // FROM SESSION (Laravel redirect)
                @if (session('success'))
                    this.showToast("{{ session('success') }}", "success");
                @endif

                @if (session('error'))
                    this.showToast("{{ session('error') }}", "error");
                @endif

                // FROM JS EVENT (fetch/AJAX)
                window.addEventListener('toast', e => {
                    if (typeof e.detail === 'string') {
                        this.showToast(e.detail, 'success');
                    } else {
                        this.showToast(e.detail.message, e.detail.type ?? 'success');
                    }
                });
            },

            showToast(msg, type = 'success') {
                this.message = msg;
                this.type = type;
                this.show = true;

                setTimeout(() => this.show = false, 3000);
            }
        }
    }
</script>
