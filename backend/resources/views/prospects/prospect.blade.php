@extends('layouts.app')
@section('content')
    <!-- Dashboard Table -->

    <link href="{{ asset('css/staff_manager.css') }}" rel="stylesheet" />
    <section class="table-wrapper bg-white">
        <div class="dropdowns-section d-flex justify-content-end align-items-center">

            <div class="status-wrapper d-flex justify-content-center align-items-center">
                <label class="me-3">Status: </label>
                <select class="form-control">
                    <option>Active</option>
                    <option>Deactive</option>
                </select>
            </div>
        </div>
        <div class="table-heading-data d-flex align-items-center justify-content-between">
            <h5>Prospect Manager</h5>
            <div class="table-center-heading-data d-flex align-items-center justify-content-between">
                <!-- <div class="forms-report d-flex align-items-center"> -->
                <!-- <i class="icon icon-form-report"></i> -->
                <!-- <div class="div-5">Expiring Forms Report</div> -->
                <!-- </div> -->
                <!-- <div -->
                <!-- class="expired-docs d-flex align-items-center justify-content-center" -->
                <!-- > -->
                <!-- <div class="div-7">View Expired docs:</div> -->
                <!-- <div class="checkbox-tick-wrapper d-flex align-items-center"> -->
                <!-- <label class="d-flex align-items-center"> -->
                <!-- <input type="checkbox" value="" /> -->
                <!-- <span class="cr" -->
                <!-- ><i class="icon icon-tick-white"></i -->
                <!-- ></span> -->
                <!-- All -->
                <!-- </label> -->
                <!-- </div> -->
                <!-- <div class="checkbox-tick-wrapper d-flex align-items-center"> -->
                <!-- <label class="d-flex align-items-center"> -->
                <!-- <input type="checkbox" value="" /> -->
                <!-- <span class="cr" -->
                <!-- ><i class="icon icon-tick-white"></i -->
                <!-- ></span> -->
                <!-- 07 -->
                <!-- </label> -->
                <!-- </div> -->
                <!-- <div class="checkbox-tick-wrapper d-flex align-items-center"> -->
                <!-- <label class="d-flex align-items-center"> -->
                <!-- <input type="checkbox" value="" /> -->
                <!-- <span class="cr" -->
                <!-- ><i class="icon icon-tick-white"></i -->
                <!-- ></span> -->
                <!-- 14 -->
                <!-- </label> -->
                <!-- </div> -->
                <!-- <div class="checkbox-tick-wrapper d-flex align-items-center"> -->
                <!-- <label class="d-flex align-items-center"> -->
                <!-- <input type="checkbox" value="" /> -->
                <!-- <span class="cr" -->
                <!-- ><i class="icon icon-tick-white"></i -->
                <!-- ></span> -->
                <!-- 30 -->
                <!-- </label> -->
                <!-- </div> -->
                <!-- </div> -->
                <div class="add-staff-field d-flex align-items-center">
                    <i class="icon icon-plus"></i>
                    <p data-toggle="modal" data-target="#myModal">Add Prospect Manager</p>
                </div>
            </div>
        </div>
        <table class="w-100" id="datatable">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Zip Code</th>
                    <th>Status</th>
                    <th>Submit Date</th>
                    <th>Date Hired</th>
                    <th>Interview Scheduled Date</th>
                    <th>Interview Confirmed Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prospect_list as $prospect)
                    <tr>
                        <td class="d-flex align-items-center" style="gap: 7px">
                            {{ $prospect->name }}
                        </td>
                       
                        <!-- <td>{{$prospect->name}}</td> -->
                        <td>{{ $prospect->position }}</td>
                        <td>{{ $prospect->cellular }}</td>
                        <td>
                            {{ $prospect->address }}<br>{{ $prospect->state, $prospect->city }}
                        </td>
                        <td>{{ $prospect->zip }}</td>
                        <td><span class="tag active">Applied</span></td>
                        <td>{{ update_date_format($prospect->created_at,"m-d-Y") }}</td>
                        
                        <td>{{ " " }}</td>
                        <td>{{" "}}</td>
                        <td>{{" "}}</td>
                        
                        <td class="icons">
                            <a href="/thhs/app/prospects/demographics/{{ $prospect->id }}"><i
                                    class="icon icon-eye-green"></i></a>
                            <i class="icon icon-edit"></i>
                            <i class="icon icon-delete"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <!-- <tfoot>
                      <tr>
                        <th></th>
                        <th>Full Name</th>
                          <th>Phone</th>
                          <th>Date Hired</th>
                          <th>Gender</th>
                          <th>Position</th>
                          <th>Address</th>
                          <th>Status</th>
                          <th>Employment Type</th>
                          <th>Termination Date</th>
                          <th>Action</th>
                        </tr>
                      </tfoot> -->
        </table>
        <div class="pagination-wrapper with-data-table d-flex justify-content-center align-items-center pt-0">
            <!-- <div class="count-text">
                        <p>Showing data 1 to 8 of 256 entries</p>
                      </div> -->
            <div class="data-section d-flex justify-content-between align-items-center gap-4">
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
            </div>
            <!-- <nav class="d-flex align-items-center">
                        <ul class="pagination pagination-sm">
                          <li class="page-item">
                            <a href="#"><i class="icon icon-prev"></i></a>
                          </li>
                          <li class="page-item active" aria-current="page">
                            <a class="active">1</a>
                          </li>
                          <li class="page-item"><a href="#">2</a></li>
                          <li class="page-item"><a href="#">3</a></li>
                          <li class="page-item"><a href="#">...</a></li>
                          <li class="page-item"><a href="#">99</a></li>
                          <li class="page-item"><a href="#">100</a></li>
                          <li class="page-item">
                            <a href="#"><i class="icon icon-next"></i></a>
                          </li>
                        </ul>
                      </nav> -->
        </div>
    </section>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Add Prospect manager
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="add_prospect_form" method="POST"  class="ajax-form" action="{{route('add_prospect')}}" role="form">
                        <div class="form-wrapper">
                            <div class="field-wrapper">
                                <label for="fname">First name<span class="mandate">*</span></label>
                                <input type="text" id="fname" name="firstname" placeholder="First name"
                                    required />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Last name<span class="mandate">*</span></label>
                                <input type="text" name="lastname" placeholder="Last name" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Email<span class="mandate">*</span></label>
                                <input type="email" id="lname" name="email" placeholder="Email" required />
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Birth date</label>
                                <div id="dob" class="date" data-date-format="dd/mm/yyyy">
                                    <input required type="text" name="dob" id="dob" readonly
                                        placeholder="DOB" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <label for="mname">Position :<span class="mandate">*</span></label>
                                <select required class="select-control" name="position" required>

                                    <option value="">Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}" {{ @$selected }}>
                                            {{ @$position->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field-wrapper">
                                <label for="fname">Submit date</label>
                                <div id="submit_date" class="date" data-date-format="mm/dd/yyyy">
                                    <input required type="text" name="submit_date" readonly
                                        placeholder="Submit date" />
                                    <span class="input-group-addon d-none">
                                        <i class="icon icon-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="cta_wrapper d-flex justify-content-center gap-5">
                            <button class="danger" data-dismiss="modal">Cancel</button>
                            <button class="success" id="add_prospect_btn">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
