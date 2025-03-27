export default () => ({
    opened: false,

    toggle() {
        this.opened = !this.opened
    },

    open() {
        this.opened = true
    },

    close() {
        this.opened = false
    },

    openingTrigger: {
        ['@click']() {
            this.open()
        }
    },

    closingTrigger: {
        ['@click']() {
            this.close()
        }
    },

    togglingTrigger: {
        ['@click']() {
            this.toggle()
        }
    },

    areaOfInterest: {
        ['@click.outside']() {
            return this.close()
        },
    },

    slideFromLeft: {
        ['x-show']() {
            return this.opened
        },
        'x-transition:enter': "transition ease-in-out duration-300",
        'x-transition:enter-start': "-translate-x-full",
        'x-transition:enter-end': "translate-x-0",
        'x-transition:leave': "transition ease-in-out duration-300",
        'x-transition:leave-start': "translate-x-0",
        'x-transition:leave-end': "-translate-x-full",
    },

    fadeIn: {
        ['x-show']() {
            return this.opened
        },
        'x-transition:enter': "transition ease-linear duration-300",
        'x-transition:enter-start': "opacity-0",
        'x-transition:enter-end': "opacity-100",
        'x-transition:leave': "transition ease-linear duration-300",
        'x-transition:leave-start': "opacity-100",
        'x-transition:leave-end': "opacity-0",
    },
});
