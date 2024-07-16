<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Stimulsoft Reports.PHP - Designer</title>
    <style>
        html,
        body {
            font-family: sans-serif;
        }
    </style>

    <?php
    /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_designer_deployment.htm */
    $js = new \Stimulsoft\StiJavaScript(\Stimulsoft\StiComponentType::Designer);
    $js->renderHtml();
    ?>

    <script type="text/javascript">
        <?php
       
        $handler = new \Stimulsoft\StiHandler();
        $handler->options->url = 'handler';
        $handler->license->setKey('6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHnt168zTPZf3RjtXX/GPHORFWN2aDWDyF73bD4JRMf7ce',
    'XndDiUXw1Wcr7kyFhjgI1V+rk8rZWpAWiKRXC/a2hgbgjC7vAuu9XPAZxXM2BnntPcqyibHmfDS/zyycKI7sRr',
    'La1CCUNUjYhZxEqywkhTWHnd6yoUpi90GanEUwMtRyuheK0+S3qNkpWp8407U4RIQNUVUK9FPteIgTbZ3M5Mbn',
    'SIyKnB8jbfyrxeI8GPoNHltLCKuOP9hoEZelWZ2PXBMhzaOH+f43ecZ0V+uheVe/rYmDB6XGgxVZ8Fz+PRqco7',
    'Suua4h+F2LgZFOOqmR11SPZsqQiMqMBEbToZMw8hOTe8wDGuoR6GpRNd5MjoSX6dpKA2gUuimK9M/IEgftHnTp',
    '9uj0DGjs2Uq/YIRZiXNaMTGzy33DH4LN8cpv7kkC5lZB2Jv2Dx42PyW2HD/cahVCxXvkQbIgVpo9660hQeR2sK',
    'kixXrRMCcRQihRBGS//5RGUiyhdvKv7TPmP6/BMkGY5CDPLFzR8fwDpS9TMc');
        $handler->license->setFile('license.key');
        $handler->options->passQueryParameters = true;
        
        $handler->renderHtml();
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_designer_settings.htm */
        $options = new \Stimulsoft\Designer\StiDesignerOptions();
        $options->appearance->fullScreenMode = true;
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_designer_deployment.htm */
        $designer = new \Stimulsoft\Designer\StiDesigner($options);
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_engine_connecting_sql_data.htm */
        // $designer->onBeginProcessData = true;
        
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_designer_saving_report.htm */
        $designer->onSaveReport = true; 
     
        /** https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_and_dashboards_for_php_web_designer_creating_editing_report.htm */
        $report = new \Stimulsoft\Report\StiReport();
        
        if ($report_data['report_exist']) { 
            $report->loadFile('public/reports/' . $report_data['id'] . '.mrt');
        }
    
        $report->onBeforeRender = 'onBeforeRender';
        
      

       
        // $report->reportdescription=
        /*$var1 = new \Stimulsoft\Report\StiVariable('var1', \Stimulsoft\Report\StiVariableType::String, "abc");
        $report->dictionary->variables[] = $var1;

        $var2 = new \Stimulsoft\Report\StiVariable('var2', \Stimulsoft\Report\StiVariableType::Decimal, 4.34);
        $report->dictionary->variables[] = $var2;*/
        
        $designer->report = $report;
        ?>
       
        function onBeforeRender(args) { 
            // args.report.dictionary.variables.list[1].val = '1'; 
        }

        
        // After loading the HTML page, display the visual part of the Designer in the specified container.
        function onLoad() {
            <?php
            $designer->renderHtml('designerContent');
            ?>
        }
    </script>
</head>

<body onload="onLoad();">
    <div id="designerContent"></div>
</body>

</html>
