<x-auth-app>
    <x-card title="Add new employee">
        <x-layouts.employees.form-create :maritals="$maritals" :religions="$religions" :blood_type="$blood_type" :url="route('employees.store')" />
    </x-card>
</x-auth-app>
