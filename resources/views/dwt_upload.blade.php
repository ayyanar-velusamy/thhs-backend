<!DOCTYPE html>
<html>

<head>
    <title>Dynamic Web TWAIN for Laravel</title>
    <script type="text/javascript" src="https://unpkg.com/dwt/dist/dynamsoft.webtwain.min.js"></script>
    {{-- <script src="{{ asset('js/dynamsoft.webtwain.initiate.js') }}" ></script>
    <script src="{{ asset('js/dynamsoft.webtwain.config.js') }}" ></script> --}}
    <meta name="_token" content="{{ csrf_token() }}" />
</head>

<body>
    <h3>Dynamic Web TWAIN for Laravel</h3>
    <select size="1" id="source" style="position:relative;" onchange="source_onchange()"> 
    </select>
    <div id="dwtcontrolContainer"></div>
    <input type="button" value="Load Image" onclick="loadImage();" />
    <input type="button" value="Scan Image" onclick="acquireImage();" />
    <input id="btnUpload" type="button" value="Upload Image" onclick="upload()">

    <script>
        var DWObject;
        var deviceList = [];

        window.onload = function() {
            if (Dynamsoft) {
                Dynamsoft.DWT.AutoLoad = false;
                Dynamsoft.DWT.UseLocalService = true;
                Dynamsoft.DWT.Containers = [{
                    ContainerId: 'dwtcontrolContainer',
                    Width: '640px',
                    Height: '640px'
                }];
                Dynamsoft.DWT.RegisterEvent('OnWebTwainReady', Dynamsoft_OnReady);
                // https://www.dynamsoft.com/customer/license/trialLicense?product=dwt
                Dynamsoft.DWT.ProductKey =
                    't01898AUAAIpZ6/sGXPFqczt979KsP/uHK5IH+WsQOnJPTglWwm85y5QZLVAzEim6uwj08hQGdOwB5s/BHvwmKmmxi+AFSk3XLyc7OLW9U6W9Ex2cfOQUmbeh33d72OalCYzAewP0PA4ngBzYaymAjztqgwXQAtQA1KoBFnC7ivrnU8qA5F//2dDkZAentnfmAWnjRAcnHzlDQMZwSS5htcseEOQn5wLQAvQWwHGRVQGREqAFaAVQdXaTYAVAVysq';
                Dynamsoft.DWT.ResourcesPath = 'https://unpkg.com/dwt/dist/';

                Dynamsoft.DWT.Load();
            }

        };

        function Dynamsoft_OnReady() {
            DWObject = Dynamsoft.DWT.GetWebTwain('dwtcontrolContainer');
            var token = document.querySelector("meta[name='_token']").getAttribute("content");
            DWObject.SetHTTPFormField('_token', token);

            let count = DWObject.SourceCount;
            let select = document.getElementById("source");

            DWObject.GetDevicesAsync().then(function(devices) {
                for (var i = 0; i < devices.length; i++) { // Get how many sources are installed in the system
                    let option = document.createElement('option');
                    option.value = devices[i].displayName;
                    option.text = devices[i].displayName;
                    deviceList.push(devices[i]);
                    // select.appendChild(option);
                   
                    select.options.add(new Option(devices[i].displayName, i)); // Add the sources in a drop-down list
        
                    // twainsource.options.add(new Option(devices[i].displayName, i)); 
                }
            }).catch(function(exp) {
                alert(exp.message);
            });
        }

        function loadImage() {
            var OnSuccess = function() {};
            var OnFailure = function(errorCode, errorString) {};

            if (DWObject) {
                DWObject.IfShowFileDialog = true;
                DWObject.LoadImageEx("", Dynamsoft.DWT.EnumDWT_ImageType.IT_ALL, OnSuccess, OnFailure);
            }
        }

        function acquireImage() {
            if (DWObject) {
                var sources = document.getElementById('source');
                if (sources) {
                    DWObject.SelectDeviceAsync(deviceList[sources.selectedIndex]).then(function() {
                        return DWObject.AcquireImageAsync({
                            IfShowUI: false,
                            IfCloseSourceAfterAcquire: true
                        });
                    }).catch(function(exp) {
                        alert(exp.message);
                    });
                }
            }
        }

        function upload() {
            var OnSuccess = function(httpResponse) {
                alert("Succesfully uploaded");
            };

            var OnFailure = function(errorCode, errorString, httpResponse) {
                alert(httpResponse);
            };

            var date = new Date();
            DWObject.HTTPUploadThroughPostEx(
                "{{ route('dwtupload_upload') }}",
                DWObject.CurrentImageIndexInBuffer,
                '',
                date.getTime() + ".jpg",
                1, // JPEG
                OnSuccess, OnFailure
            );
        }

        function source_onchange() {



            if (document.getElementById("source")) {
                var cIndex = document.getElementById("source").selectedIndex;
                if (!Dynamsoft.Lib.env.bWin) {
                    if (document.getElementById("lblShowUI"))
                        document.getElementById("lblShowUI").style.display = "none";
                    if (document.getElementById("ShowUI"))
                        document.getElementById("ShowUI").style.display = "none";
                } else {
                    DWObject.SelectDeviceAsync(deviceList[cIndex]);

                    var showUI = document.getElementById("ShowUI");
                    if (showUI) {
                        if (deviceList[cIndex] && deviceList[cIndex].displayName && deviceList[cIndex].displayName.indexOf(
                                "WIA-") == 0) {
                            showUI.disabled = true;
                            showUI.checked = false;
                        } else
                            showUI.disabled = false;
                    }
                }
            }
        }
    </script>

</body>

</html>
