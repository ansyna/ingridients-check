<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

            <div class="mt-8 text-2xl">
                Check you ingridients
            </div>

            <textarea placeholder="Enter your ingridients separated by comma" class="w-1/2 h-64"></textarea>
            <div class="mt-8">
                <button @click.native="load" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                    GO
                </button>
            </div>
        </div>
        <div>

        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
        methods: {
            load() {
                this.$inertia.get('/check-ingridients', { text: 'John' }, {
                    onSuccess: (page) => {
                        console.log(page.props.flash.message);
                    },
                });
            }
        }
    }
</script>
