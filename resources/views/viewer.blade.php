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
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_settings.htm */
        $options = new \Stimulsoft\Viewer\StiViewerOptions();
        $options->toolbar->showSendEmailButton = true;
        $options->toolbar->displayMode = \Stimulsoft\Viewer\StiToolbarDisplayMode::Separated;
        $options->appearance->fullScreenMode = true;
        $options->appearance->scrollbarsMode = true;
        $options->height = '600px'; // Height for non-fullscreen mode
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_deployment.htm */
        $viewer = new \Stimulsoft\Viewer\StiViewer($options);
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_engine_connecting_sql_data.htm */
        $viewer->onBeginProcessData = true;
        // $viewer->onEndExportReport = true;
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_viewer_send_email.htm */
        // $viewer->onEmailReport = true;
        $viewer->onEndExportReport = true;
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_designer_creating_editing_report.htm */
        $report = new \Stimulsoft\Report\StiReport();
        
        if ($report_data['report_exist']) {
            $report->loadFile('public/reports/' . $report_data['id'] . '.mrt');
        }
        $report->onBeforeRender = 'onBeforeRender';
        
        // $report->render();
        $viewer->report = $report;
        // $report->exportDocument(\Stimulsoft\StiExportFormat::Pdf);
        // $report->renderHtml();
        
        //print_r($report);
        ?>


        function onBeforeRender(args) {
            // let var1 = new Stimulsoft.Report.Dictionary.StiVariable(
            //     '', 'var1', 'var1', '', Stimulsoft.System.Decimal,
            //     '4.34');
            // args.report.dictionary.variables.add(var1);
            // let var2 = new Stimulsoft.Report.Dictionary.StiVariable();
            // var2.name = "reportId"
            // var2.alias = "reportId"
            // var2.type = Stimulsoft.System.Int 
            // var2.value = 2
            // var2.allowUseAsSqlParameter = true
            // args.val 
            var report = args.report;
            var user = report.dictionary.variables.getByName("userId");
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const userId = urlParams.get('userId')
            if (user && userId) {
                user.value = userId;
            }
            // variableString.value = "Text value";
            // args.report.dictionary.variables.list[0].val = '2'; 
            // args.report.dictionary.variables.add(var2);
        }
        // After loading the HTML page, display the visual part of the Viewer in the specified container.
        function onLoad() {
            <?php
            $viewer->renderHtml('viewerContent');
            ?>
        }
    </script>
</head>

<body onload="onLoad();">
    <div id="viewerContent"></div>
</body>

</html>
