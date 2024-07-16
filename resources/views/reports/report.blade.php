@extends('layouts.app')
@section('content')
    <div class="table-heading-data ms-3 mt-3 d-flex align-items-center justify-content-between">
        <div>
            <h5>Reports</h5>
        </div>
        <!-- <div class="select-wrapper d-flex gap-4">
            <div class="add-staff-field d-flex align-items-center">
                <i class="icon icon-plus"></i>
                <p type="button" onclick="openPopup()">
                    Add Report
                </p>

            </div>
        </div> -->
        {{-- <div class="select-wrapper d-flex gap-4">
            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Sort by: </label>
                <select class="form-control">
                    <option>Active</option>
                    <option>Deactive</option>
                </select>
            </div>
            <div class="location-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Sort by: </label>
                <select class="form-control">
                    <option>HHA Facility</option>
                    <option>Others</option>
                </select>
            </div>
        </div> --}}
    </div>
    <div class="hrdetail-wrapper m-3 bg-white overflow-scroll">
        <div class="row">
            <div class="col-lg-4">
                {{-- <div class="reports-heading">Name</div> --}}
                <div class="accordion" id="accordionExample">
                    @foreach ($categories as $category)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{ $category->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" onclick="openFolder('heading_{{ $category->id }}')"
                                    data-bs-target="#collapse_{{ $category->id }}" aria-expanded="false">
                                    <i class="icon icon-caret-down me-2"></i>
                                    <i class="icon icon-folder me-2"></i>
                                    {{ @$category->name }}
                                </button>
                            </h2>
                            <div id="collapse_{{ $category->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading_{{ $category->id }}">
                                <div class="accordion-body">
                                    @foreach ($category->reports as $report)
                                        <div class="file-data">
                                            <div class="file">
                                                <i class="icon icon-file me-2"></i><span>{{ $report->name }}</span>
                                            </div>
                                            <div class="actions">
                                                @php     
                                                if($report->report_exist){                            
                                                @endphp
                                                <a title="View Report" href="#"
                                                    onclick="open_viewer({{ json_encode($report) }})">
                                                    <i class="icon icon-eye-green"></i></a>
                                                @php                      
                                                }                  
                                                @endphp
                                                <a title="Edit Report" href="#"
                                                    onclick="get_report({{ $report->id }})">
                                                    <i class="icon icon-edit"></i></a>
                                                <a title="Edit Report" href="#"
                                                    onclick="open_designer({{ json_encode($report) }})">
                                                    <i class="icon icon-doc"></i></a>
                                                 
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-8">
                <div class="pdf-view-wrapper mt-4">
                    <iframe src="/thhs/designer" width="100%" height="800px" id="report_path"></iframe>

                </div>
            </div>
        </div>
    </div>
    <!-- Add Report -->
    <div class="modal fade" id="reportAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Add Report
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="report_form" method="POST" class="ajax-form" action="{{ route('save_report') }}"
                        role="form">
                        <div class="form-wrapper">
                            <div class="field-wrapper d-block">
                                <label for="group">Folder :<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <select required class="select-control" name="category">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ @$category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="field-wrapper d-block">
                                <label for="group">Report Name :<span class="mandate">*</span></label>
                                <div class="flex-field">
                                    <input type="hidden" name="id" id="id" placeholder="Name" />
                                    <input required type="text" name="name" id="name" placeholder="Name" />
                                </div>
                            </div>
                            <div class="cta_wrapper d-flex justify-content-center gap-5">
                                <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                                <button class="success" id="save_report_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
