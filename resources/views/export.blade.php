<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Stimulsoft Reports.PHP - Viewer</title>
    <style>
        html,
        body {
            font-family: sans-serif;
        }
    </style>
    <?php
    /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_deployment.htm */
    $js = new \Stimulsoft\StiJavaScript(\Stimulsoft\StiComponentType::Viewer);
    $js->renderHtml();
    ?>

    <script type="text/javascript">
        <?php
        $handler = new \Stimulsoft\StiHandler(false);
        $handler->options->url = 'handler';
        $handler->license->setKey('6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHnt168zTPZf3RjtXX/GPHORFWN2aDWDyF73bD4JRMf7ce', 'XndDiUXw1Wcr7kyFhjgI1V+rk8rZWpAWiKRXC/a2hgbgjC7vAuu9XPAZxXM2BnntPcqyibHmfDS/zyycKI7sRr', 'La1CCUNUjYhZxEqywkhTWHnd6yoUpi90GanEUwMtRyuheK0+S3qNkpWp8407U4RIQNUVUK9FPteIgTbZ3M5Mbn', 'SIyKnB8jbfyrxeI8GPoNHltLCKuOP9hoEZelWZ2PXBMhzaOH+f43ecZ0V+uheVe/rYmDB6XGgxVZ8Fz+PRqco7', 'Suua4h+F2LgZFOOqmR11SPZsqQiMqMBEbToZMw8hOTe8wDGuoR6GpRNd5MjoSX6dpKA2gUuimK9M/IEgftHnTp', '9uj0DGjs2Uq/YIRZiXNaMTGzy33DH4LN8cpv7kkC5lZB2Jv2Dx42PyW2HD/cahVCxXvkQbIgVpo9660hQeR2sK', 'kixXrRMCcRQihRBGS//5RGUiyhdvKv7TPmP6/BMkGY5CDPLFzR8fwDpS9TMc');
        $handler->license->setFile('license.key');
        $handler->renderHtml();
        ?>

      
        function onLoad() {
            // Load and show report
            var report = new Stimulsoft.Report.StiReport();
            report.loadFile("public/reports/66967672c6f76.mrt");

            console.log('report', report)
            var user = report.dictionary.variables.getByName("userId");
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const userId = urlParams.get('userId')
            const reportId = urlParams.get('reportId')
            if (user && userId) {
                user.value = userId;
            }
            report.renderAsync(function() {
                var pdfData = report.exportDocument(Stimulsoft.Report.StiExportFormat.Pdf);

                var blob = new Blob([new Uint8Array(pdfData)], {
                    type: "application/pdf"
                });

                if (window.navigator && window.navigator.msSaveOrOpenBlob) {
                    // Internet Explorer does not support the output of blob data, only save as PDF file
                    var fileName = String.isNullOrEmpty(report.reportAlias) ? report.reportName : report
                        .reportAlias;
                    window.navigator.msSaveOrOpenBlob(blob, fileName + ".pdf");
                } else {
                    // Show the new tab with the blob data
                    var fileURL = URL.createObjectURL(blob);
                    window.open(fileURL, "_self");
                };
            });
        }
        // var report = new Stimulsoft.Report.StiReport();
        // report.loadFile("public/reports/66967672c6f76.mrt");
        // report.renderAsync(function() {
        //     var settings = new Stimulsoft.Report.Export.StiPdfExportSettings();
        //     var service = new Stimulsoft.Report.Export.StiPdfExportService();
        //     var stream = new Stimulsoft.System.IO.MemoryStream();
        //     service.exportTo(report, stream, settings);

        //     var data = stream.toArray();

        //     // making a file from Stimulsoft Stream
        //     var blob = new Blob([new Uint8Array(data)], { type: "application/pdf" });
        //     var resultFile = new File([blob], "test.pdf", { type: "application/pdf" });
        //     var a = document.createElement("a");
        //         let url = window.URL.createObjectURL(blob);
        //         a.href = url;
        //         a.download = "test.pdf";
        //         a.click();
        //         window.URL.revokeObjectURL(url);
        //     console.log(resultFile);
        // });
        // console.log(report);
    </script>
</head>

<body onload="onLoad();"> 
</body>

</html>
