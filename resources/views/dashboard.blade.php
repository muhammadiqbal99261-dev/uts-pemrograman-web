<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">
            <h1 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">
                {{ __('Dashboard') }}
            </h1>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                {{ __('You are logged in!') }}
            </p>
        </div>
    </div>
</x-layouts::app>
