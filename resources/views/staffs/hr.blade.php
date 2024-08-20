@extends('layouts.app')
@section('content')
    <div class="hrdetail-wrapper m-3 bg-white">
        <div class="row">
            <div class="col-lg-6 first-col overflow-scroll">
                <div class="hrdetail-header">
                    <div class="cta_section d-flex justify-content-between">
                        <!-- <button class="button">
                <i class="icon icon-send-email me-3"></i>Send Reminder
                Email
              </button> -->
              
                        <button class="button" onclick="location.reload()">Refresh All Forms</button>
                        <div>
                            <span class="me-3">Generated :</span>
                            <button id="toggle-button" class="button" onclick="toggleAllAccordions()">
                                Expand
                            </button>
                        </div>
                    </div>
                    <div class="checkbox-list-wrapper d-flex mt-5 justify-content-between align-items-center">
                        <div class="checkbox-list d-flex gap-4">
                            <div class="field-wrapper d-flex align-items-center">
                                <label class="form-check-label me-2" for="flexCheckDefault">
                                    Show Expired:
                                </label>
                                <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" />
                            </div>
                            <!-- <div class="field-wrapper d-flex align-items-center">
                                <label class="form-check-label me-2" for="">
                                    Show Archive:
                                </label>
                                <input class="form-check-input mt-0" type="checkbox" value="" id="" />
                            </div> -->
                        </div>
                        <div class="field-wrapper w-50 d-flex align-items-center justify-content-center">
                            <h4 class="text-center mb-0">Gonzalez Fortunato</h4>
                        </div>
                        <div class="field-wrapper d-flex align-items-center">
                            <label class="form-check-label me-2" for="">
                                <i class="icon icon-scan me-2"></i>
                                Print All
                            </label>
                            <!-- <input
                class="form-check-input mt-0"
                type="checkbox"
                value=""
                id="flexCheckDefault"
              /> -->
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Table list -->
                    <table class="hrdetail-table w-100 sticky-top">
                        <thead class="w-100">
                            <th class="text-start" style="width: 43%">Form Name</th>
                            <th class="">Issue Date</th>
                            <th class="">Exp. Date</th>
                            <th class="">Required</th>
                            <th class="">Verified</th>
                            <th style="width: 4%">
                                <!-- <i class="icon icon-edit"></i>
                  <i class="icon icon-delete"></i> -->
                            </th>
                        </thead>
                    </table>
                    <div class="accordion" id="accordionExample">
                        @foreach ($charts->category_chart as $category => $data)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#{{ preg_replace('/[^a-zA-Z0-9\']/', '_', $category) }}" aria-expanded="false">
                                        Category: {{ $category }} ({{count($data)}})

                                    </button>
                                </h2>
                                <div id="{{ preg_replace('/[^a-zA-Z0-9\']/', '_', $category) }}"
                                    class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                                    <div class="accordion-body">

                                        <table class="w-100">
                                            <tbody class="w-100">
                                                @foreach ($data as $chart)
                                                    <tr>
                                                        <td class="text-start chart_name" style="width: 41%"
                                                            onclick="openDocument({{ json_encode($chart) }},event)">
                                                            {{ $chart['name'] }}
                                                        </td>
                                                        @php
                                                            $issue_date = $chart['document'] ? update_date_format($chart['document']['issue_date']) : "";
                                                            $renewal_date = $chart['document'] ? update_date_format($chart['document']['renewal_date']) : "";
                                                        @endphp
                                                        <td class="" style="width: 20%" >{{ @$issue_date }}</td>
                                                        <td class="" style="width: 15%" >{{ @$renewal_date }}</td>
                                                        <td style="width: 10%" >
                                                            @php   
                                                            
                                                                if($chart['required'] == 1){
                                                                    $is_required = "Y";
                                                                }else{
                                                                    $is_required = "N";
                                                                }
                                                            @endphp
                                                            {{$is_required}}
                                                        </td>
                                                        <td style="width: 10%" >
                                                            @php   
                                                            $is_document_verified = $chart['document'] ? $chart['document']['is_verified'] : 0;
                                                            if($is_document_verified == 1){
                                                                $is_verified = "Y";
                                                            }else{
                                                                $is_verified = "N";
                                                            }
                                                        @endphp
                                                        {{$is_verified}}
                                                            
                                                        </td>
                                                        <td class="">
                                                            @php                      
                                                            if(is_admin()){                            
                                                            @endphp
                                                            <i class="icon icon-edit" onclick="openEditDocumentDetail({{ $chart['id']}},'{{$issue_date}}','{{$is_document_verified }}')"></i>
                                                            <!-- <i class="icon icon-delete"></i> -->
                                                            @php       
                                                            }
                        @endphp
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <!-- Table list -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="attachment-wrapper document_preview">
                    <div class="d-flex justify-content-between">
                        <h3>Attachments</h3>
                        <div class="right-side d-flex align-items-center">
                            @php                      
                            if(is_admin()){                            
                            @endphp
                            <div class="field-wrapper d-flex align-items-center me-5">
                                <label class="form-check-label me-2" for="">
                                    Show deleted files:
                                </label>
                                <div class="flex-field">

                                    <input data-url="{{route('document.get_deleted_documents')}}" class="form-check-input mt-0" type="checkbox" value="1" id="show_deleted_documents"
                                        onclick="showDeletedDocuments(this.checked)" />
                                </div>
                            </div>
                            @php                      
                         }                     
                        @endphp
                            <button class="btn-with-text">
                                <i class="icon icon-scan me-2"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 cta-wrapper d-flex justify-content-between">
                        @php                      
                        if(is_admin()){                            
                        @endphp
                        <div>
                            
                            <button class="sm-button" onclick="uploadForm()">Upload</button>
                            <button class="sm-button me-3" onclick="downloadFile()">Download</button>
                            <a id="linkID"></a>
                        </div>
                        <div>
                            
                            <button class="sm-button danger" id="delete_document_btn" data-id="" data-url="{{route('document.delete_document')}}" onclick="open_delete_document()">Delete</button>
                        </div>
                        @php                      
                    }                           
                        @endphp
                    </div>
                </div>
                <div id="deleted-files" class="deleted-files-wrapper d-none w-100 gap-3 mt-4 document_preview">
                    <table class="w-100">
                        <tbody class="w-100 deleted_files">
                            
                            <!-- <tr>
                               <button class="sm-button primary me-3"  onclick="scanForm()">Scan forms</button> 
                                <td class="text-start">
                                    <i class="icon icon-doc me-2"></i>Document 2
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">
                                    <i class="icon icon-doc me-2"></i>Document 3
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">
                                    <i class="icon icon-doc me-2"></i>Document 4
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">
                                    <i class="icon icon-doc me-2"></i>Document 5
                                </td>
                            </tr> -->
                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="pdf-view-wrapper mt-4 document_preview">
                    <span id="document_text"></span>
                    <embed src="../sample.pdf" type="application/pdf" id="document" width="100%" height="800px" />
                </div>
            </div>
        </div>
    </div>

    <!-- Add  Upload Form-->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        File Upload
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="upload" method="POST" class="ajax-form"
                        action="{{ route('upload_document') }}" role="form">
                        <input type="hidden" name="chart_id" id="chart_id"/>
                        <div class="form-wrapper">
                            <div class="field-wrapper"> 
                                <div class="d-block"> 
                                    <button id="upload_button" name="button" type="button" value="Upload"
                                        onclick="thisFileUpload();" style="background-color: #606060; flex: 0.7">
                                        Upload Document
                                    </button> 
                                </div>
                                <input type="file" class="" id="customFile" name="document"
                                placeholder="Upload Signature"
                                onchange="previewFile('document', 'upload_button')"
                                accept=".pdf"  style="opacity:0; height:0; position: absolute;"/>
                            
                                <input type="hidden" name="user_id" id="hidden_user_id" value="{{ request()->id }}">

                            </div>
                            <div class="cta_wrapper d-flex justify-content-center gap-5">
                                <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                                <button class="success" id="upload_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> 
    <!-- Edit Document Modal-->
     <!-- Scan Form-->
     <!--  <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLongTitle">
                     Scan File
                 </h5>
             </div>
             <div class="modal-body"> 
                 <form id="upload" method="POST" class="ajax-form"
                     action="{{ route('upload_document') }}" role="form">
                     <input type="hidden" name="chart_id" id="chart_id"/>
                     <div class="form-wrapper">
                         {{-- <div class="field-wrapper"> 
                             <div class="d-block"> 
                                 <button id="upload_button" name="button" type="button" value="Upload"
                                     onclick="thisFileUpload();" style="background-color: #606060; flex: 0.7">
                                     Upload Document
                                 </button> 
                             </div>
                             <input type="file" class="" id="customFile" name="document"
                             placeholder="Upload Signature"
                             onchange="previewFile('document', 'upload_button')"
                             accept=".pdf"  style="opacity:0; height:0; position: absolute;"/>
                         
                             <input type="hidden" name="user_id" id="hidden_user_id" value="{{ request()->id }}">

                         </div>
                         <div class="cta_wrapper d-flex justify-content-center gap-5">
                             <button class="danger cancel_btn" type="button" data-dismiss="modal">Cancel</button>
                             <button class="success" id="upload_btn">Save</button>
                         </div> --}}
                         {{-- <select size="1" id="source" style="position:relative;" onchange="source_onchange()"> 
                        </select> --}}
                        <div id="dwtcontrolContainer"></div>
                        <div class="cta_wrapper d-flex justify-content-center gap-5">
                            <button type="button"  class="success" onclick="loadImage();" >Load Image</button>
                            <button type="button"  class="success"  onclick="acquireImage();" >Scan</button>
                            <button id="btnUpload"  class="success" type="button" onclick="upload()">Upload</button>
                        </div>
                    </div>
                 </form>
             </div>

         </div>
     </div>
 </div> -->
 <!-- Scan Modal-->

<div
class="modal fade"
id="editDocumentDetail"
tabindex="-1"
role="dialog"
aria-labelledby="exampleModalCenterTitle"
aria-hidden="true"
>
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="add_phone_form_title">
        Edit Document Detail
      </h5>
    </div>
    <form id="edit_document_form" action="{{route('document.update_details')}}" class="ajax-form">
    <div class="modal-body">
      
        <div class="form-wrapper">
          
        <input type="hidden" name="user_id" value="{{@request()->id}}">
        <input type="hidden" id="hidden_id" name="id">
        
          
          <div class="field-wrapper">
            <label for="fname">Issue Date</label>
            <div  class="date" data-date-format="mm/dd/yyyy">
                <input required type="text" name="issue_date" id="issue_date" readonly placeholder="Issue Date" />
                <span class="input-group-addon d-none">
                    <i class="icon icon-eye"></i>
                </span>
            </div>
          </div>

          <div class="field-wrapper">
            <label for="mname">Verified</label>
            <div class="checkbox-tick-wrapper default d-flex align-items-center">
              <label class="d-flex align-items-center">
                  <input type="checkbox" name="is_verified" id="is_verified" value="1"/>
                  <span class="cr me-3"><i class="icon icon-tick-white"></i></span>
                  
              </label>
          </div>
          </div>
          
        </div>
     
    </div>
    <div class="cta_wrapper d-flex justify-content-center gap-5">
      <button class="danger"  type="button" data-dismiss="modal">
        Clear
      </button>
      <button class="success save-btn" id="add_document_detail">Save</button>
    </div>
  </form>
  </div>
</div>
</div>

<!---End---->
@endsection
