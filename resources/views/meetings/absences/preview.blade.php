<x-auth-app>
    <x-card title="Meeting Attendance List">
        <p class="mb-1 fw-bolder text-primary">Project Profile</p>
        <h1 class="fw-bolder">{{ $project->name }}</h1>
        <h6>Created At {{ readDate($project->created_at) }}</h6>
        <div class="row align-items-center justify-content-between my-2">
            <div class="col">
                <h3>{{ $project->lead->fullname }}</h3>
            </div>
            <div class="col text-end">
                <p class="btn btn-warning btn-disabled">
                    {{ $project->status . ' | ' . $project->cycle }}</p>
            </div>
        </div>
        <p>{{ $project->description }}</p>
        <hr>
        <p class="mb-1 fw-bolder text-primary">Absences</p>
        <table class="table align-middle">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Notes</td>
                    <td>Action</td>
                    <td>Description</td>
                </tr>
            </thead>
            <tbody>
                <form action="{{ route('meetings.absence') }}" method="post">
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}" readonly hidden>
                    @csrf
                    @foreach ($employees as $key => $item)
                        @if ($item->status == 'ACTIVE')
                            <input type="hidden" name="data[{{ $key }}][id]" value="{{ @$item->absence->id }}"
                                readonly hidden>
                            <input type="hidden" name="data[{{ $key }}][employee_id]"
                                value="{{ $item->employee_id }}" readonly hidden>
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->profile->fullname }}</td>
                                <td>{{ $item->notes }}</td>
                                <td>
                                    @foreach ($status as $index => $absen)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="data[{{ $key }}][status]" id="{{ $key . $index }}"
                                                value="{{ $absen }}"
                                                {{ old('data.' . $key . '.status', @$item->absence->status) == $absen ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $key . $index }}">{{ $absen }}</label>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    <x-text-input name="data[{{ $key }}][notes]"
                                        value="{{ old('data.' . $key . '.notes', @$item->absence->notes) }}" />
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="4"></td>
                        <td>
                            @if ($update->action)
                                <div class="d-flex align-items-center" id="btn-action">
                                    <button type="submit" name="action" value="done"
                                        class="w-100 btn btn-success">Done</button>
                                    <button type="submit" name="action" value="skip"
                                        class="w-100 btn btn-link confirm-action">SKIP</button>
                                </div>
                            @endif
                            <div class="p-2 text-center">
                                <p class="mb-0 fw-bolder remaining">0 Days</p>
                                <p id="description">Your time to make a change</p>
                            </div>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </x-card>
    @push('script')
        <script>
            let timer;
            if ("{{ $meeting->status }}" == 'PLAN') {
                $(".remaining").remove();
                $("#description").text("Update absence data");
            } else {
                let compareDate = new Date("{{ $meeting->updated_at }}");
                compareDate.setDate(compareDate.getDate() + 3);
                timer = setInterval(function() {
                    timeBetweenDates(compareDate);
                }, 1000);

                function timeBetweenDates(toDate) {
                    let dateEntered = toDate;
                    let now = new Date();
                    let difference = dateEntered.getTime() - now.getTime();

                    if (difference <= 0) {
                        $("#btn-action").remove();
                        $(".remaining").remove();
                        $("#description").text("You cannot change the absence data");
                    } else {
                        let seconds = Math.floor(difference / 1000);
                        let minutes = Math.floor(seconds / 60);
                        let hours = Math.floor(minutes / 60);
                        let days = Math.floor(hours / 24);

                        hours %= 24;
                        minutes %= 60;
                        seconds %= 60;
                        $(".remaining").text(days + " Days " + hours + " Hours " + minutes + " Minutes " + seconds + " Seconds")
                    }
                }
            }
        </script>
    @endpush
</x-auth-app>
