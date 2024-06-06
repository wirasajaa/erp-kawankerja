<x-app>
    <div class="container">
        <div class="row justify-content-center my-3">
            <div class="col-md-7">
                <x-card title="Registration Form">
                    <x-layouts.employees.form-create :maritals="$maritals" :religions="$religions" :blood_type="$blood_type"
                        :url="route('register.store')" />
                </x-card>
            </div>
        </div>
    </div>
</x-app>
