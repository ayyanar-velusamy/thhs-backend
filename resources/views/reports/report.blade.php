@extends('layouts.app')
@section('content')
    <div class="table-heading-data ms-3 mt-3 d-flex align-items-center justify-content-between">
        <div>
            <h5>Reports</h5>
        </div>
        <div class="select-wrapper d-flex gap-4">
            <div class="add-staff-field d-flex align-items-center">
                <i class="icon icon-plus"></i>
                <p type="button" onclick="openCategoryPopup('category')">
                    Add Folder
                </p>
            </div>
            <div class="add-staff-field d-flex align-items-center">
                <i class="icon icon-plus"></i>
                <p type="button" onclick="openPopup()">
                    Add Report
                </p>

            </div>
        </div>

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
                <div class="reports-heading">Name</div>
                <div class="accordion" id="accordionExample">
                     
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false">
                                <i class="icon icon-caret-down me-2"></i>
                                <i class="icon icon-folder me-2"></i>
                                ARCHIVE
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                            <div class="accordion-body">
                                <!-- <p>
                          <i class="icon icon-file me-2"></i
                          ><span>Contract PT</span>
                        </p> -->
                                <!-- Inner Accordion -->
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="innerheadingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#innercollapseOne" aria-expanded="false">
                                                <i class="icon icon-caret-down me-2"></i>
                                                <i class="icon icon-folder me-2"></i>
                                                Inner ARCHIVE
                                            </button>
                                        </h2>
                                        <div id="innercollapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="innerheadingOne">
                                            <div class="accordion-body">
                                                <div class="file">
                                                    <i class="icon icon-file me-2"></i><span>Inner Contract PT</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Inner Accordion -->
                            </div>
                        </div>
                    </div>
                    @foreach ($categories as $category)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading_{{ $category->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse_{{ $category->id }}" aria-expanded="false">
                                <i class="icon icon-caret-down me-2"></i>
                                <i class="icon icon-folder me-2"></i>
                                {{@$category->name}}
                            </button>
                        </h2>
                        <div id="collapse_{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $category->id }}">
                            <div class="accordion-body">
                                <div class="file">
                                    <i class="icon icon-file me-2"></i><span>Contract PT</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-8">
                <div class="pdf-view-wrapper mt-4">
                    <iframe src="../sample.pdf" type="application/pdf" width="100%" height="800px" />
                </div>
            </div>
        </div>
    </div>
@endsection
