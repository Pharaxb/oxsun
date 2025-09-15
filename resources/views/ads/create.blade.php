@extends('layouts.admin')

@section('content')
    <!-- Create Ad Page -->
    <div id="page-create-ad" class="page-content">
        <h1 class="h3 mb-4">افزودن آگهی</h1>

        <form id="createAdForm" method="post" action="{{ route('ads.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- بخش اطلاعات اصلی آگهی -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">اطلاعات اصلی آگهی</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان آگهی</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea class="form-control" id="description" rows="4" name="description">{{ old('description') }}</textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="circulation" class="form-label">تیراژ آگهی</label>
                            <input type="number" class="form-control" id="circulation" min="100" name="circulation" value="{{ old('circulation', 100) }}">
                            @error('circulation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cost" class="form-label">هزینه هر آگهی (تومان)</label>
                            <input type="number" class="form-control" id="cost" min="10000" name="cost" value="{{ old('cost', 10000) }}">
                            @error('cost') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">فایل آگهی</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">آپلود فایل (ویدیو یا عکس)</label>
                        <div class="file-upload-wrapper">
                            <input type="file" id="file" name="file" class="file-upload-input">
                            @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p class="mb-0 mt-2">فایل خود را اینجا بکشید یا برای انتخاب کلیک کنید</p>
                            <div id="fileName" dir="ltr">{{ old('file') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- بخش فیلترها -->
            <div class="accordion mb-3" id="filtersAccordion">
                <div class="accordion-item card">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="true" aria-controls="collapseFilters">
                            <i class="fas fa-filter ms-2"></i>
                            فیلترهای هدف‌گیری مخاطب (اختیاری)
                        </button>
                    </h2>
                    <div id="collapseFilters" class="accordion-collapse collapse show" data-bs-parent="#filtersAccordion">
                        <div class="card-body">
                            <!-- جنسیت و اوپراتور -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">جنسیت</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderAll" value="all" checked>
                                            <label class="form-check-label" for="genderAll">همه</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male">
                                            <label class="form-check-label" for="genderMale">مرد</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female">
                                            <label class="form-check-label" for="genderFemale">زن</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">اوپراتور موبایل</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="operator" id="operatorAll" value="0" checked>
                                            <label class="form-check-label" for="operatorAll">همه</label>
                                        </div>
                                        @foreach($operators as $operator)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="operator" id="{{ $operator->brand }}" value="{{ $operator->id }}">
                                                <label class="form-check-label" for="{{ $operator->brand }}">{{ $operator->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- محدوده سنی -->
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="ageFilter" name="ageFilter">
                                <label class="form-check-label" for="ageFilter">اعمال فیلتر سنی</label>
                            </div>
                            <div id="ageFilterSection">
                                <div class="mb-3">
                                    <label for="min_age" class="form-label range-slider-label" id="min_age_label">حداقل سن: <span>20</span> سال</label>
                                    <input type="range" class="form-range" id="min_age" name="min_age" min="10" max="100" step="5" value="{{ old('min_age', 20) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="max_age" class="form-label range-slider-label" id="max_age_label">حداکثر سن: <span>50</span> سال</label>
                                    <input type="range" class="form-range" id="max_age" name="max_age" min="10" max="100" step="5" value="{{ old('max_age', 50) }}">
                                </div>
                            </div>

                            <!-- تاریخ شروع و پایان -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">تاریخ شروع</label>
                                    <input type="text" class="form-control text-center start_date" name="start_date" id="start_date" value="{{ old('start_date') }}" readonly>
                                    @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">تاریخ پایان</label>
                                    <input type="text" class="form-control text-center end_date" name="end_date" id="end_date" value="{{ old('end_date') }}" readonly>
                                    @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- انتخاب استان، شهر، منطقه -->
                            <div>
                                <label class="form-label">موقعیت جغرافیایی</label>
                                <p class="form-text mt-0 mb-2">نام استان، شهر یا منطقه را برای افزودن جستجو کنید.</p>
                                <div class="row g-3">
                                    <div class="col-12 mb-2">
                                        <label for="selectedProvinces" class="form-label small">استان‌ها</label>
                                        <select class="form-select form-select2" id="selectedProvinces" name="selectedProvinces[]" multiple>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('province-select') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="selectedCities" class="form-label small">شهرها</label>
                                        <select class="form-select form-select2" id="selectedCities" name="selectedCities[]" multiple>
                                            {{--@foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="selectedDistrict" class="form-label small">مناطق</label>
                                        <select class="form-select form-select2" id="selectedDistrict" name="selectedDistrict[]" multiple>
                                            {{--@foreach($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- انتخاب استان، شهر، منطقه -->
                            {{--<div>
                                <label class="form-label">موقعیت جغرافیایی</label>
                                <p class="form-text mt-0 mb-2">برای انتخاب چند گزینه، کلید Ctrl (یا Cmd در مک) را نگه دارید.</p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <select class="form-select" id="province" multiple size="4">
                                            <option value="1">تهران</option>
                                            <option value="2">اصفهان</option>
                                            <option value="3">خراسان رضوی</option>
                                            <option value="4">فارس</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select" id="city" multiple size="4">
                                            <!-- Cities should be loaded dynamically via JS -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select" id="region" multiple size="4">
                                            <!-- Regions should be loaded dynamically via JS -->
                                        </select>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div id="progressContainer" class="mb-3" style="display: none;">
                <div class="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%">0%</div>
                </div>
                <p id="progressText" class="mt-2">در حال آپلود...</p>
            </div>

            <!-- دکمه‌های عملیات -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">ذخیره و ایجاد آگهی</button>
                <a href="#" class="btn btn-secondary px-4 ms-2">انصراف</a>
            </div>
        </form>
    </div>
@endsection
@section('js-scripts')
    <script type="module">
        $( document ).ready( function () {

            let to, from;
            to = $("#end_date").pDatepicker({
                initialValue: false,
                autoClose: true,
                format: 'YYYY/MM/DD',
                onSelect: function (unix) {
                    to.touched = true;
                    if (from && from.options && from.options.maxDate != unix) {
                        var cachedValue = from.getState().selected.unixDate;
                        from.options = {maxDate: unix};
                        if (from.touched) {
                            from.setDate(cachedValue);
                        }
                    }
                }
            });
            from = $("#start_date").pDatepicker({
                initialValue: false,
                autoClose: true,
                format: 'YYYY/MM/DD',
                onSelect: function (unix) {
                    from.touched = true;
                    if (to && to.options && to.options.minDate != unix) {
                        var cachedValue = to.getState().selected.unixDate;
                        to.options = {minDate: unix};
                        if (to.touched) {
                            to.setDate(cachedValue);
                        }
                    }
                }
            });

            // --- Form Submission with Progress Bar ---
            /*const adForm = document.getElementById('createAdForm');
            const uploadProgressContainer = document.getElementById('uploadProgressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const actionButtons = document.getElementById('actionButtons');


            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('fileName');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                    } else {
                        fileNameDisplay.textContent = '';
                    }
                });
            }



            adForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                if (fileInput.files.length === 0) {
                    // If you want to allow submission without a file, handle it here.
                    // For now, we'll just submit the form normally.
                    // Or show an alert:
                    alert('لطفا یک فایل برای آگهی انتخاب کنید.');
                    return;
                }

                // Show progress bar and hide buttons
                actionButtons.classList.add('d-none');
                uploadProgressContainer.classList.remove('d-none');

                // --- SIMULATING UPLOAD ---
                // In a real application, you would use XMLHttpRequest or Fetch API
                // to upload the file and get progress events from the server.
                let progress = 0;
                progressBar.style.width = '0%';
                progressBar.textContent = '0%';
                progressBar.classList.remove('bg-success');
                progressText.textContent = 'در حال آپلود فایل...';

                const interval = setInterval(() => {
                    progress += Math.floor(Math.random() * 10) + 5;
                    if (progress > 100) {
                        progress = 100;
                    }

                    progressBar.style.width = progress + '%';
                    progressBar.textContent = progress + '%';
                    progressBar.setAttribute('aria-valuenow', progress);

                    if (progress === 100) {
                        clearInterval(interval);
                        progressBar.classList.add('bg-success');
                        progressText.textContent = 'آپلود با موفقیت انجام شد! در حال ذخیره اطلاعات...';

                        // Simulate final save after upload
                        setTimeout(() => {
                            // Here you would typically get a success response from the server
                            // and then redirect or show a final success message.
                            alert('آگهی شما با موفقیت ایجاد شد.');
                            // Example: window.location.href = '/dashboard';

                            // Reset form for this demo
                            adForm.reset();
                            fileNameDisplay.textContent = '';
                            uploadProgressContainer.classList.add('d-none');
                            actionButtons.classList.remove('d-none');
                        }, 1500);
                    }
                }, 300);
            });*/

            $(".form-select2").select2({
                theme: "bootstrap-5"
            });

            $("#province-select").on("change", function () {
                let data = $(this).val();
            });

            $("#city-select").on("change", function () {
                let data = $(this).val();
            });
        })
    </script>
@endsection
