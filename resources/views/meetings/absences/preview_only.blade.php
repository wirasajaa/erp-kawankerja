<x-auth-app>
    <x-card title="Meeting Absences">
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
                    <td>Status</td>
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
                                    {{ @$item->absence->status ?? 'Not Set' }}
                                </td>
                                <td>
                                    {{ @$item->absence->notes ?? 'Not Set' }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
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
