<x-auth-app>
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="text-dark mb-4">{{ $projectResume->planning->name }}</h5>
                <div class="d-flex justify-content-between">
                    <h1 class="mb-0 text-primary">
                        <i class="ti ti-bulb"></i>
                    </h1>
                    <h3 class="text-dark">{{ $projectResume->planning->value }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="text-dark mb-4">{{ $projectResume->development->name }}</h5>
                <div class="d-flex justify-content-between">
                    <h1 class="mb-0 text-primary">
                        <i class="ti ti-assembly"></i>
                    </h1>
                    <h3 class="text-dark">{{ $projectResume->development->value }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="text-dark mb-4">{{ $projectResume->published->name }}</h5>
                <div class="d-flex justify-content-between">
                    <h1 class="mb-0 text-primary">
                        <i class="ti ti-cloud-computing"></i>
                    </h1>
                    <h3 class="text-dark">{{ $projectResume->published->value }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="text-dark mb-4">{{ $projectResume->archive->name }}</h5>
                <div class="d-flex justify-content-between">
                    <h1 class="mb-0 text-primary">
                        <i class="ti ti-archive"></i>
                    </h1>
                    <h3 class="text-dark">{{ $projectResume->archive->value }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Activity Of The Year</h5>
                        </div>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Yearly Breakup -->
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Total Employee</h5>
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="fw-semibold mb-3">{{ array_sum($users->count) }} People</h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-center">
                                        <div id="breakup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- Monthly Earnings -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="card-title mb-0 fw-semibold"> Roles Comparison </h5>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-brand-asana fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="role_category"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>

        <script>
            let options = {
                series: [{
                    name: "Total Acitivy",
                    data: {!! json_encode($meetingResume['data']) !!}
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: '4',
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.4
                    },
                },
                xaxis: {
                    categories: {!! json_encode($meetingResume['label']) !!},
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

            var roleCount = {
                labels: {!! json_encode($users->label) !!},
                series: {!! json_encode($users->count) !!},
                chart: {
                    type: 'donut',
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 250
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#role_category"), roleCount);
            chart.render();
        </script>
    @endpush

</x-auth-app>
