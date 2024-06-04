@extends('layouts.app')
@section('content')
    <!-- Dashboard Table -->

    <section class="table-wrapper bg-white">
        <div class="dropdowns-section d-flex justify-content-end align-items-center">
            {{-- <div class="location-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Location: </label>
                <select class="form-control" id="filter_organization">
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->name }}" {{ @$selected }}>{{ @$organization->name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Category: </label>
                <select class="form-control" id="filter_category">
                    <option value="">All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ @$category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>Chart Manager</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p type="button" onclick="openCategoryPopup('category')">
                        Add Category
                    </p>
                </div>
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p type="button" onclick="openPopup()">
                        Add Chart Manager
                    </p>

                </div>
            </div>
        </div>
        <table class="w-100" id="chart_datatable">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Chart</th>
                    <th>Handling</th>
                    <th>Report Name</th>
                    <th>Required</th>
                    <th>Valid For</th>
                    <th>Renewal Period</th>
                    <th>Must Provide</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chart_list as $chart)
                    <tr>
                        @php
                            if ($chart->required == 1) {
                                $required = 'True';
                            } else {
                                $required = 'False';
                            }
                        @endphp
                        <td class="dt-center align-items-center">
                            {{ $chart->category }}
                        </td>

                        <td>
                            {{ $chart->name }}
                        </td>
                        <td> {{ $chart->chart_handling }}</td>
                        <td>{{ $chart->report }}</td>
                        <td><span
                                class="tag {{ $chart->required == 1 ? 'active' : 'deactivate' }}">{{ $required }}</span>
                        </td>
                        <td>
                            {{ $chart->valid_number }} {{ $chart->valid_interval }}
                        </td>
                        <td>{{ $chart->renewal_number }} {{ $chart->renewal_interval }}</td>
                        <td>{{ $chart->provide_number }} {{ $chart->provide_interval }}</td>
                        <td class="icons d-block" style="padding-top:10px; top: -2px">
                            {{-- <a title="View Staff" href="{{ route('staffs.demographics', [$chart->id]) }}"><i
                                    class="icon icon-eye-green"></i></a> --}}
                            <a title="Edit Chart" href="#" onclick="get_chart({{ $chart->id }})">
                                <i class="icon icon-edit"></i></a>
                            <a title="Delete Chart" href="#" id="delete_chart_btn"
                                data-url="{{ @route('delete_chart', [$chart->id]) }}"
                                onclick="delete_chart_confirmation()">
                                <i class="icon icon-delete"></i></a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper with-data-table d-flex justify-content-center align-items-center pt-0">
            <!-- <div class="count-text">
                                                                                                                        <p>Showing data 1 to 8 of 256 entries</p>
                                                                                                                      </div> -->
            <!-- <div class="data-section d-flex justify-content-between align-items-center gap-4">
                        <div class="green d-flex justify-content-center align-items-center">
                            <span></span>
                            <p>All clear</p>
                        </div>
                        <div class="yellow d-flex justify-content-center align-items-center">
                            <span></span>
                            <p>Doc about to expire</p>
                        </div>
                        <div class="red d-flex justify-content-center align-items-center">
                            <span></span>
                            <p>Already expired</p>
                        </div>
                    </div> -->

        </div>
    </section>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-body">
            <form id="save_chart_form" method="POST" class="ajax-form" action="{{ route('save_chart') }}" role="form">
                <input type="hidden" name="id" />
                <div class="form-wrapper">
                    <div class="heading-wrapper mt-0 d-flex justify-content-between align-items-center">
                        <h5>Chart Manager (80)</h5>
                        <p type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></p>
                    </div>
                    <div class="field-wrapper">
                        <label for="group">Group :<span class="mandate">*</span></label>
                        <div class="flex-field">
                            <select required class="select-control" name="group">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ @$category->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="name">Name<span class="mandate">*</span></label>
                        <div class="flex-field">
                            <input type="text" id="name" name="name" placeholder="Name" required />
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label class="form-check-label" for="flexCheckDefault">
                            Required
                        </label>
                        <div class="flex-field">
                            <input class="form-check-input" type="checkbox" name="required" value="1"
                                id="flexCheckDefault" />
                        </div>
                    </div>
                    <div class="heading-wrapper d-flex justify-content-between">
                        <h5>Chart Valid For</h5>
                        <h5>Renewal Notification</h5>
                    </div>
                    <div class="two-column-field">
                        <div>
                            <div class="field-wrapper gap-5">
                                <label for="valid_interval">Valid For Interval :<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <select required class="select-control" name="valid_interval" required>
                                        @foreach ($intervals as $interval)
                                            <option value="{{ $interval->id }}">{{ @$interval->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="field-wrapper gap-5 mt-4">
                                <label for="valid_number">Number<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <input type="number" id="valid_number" name="valid_number" placeholder="Number"
                                        required />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="field-wrapper gap-5">
                                <label for="renewal_interval">Renewal Interval:<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <select required class="select-control" name="renewal_interval" required>
                                        @foreach ($intervals as $interval)
                                            <option value="{{ $interval->id }}">{{ @$interval->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="field-wrapper gap-5 mt-4">
                                <label for="renewal_number">Number<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <input type="number" id="renewal_number" name="renewal_number" placeholder="Number"
                                        required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="heading-wrapper d-flex justify-content-between">
                        <h5>Must Provide</h5>
                    </div>
                    <div class="field-wrapper">
                        <label for="provide_interval">Must Provide Interval:<span class="mandate">*</span></label>
                        <div class="flex-field">
                            <select required class="select-control" name="provide_interval" required>
                                @foreach ($intervals as $interval)
                                    <option value="{{ $interval->id }}">{{ @$interval->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="provide_number">Number<span class="mandate">*</span></label>
                        <div class="flex-field">
                            <input type="number" id="provide_number" name="provide_number" placeholder="Number"
                                required />
                        </div>
                    </div>
                    <div class="heading-wrapper d-flex justify-content-between">
                        <h5>Chart Property (For internal use)</h5>
                    </div>
                    <div class="field-wrapper">
                        <label for="report">Report :</label>
                        <div class="flex-field">
                            {{-- <select required class="select-control" name="report">
                                <option value="1">Report 1</option>
                                <option value="2">Report 2</option>
                            </select> --}}
                            <input type="text" id="report" name="report" placeholder="Report Name" />
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="chart_handling">Chart Handling:<span class="mandate">*</span></label>
                        <div class="flex-field">
                            <select required class="select-control" name="chart_handling" required>
                                @foreach ($handlings as $handling)
                                    <option value="{{ $handling->id }}">{{ @$handling->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="field-wrapper">
                        <label for="positions">Assign Position :</label>
                        <div class="flex-field">
                            <select id="positions" class="select2 select-control" name="positions[]"
                                placeholder="Select Positions" required multiple="multiple">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ @$position->short_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="cta_wrapper d-flex justify-content-end gap-5 mt-5">
                    <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                    <button class="success" id="save_chart_btn">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Chart Category -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Add Category
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="chart_category_form" method="POST" class="ajax-form"
                        action="{{ route('save_chart_category') }}" role="form">
                        <div class="form-wrapper">
                            <div class="field-wrapper d-block">
                                <input required type="text" name="category" id="category" placeholder="Category" />

                            </div>
                            <div class="cta_wrapper d-flex justify-content-center gap-5">
                                <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                                <button class="success" id="save_chart_category_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
