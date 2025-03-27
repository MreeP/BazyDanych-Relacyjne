export default (eventName = 'inform-user') => ({
    showing: false,
    message: '',

    text_container: {
        ['x-html']() {
            return this.message;
        }
    },

    close_button: {
        ['x-on:click']() {
            this.showing = false;
            clearTimeout(this.timeout);
        }
    },

    notification_body: {
        ['x-show']() {
            return this.showing;
        },
        ['x-on:' + eventName + '.dot.document'](event) {
            this.message = event.detail.message;
            this.showing = true;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.showing = false, event.detail.duration);
        },
        'x-transition:enter': "transition ease-out duration-300",
        'x-transition:enter-start': "translate-y-2 sm:translate-y-0 sm:translate-x-2 opacity-0",
        'x-transition:enter-end': "translate-y-0 opacity-100 sm:translate-x-0",
        'x-transition:leave': "transition ease-in duration-100",
        'x-transition:leave-start': "opacity-100",
        'x-transition:leave-end': "opacity-0",
    },
});
